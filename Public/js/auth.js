/*
	Author: Huy Nguyen
	Date: 01/09/2025
	Purpose: Handle Authentication logic
*/

$(document).ready(function () {
    // OTP Input handling
    const otpInputs = $('[data-otp]');
    const completeOtpInput = $('#completeOtp');
    const verifyBtn = $('#verifyBtn');
    const resendBtn = $('#resendOtp');
    const countdownSpan = $('#countdown');

    let countdown = 60;
    let countdownTimer;
    let isVerifying = false;

    // Auto-focus next input when typing
    otpInputs.each((index, input) => {
        input.addEventListener('input', function () {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');

            if (this.value.length === 1) {
                if (index < otpInputs.length - 1) {
                    otpInputs.eq(index + 1).focus();
                }
            }
            updateCompleteOtp();
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                otpInputs.eq(index - 1).focus();
            }
        });
    });

    // Update complete OTP value
    function updateCompleteOtp() {
        const otpValue = Array.from(otpInputs)
            .map((input) => input.value)
            .join('');
        completeOtpInput.val(otpValue);
    }

    // Handle OTP form submission
    $('#otpForm').on('submit', function (e) {
        e.preventDefault();

        if (isVerifying) return;

        // Start verification
        isVerifying = true;
        verifyBtn.attr('disabled', true);
        verifyBtn.html('<i class="fas fa-spinner fa-spin mr-3 text-lg"></i>Đang xác thực...');

        // Simulate API call
        setTimeout(() => {
            this.submit();
        }, 1500);
    });

    // Resend OTP functionality
    resendBtn.on('click', function () {
        if (countdown <= 0 && !isVerifying) {
            startCountdown();

            // Show temporary message
            const originalText = resendBtn.text();
            resendBtn.text('Đang gửi...');
            resendBtn.attr('disabled', true);

            setTimeout(() => {
                resendBtn.text(originalText);
                resendBtn.attr('disabled', false);
            }, 2000);
        }

        // Handle resend OTP
        JsLoadingOverlay.show();

        $.ajax({
            type: 'POST',
            url: App.appURL + '/resend-otp',
            data: {
                csrf_token: App.getToken(),
            },
            dataType: 'json',
            success: function (response) {
                JsLoadingOverlay.hide();
                toastr['success'](response.success.msg);
                App.setToken(response.token);
            },
            error: function (xhr, status, error) {
                JsLoadingOverlay.hide();
                toastr['error'](xhr.responseJSON.error.msg);
                App.setToken(xhr.responseJSON.token);
            },
        });
    });

    // Countdown timer
    function startCountdown() {
        countdown = 60;
        resendBtn.attr('disabled', true);
        resendBtn.addClass('text-gray-400 cursor-not-allowed');

        countdownTimer = setInterval(() => {
            countdown--;
            countdownSpan.text(countdown);

            if (countdown <= 0) {
                clearInterval(countdownTimer);
                resendBtn.attr('disabled', false);
                resendBtn.removeClass('text-gray-400').removeClass('cursor-not-allowed');
                countdownSpan.text('0');
            }
        }, 1000);
    }

    // Start countdown on page load
    startCountdown();

    // Focus first input on page load
    otpInputs.eq(0).focus();
});
