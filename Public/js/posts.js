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

    // Handle form submission - remove existing listener first
    $('#formNewPost').off('submit');
    $('#formNewPost').on('submit', function (e) {
        preventDefaults(e);

        $('.cleave-input').each(function () {
            this.value = this.value.replace(/,/g, '');
        });

        const formData = new FormData(this);

        $.ajax({
            url: App.appURL + 'landlord/posts/create',
            type: 'POST',
            data: formData, // Gửi trực tiếp FormData
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                console.log('Success:', response);
                if (response.status === 'success') {
                    alert('Đăng tin thành công!');
                    // Reset form nếu cần
                    // $('#formNewPost')[0].reset();
                } else {
                    alert('Có lỗi xảy ra: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                $('#errorMessage').text(xhr.responseJSON.error);
                return;
            },
        });
    });

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
});
