function handleAttachmentError(xhr, message) {
    const errorTitle = "Kesalahan Mengunggah File";
    Swal.fire({
        title: xhr ? `${xhr.status}: ${xhr.statusText}` : errorTitle,
        text: typeof message === 'object' ? message.message || "Terjadi kesalahan yang tidak diketahui" : message || "Terjadi kesalahan yang tidak diketahui",
        icon: "error"
    });
}
