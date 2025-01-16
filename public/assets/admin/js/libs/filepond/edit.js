$(document).ready(function () {
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginImageExifOrientation
    );

    function configureFilePond(inputElement, options) {
        if (inputElement) {
            FilePond.create(inputElement, options);
        }
    }

    function getOptions(acceptedFileTypes, maxFileSize) {
        const options = {
            acceptedFileTypes: acceptedFileTypes,
            maxFiles: 1,
            maxFileSize: maxFileSize,
        };

        if (path != null) {
            options.files = [
                {
                    source: sourceName,
                    options: {
                        type: "local",
                    },
                }
            ];

            options.server = {
                process: uploadAttachmentUrl,
                load: function (source, load, error, progress, abort, headers) {
                    fetch(path)
                        .then((res) => res.blob())
                        .then(load)
                        .catch(error);
                },
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
            };
        } else {
            options.server = {
                process: uploadAttachmentUrl,
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
            };
        }

        return options;
    }

    function setupFilePonds(configs) {
        $.each(configs, function (index, config) {
            configureFilePond($(config.selector)[0], getOptions(config.acceptedTypes, config.maxSize));
        });
    }

    const fileConfigs = [
        {
            selector: '#image',
            acceptedTypes: ["image/*"],
            maxSize: '2MB',
            path: path
        },
        {
            selector: '#file',
            acceptedTypes: [
                "application/pdf",
                "application/msword",
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            ],
            maxSize: '7MB',
            path: path
        },
        {
            selector: '#mixed',
            acceptedTypes: [
                "application/pdf",
                "application/msword",
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                "image/*"
            ],
            maxSize: '7MB',
            path: path
        }
    ];

    setupFilePonds(fileConfigs);
});
