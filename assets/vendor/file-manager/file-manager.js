/**
 ------------------------------------------------------------------------------------------------
 File Manager
 ------------------------------------------------------------------------------------------------
 */
var data_editor_id = "";
$(document).on('click', '#btn_add_image_editor', function () {
    data_editor_id = $(this).attr('data-editor-id');
    refresh_ck_images();
    $('#selected_ckimg_file_id').val('');
    $('#selected_ckimg_file_path').val('');
    $('#btn_ckimg_delete').hide();
    $('#btn_ckimg_select').hide();
});

$(document).on('click', '#fileManagerModal .file-box', function () {
    $('.file-manager .file-box').removeClass('selected');
    $(this).addClass('selected');
    var val_id = $(this).attr('data-file-id');
    var val_path = $(this).attr('data-file-path');
    $('#selected_ckimg_file_id').val(val_id);
    $('#selected_ckimg_file_path').val(val_path);

    $('#btn_ckimg_delete').show();
    $('#btn_ckimg_select').show();
});

//refresh ck images
function refresh_ck_images() {
    var data = {};
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/get_file_manager_images",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("ckimage_file_upload_response").innerHTML = obj.content;
            }
        }
    });
}

//select image file
$(document).on('click', '#fileManagerModal #btn_ckimg_select', function () {
    var imgUrl = $('#selected_ckimg_file_path').val();
    tinymce.get(data_editor_id).execCommand('mceInsertContent', false, '<p><img src="' + imgUrl + '" alt=""/></p>');
    $('#fileManagerModal').modal('toggle');
});

//select image file on double click
$(document).on('dblclick', '#fileManagerModal .file-box', function () {
    var imgUrl = $('#selected_ckimg_file_path').val();
    tinymce.get(data_editor_id).execCommand('mceInsertContent', false, '<p><img src="' + imgUrl + '" alt=""/></p>');
    $('#fileManagerModal').modal('toggle');
});

//delete image file
$(document).on('click', '#fileManagerModal #btn_ckimg_delete', function () {
    var file_id = $('#selected_ckimg_file_id').val();
    $('#ckimg_col_id_' + file_id).remove();
    var data = {
        "file_id": file_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_file_manager_image",
        data: data,
        success: function (response) {
            $('#btn_ckimg_delete').hide();
            $('#btn_ckimg_select').hide();
        }
    });
});
