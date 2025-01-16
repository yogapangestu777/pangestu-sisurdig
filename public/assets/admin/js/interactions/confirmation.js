$(document).ready(function () {
    $(document).on('click', '.delete', function (e) {
        e.preventDefault()
        const form = $(this).closest('form')

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak akan dapat mengembalikannya!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!'
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit()
            }
        })
    })

    $(document).on('click', '.reset-password', function (e) {
        e.preventDefault()
        const url = $(this).attr('href')

        Swal.fire({
            title: 'Permohonan Reset Kata Sandi',
            text: "Apakah Anda yakin ingin mereset kata sandi? Kata sandi baru akan diatur menjadi 'Minimal8'",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, reset kata sandi',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed) {
                window.location.href = url
            }
        })
    })
})
