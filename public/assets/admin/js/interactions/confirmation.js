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
        const form = $(this).closest('form')

        Swal.fire({
            title: 'Permohonan Reset Kata Sandi',
            text: "Apakah Anda yakin ingin mereset kata sandi? Kata sandi baru akan diatur menjadi 'Minimal8'",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, reset kata sandi',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit()
            }
        })
    })

    $(document).on('click', '.toggle-status', function (e) {
        e.preventDefault()
        const form = $(this).closest('form')
        const currentStatus = form.find('input[name="status"]').val()
        const newStatus = currentStatus === '1' ? 'Non-aktifkan' : 'Aktifkan';

        Swal.fire({
            title: `Anda ingin me ${newStatus}?`,
            text: `Apakah Anda yakin ingin me ${newStatus} pengguna ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: `Ya, ${newStatus}`,
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit()
            }
        })
    })
})
