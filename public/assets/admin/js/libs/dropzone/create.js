function initializeDropzone(elm, opt) {
    let uploadedDocumentMap = {}

    let elements = document.querySelectorAll(elm);

    elements.forEach(function (element) {
        let isMultiple = element.classList.contains('multiple');
        let isImage = element.classList.contains('image');
        let inputName = element.getAttribute('data-input-name');

        let finalOptions = {
            url: uploadUrl,
            headers: opt.headers,
            paramName: inputName,
            autoDiscover: false,
            maxFiles: isMultiple ? 6 : 1,
            maxFilesize: isImage ? 3 : 10,
            acceptedFiles: isImage ? 'image/*' : 'application/pdf,.doc,.docx,.xls,.xlsx',
            uploadMultiple: isMultiple,
            parallelUploads: isMultiple ? 5 : 1,
            previewsContainer: element.querySelector('.previews-container'),
            previewTemplate: `
                <div class="dz-preview dz-file-preview">
                    <div class="dz-image"><img data-dz-thumbnail /></div>
                    <div class="dz-details">
                        <div class="dz-filename"><span data-dz-name></span></div>
                        <div class="dz-size" data-dz-size></div>
                    </div>
                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                    <div class="dz-success-mark"><span>✔</span></div>
                    <div class="dz-error-mark"><span>✘</span></div>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                    <div class="dz-remove" data-dz-remove>×</div>
                </div>
            `,
            init: function () {
                let dropzoneMessage = element.querySelector('.dz-message');
                let form = this.element.closest('form');

                this.on("success", function (file, response) {
                    if (response.success && response.files) {
                        response.files.forEach(fileInfo => {
                            let input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = isMultiple ? `${inputName}[]` : inputName;
                            input.value = fileInfo.id;
                            input.className = `attachment-${fileInfo.id}`;
                            form.appendChild(input);
                            uploadedDocumentMap[file.upload.filename] = fileInfo.id;

                            if (!file.type.startsWith('image/')) {
                                let fileIcon;
                                if (fileInfo.extension === 'pdf') {
                                    fileIcon = '/assets/admin/images/pdf.png';
                                } else if (['doc', 'docx'].includes(fileInfo.extension)) {
                                    fileIcon = '/assets/admin/images/docx.png';
                                } else if (['xls', 'xlsx'].includes(fileInfo.extension)) {
                                    fileIcon = '/assets/admin/images/xlsx.png';
                                }

                                let thumbnailElement = file.previewElement.querySelector("[data-dz-thumbnail]");
                                thumbnailElement.src = fileIcon;
                                thumbnailElement.alt = file.name;
                            }
                        });
                    }
                });

                this.on("error", function (file, errorMessage, xhr) {
                    this.removeFile(file);
                    handleAttachmentError(xhr, errorMessage);
                });

                this.on("maxfilesexceeded", function (file) {
                    this.removeFile(file);
                    handleAttachmentError("Terlalu Banyak File", `Anda hanya dapat mengunggah ${finalOptions.maxFiles} file untuk input ini`);
                });

                this.on("addedfile", function (file) {
                    if (!isMultiple) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    }
                    if (dropzoneMessage && this.files.length >= finalOptions.maxFiles) {
                        dropzoneMessage.style.display = 'none';
                    }
                });

                this.on("removedfile", function (file) {
                    if (uploadedDocumentMap[file.upload.filename]) {
                        let fileId = uploadedDocumentMap[file.upload.filename];
                        let input = form.querySelector(`input.attachment-${fileId}`);
                        if (input) {
                            input.remove();
                        }
                        delete uploadedDocumentMap[file.upload.filename];
                    }
                    if (this.files.length < finalOptions.maxFiles && dropzoneMessage) {
                        dropzoneMessage.style.display = 'block';
                    }
                });
            }
        };

        Object.assign(finalOptions, opt);

        element.classList.add('dropzone');
        new Dropzone(element, finalOptions);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const commonOptions = {
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    };

    initializeDropzone('.upload-zone', commonOptions);
});
