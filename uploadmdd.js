jQuery(function($) {
    $(document).ready(function() {
        $('#subir_img').click(data_upload);
        $('.uploadmodal-close').click(close_upload_window);
        $('#uploadmodal-finalizar').click(close_upload_window);
        $('#insert-upload').click(open_upload_window);
    });

    function open_upload_window() {
        $('#upload-form').show();

    }

    function close_upload_window() {
        $('#upload-form').hide();
        $('#descripccion-upload').html('');
        $('#rutanueva').html('');
        $('#upload_txt').val('');
    }

    function data_upload() {

        let files = new FormData(),
            url = '../wp-content/plugins/ImageCompressFw/uploadok.php';
        files.append('fileName', $('#upload_txt')[0].files[0]); // append selected file to the bag named 'file'
        $.ajax({
            type: 'post',
            url: url,
            processData: false,
            contentType: false,
            data: files,
            beforeSend: function() {
                $('#rutanueva').html("<div id='loading-upload'><img src='../wp-content/plugins/ImageCompressFw/files/loading.gif' width='180' /></div>");
            },
            success: function(data) {
                $('#upload_txt').val('');
                $('#rutanueva').html(data);
            },
            error: function(err) {
                console.log(err);
            }
        });



    }


});