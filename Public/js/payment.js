/*

Author: Huy Nguyen
Date: 2025-09-14
Purpose: Payment JS
*/

$(document).ready(function () {
    // Payment Modal Functionality
    const paymentModal = $('#paymentModal');
    const closePaymentModal = $('#closePaymentModal');
    const closePaymentModalBtn = $('#closePaymentModalBtn');
    const refreshQR = $('#refreshQR');
    const qrCodeContainer = $('#qrCodeContainer');
    const paymentStatusElement = $('#paymentStatus');

    let currentInvoiceId = null;
    let currentQRCode = null;
    let paymentCheckInterval = null;
    let isPaymentCompleted = false;

    // Open payment modal
    $('.btn-payment').click(function () {
        isPaymentCompleted = false;
        const invoiceId = $(this).data('invoice-id');

        if (invoiceId) {
            openPaymentModal(invoiceId);
            // Clear any existing interval before starting new one
            if (paymentCheckInterval) {
                clearInterval(paymentCheckInterval);
            }
            // Start checking payment status every 1 second
            paymentCheckInterval = setInterval(() => checkPaymentStatus(invoiceId), 1000);
        }
    });

    // check payment status
    function checkPaymentStatus(invoiceId) {
        if (isPaymentCompleted) return;

        // Make AJAX call to check payment status
        $.ajax({
            type: 'POST',
            url: App.appURL + 'customer/payment/check-status',
            data: {
                invoice_id: invoiceId,
                csrf_token: App.getToken(),
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    if (response.payment_status === 'paid') {
                        // Payment successful, stop checking
                        isPaymentCompleted = true;
                        clearInterval(paymentCheckInterval);
                        paymentCheckInterval = null;
                        updatePaymentStatus('success');
                        App.setToken(response.token);
                        showSuccess('Thanh toán thành công!');
                        $('.invoice-item-status').text('Đã thanh toán');
                        setTimeout(() => {
                            closePaymentModalFunc();
                            $('.btn-payment').addClass('hidden pointer-events-none opacity-50');
                        }, 3000);
                    } else {
                        updatePaymentStatus('pending');
                    }
                }
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON.payment_status === 'failed') {
                    updatePaymentStatus('pending');
                    App.setToken(xhr.responseJSON.token);
                }
            },
        });
    }

    // Close payment modal
    [closePaymentModal, closePaymentModalBtn].forEach(function (button) {
        button.click(function () {
            closePaymentModalFunc();
        });
    });

    // Refresh QR code
    refreshQR.click(function () {
        if (currentInvoiceId) {
            loadPaymentData(currentInvoiceId);
        }
    });

    // Close modal when clicking outside
    paymentModal.click(function (e) {
        if (e.target === paymentModal) {
            closePaymentModalFunc();
        }
    });

    // Function to open payment modal
    function openPaymentModal(invoiceId) {
        currentInvoiceId = invoiceId;
        paymentModal.removeClass('hidden');
        loadPaymentData(invoiceId);
    }

    // Function to close payment modal
    function closePaymentModalFunc() {
        paymentModal.addClass('hidden');
        currentInvoiceId = null;
        currentQRCode = null;
        // Clear the payment check interval when closing modal
        if (paymentCheckInterval) {
            clearInterval(paymentCheckInterval);
            paymentCheckInterval = null;
        }
    }

    // Function to load payment data
    function loadPaymentData(invoiceId) {
        // Show loading state
        showQRLoading();

        $.ajax({
            type: 'POST',
            url: App.appURL + 'customer/payment',
            data: {
                invoice_id: invoiceId,
                csrf_token: App.getToken(),
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    updateInvoiceInfo(response.data, response.roomInfo, response.bankingInfo);
                    displayQRCode(response.qrCode);
                    currentQRCode = response.qrCode;
                    App.setToken(response.token);
                } else {
                    showError('Không thể tải thông tin thanh toán: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                toastr['error'](xhr.responseJSON.message);
                App.setToken(xhr.responseJSON.token);
            },
        });
    }

    // Function to convert string to number
    function toNumber(value) {
        return isNaN(parseFloat(value)) ? 0 : parseFloat(value);
    }

    // Function to update invoice information
    function updateInvoiceInfo(invoice, roomInfo, bankingInfo) {
        // Update invoice header
        $('#invoiceNumber').text(`Hóa đơn #HD-${invoice.invoice_month}`);
        $('#roomInfo').text(`${roomInfo.room_name} - ${roomInfo.house_name}`);
        $('#totalAmount').text(formatCurrency(toNumber(invoice.total)));

        // Update payment breakdown
        $('#rentAmount').text(formatCurrency(toNumber(invoice.rental_amount)));
        $('#electricAmount').text(formatCurrency(toNumber(invoice.electric_amount)));
        $('#waterAmount').text(formatCurrency(toNumber(invoice.water_amount)));
        $('#serviceAmount').text(formatCurrency(toNumber(invoice.service_amount) + toNumber(invoice.parking_amount) + toNumber(invoice.other_amount)));
        $('#totalAmountDetail').text(formatCurrency(toNumber(invoice.total)));

        // Update banking information
        $('#bank-name').text(bankingInfo.bank_name);
        $('#bank-number').text(bankingInfo.bank_number);
        $('#bank-user-name').text(bankingInfo.user_name);
    }

    // Function to display QR code
    function displayQRCode(qrCodeUrl) {
        qrCodeContainer.html(`
                    <div class="w-full h-full flex items-center justify-center">
                        <img src="${qrCodeUrl}" alt="QR Code" class="max-w-full max-h-full object-contain rounded-lg shadow-lg">
                    </div>
                `);
    }

    // Function to show QR loading state
    function showQRLoading() {
        qrCodeContainer.html(`
                    <div class="text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-3"></div>
                        <p class="text-gray-600 font-medium text-sm">Đang tạo mã QR...</p>
                        <p class="text-gray-500 text-xs mt-1">Vui lòng chờ trong giây lát</p>
                    </div>
                `);
    }

    // Function to update payment status
    function updatePaymentStatus(status) {
        if (status === 'success') {
            paymentStatusElement.html(`
                        <div class="bg-green-100 border-2 border-green-300 rounded-lg p-2 shadow-sm">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 mr-1 text-xs"></i>
                                <span class="text-green-800 font-bold text-xs">Thanh toán thành công</span>
                            </div>
                            <p class="text-green-700 text-xs text-center mt-1">
                                Hóa đơn đã được cập nhật
                            </p>
                        </div>
                    `);
        } else if (status === 'pending') {
            paymentStatusElement.html(`
                        <div class="bg-yellow-100 border-2 border-yellow-300 rounded-lg p-2 shadow-sm">
                            <div class="flex items-center justify-center">
                                <div class="animate-pulse">
                                    <i class="fas fa-clock text-yellow-600 mr-1 text-xs"></i>
                                </div>
                                <span class="text-yellow-800 font-bold text-xs">Chờ thanh toán</span>
                            </div>
                            <p class="text-yellow-700 text-xs text-center mt-1">
                                Vui lòng quét mã QR để thanh toán
                            </p>
                        </div>
                    `);
        }
    }

    // Function to show success message
    function showSuccess(message) {
        // You can use toastr or any other notification library
        if (typeof toastr !== 'undefined') {
            toastr['success'](message);
        } else {
            alert(message);
        }
    }

    // Function to show error message
    function showError(message) {
        if (typeof toastr !== 'undefined') {
            toastr['error'](message);
        } else {
            alert(message);
        }
    }

    // Utility functions
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
        }).format(amount);
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN');
    }

    function getStatusText(status) {
        const statusMap = {
            pending: 'Chưa thanh toán',
            paid: 'Đã thanh toán',
            overdue: 'Quá hạn',
        };
        return statusMap[status] || status;
    }
});
