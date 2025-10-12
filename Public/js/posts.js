$(document).ready(function () {
    // Prevent multiple initialization
    if (window.imageUploadInitialized) {
        return;
    }
    window.imageUploadInitialized = true;

    const imageUpload = $('#imageUpload');
    const imagePreview = $('#imagePreview');
    const imageCounter = $('#imageCounter');
    let selectedFiles = [];
    const maxFiles = 5;

    // Define functions first
    function updateCounter() {
        imageCounter.text(`${selectedFiles.length}/${maxFiles} ảnh đã chọn`);

        // Update counter color based on count
        imageCounter.removeClass('text-red-500 text-emerald-600 text-gray-500 font-medium');

        if (selectedFiles.length === maxFiles) {
            imageCounter.addClass('text-red-500 font-medium');
        } else if (selectedFiles.length > 0) {
            imageCounter.addClass('text-emerald-600 font-medium');
        } else {
            imageCounter.addClass('text-gray-500');
        }
    }

    function togglePreviewVisibility() {
        if (selectedFiles.length > 0) {
            imagePreview.removeClass('hidden');
            imagePreview.addClass('grid');
        } else {
            imagePreview.addClass('hidden');
            imagePreview.removeClass('grid');
        }
    }

    function displayImage(file, index) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const imageContainer = $('<div>').addClass('relative group');
            imageContainer.html(`
					<img src="${e.target.result}" alt="Preview" class="w-full h-24 object-cover rounded-lg border border-gray-200">
					<button type="button" onclick="removeImage(${index})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
						<i class="fas fa-times"></i>
					</button>
					<div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all rounded-lg"></div>
				`);
            imagePreview.append(imageContainer);
        };
        reader.readAsDataURL(file);
    }

    function refreshImageDisplay() {
        imagePreview.html('');
        selectedFiles.forEach((file, index) => {
            displayImage(file, index);
        });
    }

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach((file) => {
            dt.items.add(file);
        });
        imageUpload[0].files = dt.files;
    }

    // Reset function to clear any existing state
    function resetImageUpload() {
        selectedFiles = [];
        imagePreview.html('');
        imagePreview.addClass('hidden');
        imagePreview.removeClass('grid');
        updateCounter();
    }

    // Make resetImageUpload globally accessible
    window.resetImageUpload = resetImageUpload;

    // Initialize with clean state
    resetImageUpload();

    // Remove any existing event listeners first
    imageUpload.off('change');

    imageUpload.on('change', function (e) {
        const files = Array.from(e.target.files);

        // Validate all files first
        let validFiles = [];

        files.forEach((file) => {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert(`File "${file.name}" không phải là ảnh!`);
                return;
            }

            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert(`File "${file.name}" vượt quá 10MB!`);
                return;
            }

            validFiles.push(file);
        });

        // Check total file count with valid files
        if (selectedFiles.length + validFiles.length > maxFiles) {
            const allowedCount = maxFiles - selectedFiles.length;
            alert(`Bạn chỉ có thể chọn thêm ${allowedCount} ảnh nữa! (tối đa ${maxFiles} ảnh)`);
            return;
        }

        // Add valid files to selectedFiles
        selectedFiles = selectedFiles.concat(validFiles);

        // Refresh display once
        refreshImageDisplay();
        updateCounter();
        togglePreviewVisibility();
        updateFileInput();
    });

    window.removeImage = function (index) {
        selectedFiles.splice(index, 1);
        refreshImageDisplay();
        updateCounter();
        togglePreviewVisibility();
        updateFileInput();
    };

    // show modal
    $('button#openModalBtn').on('click', function () {
        $('#modalNewPost-title').text('Thêm tin đăng');
        $('#errorMessage').text('');
        $('.modal-action').find('button').text('Thêm tin đăng').removeClass('pointer-events-none opacity-50 updatePostBtn').addClass('addNewPostBtn');
        $('form#formNewPost')[0].reset();
        // Reset current post ID for new post
        currentPostId = null;
        // Reset image upload to clear any existing images
        if (typeof resetImageUpload === 'function') {
            resetImageUpload();
        }
    });

    // Handle form submission - remove existing listener first
    $(document).off('click', 'button.addNewPostBtn');
    // Add new post
    $(document).on('click', 'button.addNewPostBtn', function (e) {
        preventDefaults(e);

        $('.cleave-input').each(function () {
            this.value = this.value.replace(/,/g, '');
        });

        const formData = new FormData($('form#formNewPost')[0]);

        $.ajax({
            url: App.appURL + 'landlord/posts/create',
            type: 'POST',
            data: formData, // Gửi trực tiếp FormData
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    showSuccessMessage(response.message);
                    // Reset form nếu cần
                    $('.modalNewPost-button-close').trigger('click');
                    $('form#formNewPost')[0].reset();
                    App.setToken(response.token);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function (xhr, status, error) {
                $('#errorMessage').text(xhr.responseJSON.error);
                App.setToken(xhr.responseJSON.token);
                return;
            },
        });
    });

    let currentPostId = null;

    window.viewPost = function (postId) {
        // Set current post ID for update
        currentPostId = postId;
        $('input[name="post_id"]').val(postId);

        $('#openModalBtn').trigger('click');
        $('#modalNewPost-title').text('Chỉnh sửa tin đăng');
        $('.modal-action').find('button').text('Cập nhật').removeClass('addNewPostBtn').addClass('pointer-events-none opacity-50 updatePostBtn');
        // Reset form trước
        $('form#formNewPost')[0].reset();

        // Load dữ liệu tỉnh thành trước
        App.setProvinceData($('select[name="province"]')).then(function () {
            // Sau khi load tỉnh thành xong, gọi API lấy dữ liệu post
            $.ajax({
                type: 'GET',
                url: App.appURL + 'landlord/posts/get',
                data: {
                    post_id: postId,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        const post = response.post;

                        // Set dữ liệu cơ bản
                        $('input[name="title"]').val(post.rental_post_title);
                        $('select[name="category"]').val(post.rental_category_id);
                        $('input[name="contact_name"]').val(post.contact);
                        $('textarea[name="description"]').val(post.description);
                        $('input[name="price"]').val(post.price);
                        $('input[name="promotional_price"]').val(post.price_discount);
                        $('input[name="deposit"]').val(post.rental_deposit);
                        $('input[name="area"]').val(post.area);
                        $('input[name="electricity_price"]').val(post.electric_fee);
                        $('input[name="water_price"]').val(post.water_fee);
                        $('select[name="max_occupants"]').val(post.max_number_of_people);
                        $('input[name="available_date"]').val(post.stay_start_date);
                        $('select[name="opening_time"]').val(post.rental_open_time);
                        $('select[name="closing_time"]').val(post.rental_close_time);
                        $('textarea[name="address"]').val(post.address);
                        $('input[name="contact_username"]').val(post.contact);
                        $('input[name="contact_phone"]').val(post.phone);

                        // Set tỉnh thành
                        $('select[name="province"]').val(post.province);

                        // Sau khi set tỉnh thành, load phường xã
                        if (post.province && post.ward) {
                            const provinceCode = $('select[name="province"] option:selected').data('code');
                            if (provinceCode) {
                                App.setWardData(provinceCode, $('select[name="ward"]')).then(function () {
                                    // Set phường xã sau khi load xong
                                    $('select[name="ward"]').val(post.ward);
                                });
                            }
                        }

                        // Set tiện ích (amenities)
                        if (post.rental_amenities) {
                            const amenities = JSON.parse(post.rental_amenities);

                            // Convert amenities to strings for comparison
                            const amenitiesStr = amenities.map((id) => id.toString());

                            $('input[name="amenities[]"]').each(function () {
                                const amenityId = $(this).val().toString();

                                if (amenitiesStr.includes(amenityId)) {
                                    $(this).prop('checked', true);
                                }
                            });
                        }

                        // Hiển thị hình ảnh
                        if (post.images) {
                            const images = JSON.parse(post.images);
                            displayExistingImages(images);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Error loading post:', xhr);
                    Swal.fire('Lỗi', 'Không thể tải dữ liệu tin đăng', 'error');
                },
            });
        });
    };

    // button update post
    $('form#formNewPost')
        .find('input, select, textarea')
        .on('input', function () {
            $('.modal-action').find('button').removeClass('pointer-events-none opacity-50');
        });

    // Update post
    $(document).on('click', 'button.updatePostBtn', function (e) {
        e.preventDefault();

        // Clean cleave inputs
        $('.cleave-input').each(function () {
            this.value = this.value.replace(/,/g, '');
        });
        currentPostId = $('input[name="post_id"]').val();
        const formData = new FormData($('form#formNewPost')[0]);
        formData.append('post_id', currentPostId);

        $.ajax({
            url: App.appURL + 'landlord/posts/update',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    showSuccessMessage(response.message);
                    $('.modalNewPost-button-close').trigger('click');
                    $('form#formNewPost')[0].reset();
                    if (typeof resetImageUpload === 'function') {
                        resetImageUpload();
                    }
                    App.setToken(response.token);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function (xhr, status, error) {
                $('#errorMessage').text(xhr.responseJSON.error);
                App.setToken(xhr.responseJSON.token);
            },
        });
    });

    window.updatePost = function (postId) {
        currentPostId = postId;
    };
    // Function để hiển thị hình ảnh hiện có
    function displayExistingImages(images) {
        const imagePreview = $('#imagePreview');
        const imageCounter = $('#imageCounter');
        imagePreview.empty();

        images.forEach(function (imageUrl, index) {
            const imageContainer = $('<div>').addClass('relative group');
            imageContainer.html(`
            <img src="${imageUrl}" alt="Preview" class="w-full h-24 object-cover rounded-lg border border-gray-200">
            <button type="button" class="remove-existing-image absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors" data-index="${index}">
                <i class="fas fa-times"></i>
            </button>
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all rounded-lg"></div>
        `);
            imagePreview.append(imageContainer);
        });

        // Thêm event listener cho nút xóa ảnh hiện có
        $('.remove-existing-image').on('click', function () {
            const index = $(this).data('index');
            removeExistingImage(index);
        });

        // Cập nhật counter
        imageCounter.text(`${images.length}/5 ảnh đã chọn`);
        imageCounter.removeClass('text-red-500 text-emerald-600 text-gray-500 font-medium');

        if (images.length === 5) {
            imageCounter.addClass('text-red-500 font-medium');
        } else if (images.length > 0) {
            imageCounter.addClass('text-emerald-600 font-medium');
        } else {
            imageCounter.addClass('text-gray-500');
        }
    }

    // Function để xóa hình ảnh hiện có
    function removeExistingImage(index) {
        $(`.relative.group`).eq(index).remove();

        // Cập nhật lại index cho các ảnh còn lại
        $('.remove-existing-image').each(function (newIndex) {
            $(this).attr('data-index', newIndex);
        });

        // Cập nhật counter sau khi xóa
        const remainingImages = $('.relative.group').length;
        const imageCounter = $('#imageCounter');

        imageCounter.text(`${remainingImages}/5 ảnh đã chọn`);
        imageCounter.removeClass('text-red-500 text-emerald-600 text-gray-500 font-medium');

        if (remainingImages === 5) {
            imageCounter.addClass('text-red-500 font-medium');
        } else if (remainingImages > 0) {
            imageCounter.addClass('text-emerald-600 font-medium');
        } else {
            imageCounter.addClass('text-gray-500');
        }
    }

    window.hidePost = function (postId, status) {
        Swal.fire({
            title: 'Xác nhận ẩn tin',
            text: 'Bạn có chắc chắn muốn ẩn tin này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: App.appURL + 'landlord/posts/hide',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        post_id: postId,
                        status: status,
                        csrf_token: App.getToken(),
                    },
                    success: (response) => {
                        if (response.status === 'success') {
                            showSuccessMessage(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: (xhr, status, error) => {
                        showErrorMessage(xhr.responseJSON.error);
                        App.setToken(xhr.responseJSON.token);
                        return;
                    },
                });
            }
        });
    };

    window.deletePost = function (postId) {
        Swal.fire({
            title: 'Xác nhận xóa tin',
            text: 'Bạn có chắc chắn muốn xóa tin này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: App.appURL + 'landlord/posts/delete',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        post_id: postId,
                        csrf_token: App.getToken(),
                    },
                    success: (response) => {
                        if (response.status === 'success') {
                            showSuccessMessage(response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: (xhr, status, error) => {
                        showErrorMessage(xhr.responseJSON.error);
                        App.setToken(xhr.responseJSON.token);
                        return;
                    },
                });
            }
        });
    };

    // Drag and drop functionality
    const uploadArea = imageUpload.parent();

    // Remove existing drag/drop event listeners
    uploadArea.off('dragenter dragover dragleave drop');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach((eventName) => {
        uploadArea.on(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach((eventName) => {
        uploadArea.on(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach((eventName) => {
        uploadArea.on(eventName, unhighlight, false);
    });

    function highlight(e) {
        uploadArea.addClass('border-emerald-400 bg-emerald-50');
    }

    function unhighlight(e) {
        uploadArea.removeClass('border-emerald-400 bg-emerald-50');
    }

    uploadArea.on('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        // Trigger the change event with dropped files
        Object.defineProperty(imageUpload.get(0), 'files', {
            value: files,
            writable: false,
        });

        imageUpload.get(0).dispatchEvent(new Event('change', { bubbles: true }));
    }

    // Rental post listing page lightweight hooks
    try {
        $('select').on('change', function () {
            /* wire filters later */
        });
    } catch (e) {}
});
