$(document).ready(function () {
    $('.filter').on('click', function () {
        $('.filter').removeClass('active');
        $(this).addClass('active');
        const url = $(this).data('url');
        $.ajax({
            url: url,
            method: 'GET',
            success: function (response) {
                if (response.status) {
                    $('#forCardsContainer').html(response.data.forCards);
                    $('#mostFrequentPartyContainer').html(response.data.mostFrequentLetterParty);
                } else {
                    alert('Terjadi kesalahan saat mengambil data');
                }
            },
            error: function (xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    });
});
