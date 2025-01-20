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
            <div class="dz-image"><img data-dz-thumbnail/></div>
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

                let maxFilesAllowed = this.options.maxFiles;
                let self = this;

                function addHiddenInput(fileId) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = isMultiple ? `${inputName}[]` : inputName;
                    input.value = fileId;
                    input.className = `attachment-${fileId}`;
                    form.appendChild(input);
                }

                this.on("success", function (file, response) {
                    if (response.success && response.files) {
                        response.files.forEach(fileInfo => {
                            addHiddenInput(fileInfo.id);
                            uploadedDocumentMap[file.filename] = fileInfo.id;

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
                                thumbnailElement.alt = file.filename;
                            }
                        });
                    }
                });

                this.on("error", function (file, errorMessage, xhr) {
                    this.removeFile(file);
                    handleAttachmentError(xhr, errorMessage)
                });

                this.on("maxfilesexceeded", function (file) {
                    this.removeFile(file);
                    handleAttachmentError("Terlalu Banyak File", `Anda hanya dapat mengunggah ${finalOptions.maxFiles} file untuk input ini`);

                });

                this.on("addedfile", function (file) {
                    if (dropzoneMessage && this.files.length >= finalOptions.maxFiles) {
                        dropzoneMessage.style.display = 'none';
                    }
                });

                this.on("removedfile", function (file) {
                    if (uploadedDocumentMap[file.filename]) {
                        let fileId = uploadedDocumentMap[file.filename];
                        let input = form.querySelector(`input.attachment-${fileId}`);
                        if (input) {
                            input.remove();
                        }
                        delete uploadedDocumentMap[file.filename];
                    }

                    self.options.maxFiles = Math.min(maxFilesAllowed, self.options.maxFiles + 1);

                    if (this.files.length < finalOptions.maxFiles && dropzoneMessage) {
                        dropzoneMessage.style.display = 'block';
                    }
                });

                if (typeof attachments !== 'undefined' && Array.isArray(attachments)) {
                    attachments.forEach(function (attachment) {
                        let mockFile = {
                            name: attachment.filename,
                            size: attachment.size,
                            accepted: true
                        };

                        addHiddenInput(attachment.id);

                        let fileIcon;
                        if (attachment.extension == 'pdf') {
                            fileIcon = '/assets/admin/images/pdf.png';
                        } else if (['doc', 'docx'].includes(attachment.extension)) {
                            fileIcon = '/assets/admin/images/docx.png';
                        } else if (['xls', 'xlsx'].includes(attachment.extension)) {
                            fileIcon = '/assets/admin/images/xlsx.png';
                        } else {
                            fileIcon = attachment.storageUrl;
                        }

                        this.emit('addedfile', mockFile);
                        this.emit('thumbnail', mockFile, fileIcon);
                        this.emit('complete', mockFile);
                        this.files.push(mockFile);

                        uploadedDocumentMap[attachment.filename] = attachment.id;

                        if (!isMultiple) {
                            this.options.maxFiles = 0;
                        }
                    }.bind(this));

                    if (this.files.length >= finalOptions.maxFiles && dropzoneMessage) {
                        dropzoneMessage.style.display = 'none';
                    }
                } else {
                    handleAttachmentError("Terjadi Kesalahan", "Lampiran tidak terdefinisi atau bukan larik");
                }

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    form.querySelectorAll(`input[name="${inputName}"], input[name="${inputName}[]"]`).forEach(input => input.remove());

                    self.files.forEach(file => {
                        if (uploadedDocumentMap[file.filename]) {
                            addHiddenInput(uploadedDocumentMap[file.filename]);
                        }
                    });

                    form.submit();
                });
            },
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
