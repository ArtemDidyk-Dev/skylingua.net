$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/*   Alert Toastr START  */
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
/*   Alert Toastr END  */


/*   POST THUMB IMAGE START   */
let imagePostWidth = $(".images-post-container").width();
let getWindowWidth = $(window).width();
if (getWindowWidth <= 1200 && getWindowWidth >= 575) {
    $('.images-post-item').css({'width': imagePostWidth / 1.8, 'height': imagePostWidth / 1.8});
    $('.activeButton').css({'width': imagePostWidth / 1.8, 'height': imagePostWidth / 1.8});
    $('.images-post-container figure img').css({'width': imagePostWidth / 1.8, 'height': imagePostWidth / 1.8});
    $('.imageLoad').show();
} else {
    $('.images-post-item').css({'width': imagePostWidth, 'height': imagePostWidth});
    $('.activeButton').css({'width': imagePostWidth, 'height': imagePostWidth});
    $('.images-post-container figure img').css({'width': imagePostWidth, 'height': imagePostWidth});
    $('.imageLoad').show();
}


$(window).resize(function () {
    imagePostWidth = $(".images-post-container").width();
    getWindowWidth = $(window).width();
    if (getWindowWidth <= 1200 && getWindowWidth >= 575) {
        $('.images-post-item').css({'width': imagePostWidth / 1.8, 'height': imagePostWidth / 1.8});
        $('.activeButton').css({'width': imagePostWidth / 1.8, 'height': imagePostWidth / 1.8});
        $('.images-post-container figure img').css({'width': imagePostWidth / 1.8, 'height': imagePostWidth / 1.8});
    } else {
        $('.images-post-item').css({'width': imagePostWidth, 'height': imagePostWidth});
        $('.activeButton').css({'width': imagePostWidth, 'height': imagePostWidth});
        $('.images-post-container figure img').css({'width': imagePostWidth, 'height': imagePostWidth});
    }


});

$(document).on('click', '.brand-toggle', function () {
    if (getWindowWidth <= 1200 && getWindowWidth >= 575) {
        $('.images-post-item').css({'width': imagePostWidth / 1.8, 'height': imagePostWidth / 1.8});
        $('.activeButton').css({'width': imagePostWidth / 1.8, 'height': imagePostWidth / 1.8});
        $('.images-post-container figure img').css({'width': imagePostWidth / 1.8, 'height': imagePostWidth / 1.8});
    } else {
        $('.images-post-item').css({'width': imagePostWidth, 'height': imagePostWidth});
        $('.activeButton').css({'width': imagePostWidth, 'height': imagePostWidth});
        $('.images-post-container figure img').css({'width': imagePostWidth, 'height': imagePostWidth});
    }

})

$(document).on('click', '.notPhotoPost', function () {
    const datalanguage = $(this).attr('data-languageID');
    $(this).hide();
    $('#image_label_' + datalanguage).val('');
    $('.previewImage_' + datalanguage).attr("src", noPhoto)
})

$(document).on('click', '.notPhotoPostAlone', function () {
    $(this).hide();
    $('#image_label').val('');
    $('.previewImage').attr("src", noPhoto)
})


/*   POST THUMB IMAGE END   */


/*   CKFINDER KOMEKCI BUTTON START   */

function ckfinderTinyMCEButton(x, y, fileType) {
    var fileTypes = '';

    if (fileType == 'image') {
        fileTypes = 'Images';
    }


    CKFinder.modal({
        chooseFiles: true,
        language: langaugeDefault,
        resourceType: fileTypes, //Ancaq image gosterir
        width: x * 0.8,
        height: y * 0.8,
        plugins: [
            // Path must be relative to the location of ckfinder.js file
            'samples/plugins/StatusBarInfo/StatusBarInfo'
        ],
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                // var outputFileName = document.getElementById( 'file-name' );
                // var outputFileUrl = document.getElementById( 'file-url' );
                // outputFileName.innerText = 'Selected: ' + file.get( 'name' );
                // outputFileUrl.innerText = 'URL: ' + file.getUrl();

                //Inputa yaz
                $('.tox-control-wrap input').val(file.getUrl());


                // var files = evt.data.files;
                //
                // var chosenFilesName = '';
                // var chosenFilesUrl = '';
                //
                // files.forEach( function( file, i ) {
                //     chosenFilesName += ( i + 1 ) + '. ' + file.get( 'name' ) + '\n';
                //     chosenFilesUrl += ( i + 1 ) + '. ' + file.getUrl() + '\n';
                // } );
                //
                // console.log( 'AD '+chosenFilesName );
                // console.log( 'URL '+chosenFilesUrl );


            });

            finder.on('file:choose:resizedImage', function (evt) {
                // var outputFileName = document.getElementById( 'file-name' );
                // var outputFileUrl = document.getElementById( 'file-url' );
                // outputFileName.innerText = 'Selected resized image: ' + evt.data.file.get( 'name' );
                // outputFileUrl.innerText = 'URL: ' + evt.data.resizedUrl;

                //Inputa yaz
                $('.tox-control-wrap input').val(evt.data.resizedUrl);
            });


        }
    });
}

function ckfinderButton(x, y, type) {

    CKFinder.modal({
        chooseFiles: true,
        language: langaugeDefault,
        resourceType: type, //Ancaq image gosterir
        width: x * 0.8,
        height: y * 0.8,
        plugins: [
            // Path must be relative to the location of ckfinder.js file
            'samples/plugins/StatusBarInfo/StatusBarInfo'
        ],
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                // var outputFileName = document.getElementById( 'file-name' );
                // var outputFileUrl = document.getElementById( 'file-url' );
                // outputFileName.innerText = 'Selected: ' + file.get( 'name' );
                // outputFileUrl.innerText = 'URL: ' + file.getUrl();

                let activeButtonCheck = $('.activeButtonCheck').attr('data-languageID');
                document.getElementById('image_label_' + activeButtonCheck).value = file.getUrl();
                document.querySelector('.previewImage_' + activeButtonCheck).src = file.getUrl();

                $('.notPhotoPost_' + activeButtonCheck).css('display', 'flex');
                $('.activeButton').removeClass('activeButtonCheck');


                // var files = evt.data.files;
                //
                // var chosenFilesName = '';
                // var chosenFilesUrl = '';
                //
                // files.forEach( function( file, i ) {
                //     chosenFilesName += ( i + 1 ) + '. ' + file.get( 'name' ) + '\n';
                //     chosenFilesUrl += ( i + 1 ) + '. ' + file.getUrl() + '\n';
                // } );
                //
                // console.log( 'AD '+chosenFilesName );
                // console.log( 'URL '+chosenFilesUrl );


            });

            finder.on('file:choose:resizedImage', function (evt) {
                // var outputFileName = document.getElementById( 'file-name' );
                // var outputFileUrl = document.getElementById( 'file-url' );
                // outputFileName.innerText = 'Selected resized image: ' + evt.data.file.get( 'name' );
                // outputFileUrl.innerText = 'URL: ' + evt.data.resizedUrl;


                let activeButtonCheck = $('.activeButtonCheck').attr('data-languageID');
                document.getElementById('image_label_' + activeButtonCheck).value = evt.data.resizedUrl;
                document.querySelector('.previewImage_' + activeButtonCheck).src = evt.data.resizedUrl;
                $('.notPhotoPost_' + activeButtonCheck).css('display', 'flex');
                $('.activeButton').removeClass('activeButtonCheck');


            });


        }
    });


}


function ckfinderAloneButton(x, y, type) {

    CKFinder.modal({
        chooseFiles: true,
        language: langaugeDefault,
        resourceType: type, //Ancaq image gosterir
        width: x * 0.8,
        height: y * 0.8,
        plugins: [
            // Path must be relative to the location of ckfinder.js file
            'samples/plugins/StatusBarInfo/StatusBarInfo'
        ],
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                // var outputFileName = document.getElementById( 'file-name' );
                // var outputFileUrl = document.getElementById( 'file-url' );
                // outputFileName.innerText = 'Selected: ' + file.get( 'name' );
                // outputFileUrl.innerText = 'URL: ' + file.getUrl();


                document.getElementById('image_label').value = file.getUrl();
                document.querySelector('.previewImage').src = file.getUrl();
                $('.notPhotoPost').css('display', 'flex');



                // var files = evt.data.files;
                //
                // var chosenFilesName = '';
                // var chosenFilesUrl = '';
                //
                // files.forEach( function( file, i ) {
                //     chosenFilesName += ( i + 1 ) + '. ' + file.get( 'name' ) + '\n';
                //     chosenFilesUrl += ( i + 1 ) + '. ' + file.getUrl() + '\n';
                // } );
                //
                // console.log( 'AD '+chosenFilesName );
                // console.log( 'URL '+chosenFilesUrl );


            });

            finder.on('file:choose:resizedImage', function (evt) {
                // var outputFileName = document.getElementById( 'file-name' );
                // var outputFileUrl = document.getElementById( 'file-url' );
                // outputFileName.innerText = 'Selected resized image: ' + evt.data.file.get( 'name' );
                // outputFileUrl.innerText = 'URL: ' + evt.data.resizedUrl;



                document.getElementById('image_label').value = evt.data.resizedUrl;
                document.querySelector('.previewImage').src = evt.data.resizedUrl;
                $('.notPhotoPost').css('display', 'flex');



            });


        }
    });


}

function ckfinderAloneButtonMultiple(x, y, type) {



    CKFinder.modal({
        chooseFiles: true,
        language: langaugeDefault,
        resourceType: type, //Ancaq image gosterir
        width: x * 0.8,
        height: y * 0.8,
        plugins: [
            // Path must be relative to the location of ckfinder.js file
            'samples/plugins/StatusBarInfo/StatusBarInfo'
        ],
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                // var outputFileName = document.getElementById( 'file-name' );
                // var outputFileUrl = document.getElementById( 'file-url' );
                // outputFileName.innerText = 'Selected: ' + file.get( 'name' );
                // outputFileUrl.innerText = 'URL: ' + file.getUrl();


                // document.getElementById('image_label').value = file.getUrl();
                // document.querySelector('.previewImage').src = file.getUrl();
                // $('.notPhotoPost').css('display', 'flex');



                var files = evt.data.files;

                var chosenFilesName = '';
                var chosenFilesUrl = '';

                files.forEach( function( file, i ) {
                    // chosenFilesName += file.get( 'name' );
                    // chosenFilesUrl += file.getUrl();
                    $('#sortable').append(`<div class="images-box-item">
                         <div class="removeButton">
                            <span class="fa fa-times"></span>
                        </div>
                      <img width="200" src="${file.getUrl()}" >
                      <input form="submit-form" type="hidden" name="images[]" value="${file.getUrl()}">
                      </div>`)

                } );

                // console.log( 'AD '+chosenFilesName );
                // console.log( 'URL '+chosenFilesUrl );


            });

            finder.on('file:choose:resizedImage', function (evt) {
                // var outputFileName = document.getElementById( 'file-name' );
                // var outputFileUrl = document.getElementById( 'file-url' );
                // outputFileName.innerText = 'Selected resized image: ' + evt.data.file.get( 'name' );
                // outputFileUrl.innerText = 'URL: ' + evt.data.resizedUrl;



                document.getElementById('image_label').value = evt.data.resizedUrl;
                document.querySelector('.previewImage').src = evt.data.resizedUrl;
                $('.notPhotoPost').css('display', 'flex');



            });


        }
    });


}


/*   CKFINDER KOMEKCI BUTTON END   */


/*   CACHE CLEAR START   */
$(document).on('click','#cache-clear',function (){
    $.ajax({
        url: cacheClearRoute,
        type: 'POST',
        data: {data: true},
        dataType: 'JSON',
        success: function (data) {
            if (data.success == true) {
                toastr.success(cacheClear);
            } else {
                toastr.error("Xəta baş verdi");
            }
        }
    });
})
/*   CACHE CLEAR END   */
