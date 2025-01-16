$(document).ready(function () {
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginImageExifOrientation
    );

    const serverOptions = {
        process: uploadAttachmentUrl,
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
    };

    function configureFilePond(inputElement, options) {
        if (inputElement.length) {
            FilePond.create(inputElement[0], options);
        }
    }

    const inputImage = $("#image");
    const inputFile = $("#file");
    const inputMixed = $("#mixed");

    const options = {
        image: {
            acceptedFileTypes: ["image/*"],
            maxFiles: 1,
            maxFileSize: "2MB",
            server: serverOptions,
        },
        file: {
            acceptedFileTypes: [
                "application/pdf",
                "application/msword",
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            ],
            maxFiles: 1,
            maxFileSize: "7MB",
            server: serverOptions,
        },
        mixed: {
            acceptedFileTypes: [
                "application/pdf",
                "application/msword",
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                "image/*"
            ],
            maxFiles: 1,
            maxFileSize: "7MB",
            server: serverOptions,
        },
    };

    configureFilePond(inputImage, options.image);
    configureFilePond(inputFile, options.file);
    configureFilePond(inputMixed, options.mixed);
});
