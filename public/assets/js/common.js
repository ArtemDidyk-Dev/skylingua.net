$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    /*   LANGUAGE CHANGE START   */
    $(document).on('click', '.language-change-request', function () {

        let changeLange = $(this).attr('data-language-code');

        $.ajax({
            url: languageChange,
            data: {
                fullUrl: fullUrl,
                changeLange: changeLange
            },
            method: 'POST',
            dataType: 'JSON',
            success: function (response) {
                if (response.success == true) {
                    //Yonlendir
                    window.location.href = response.data;
                }

            }

        })

    })

    /*   LANGUAGE CHANGE END   */



});
