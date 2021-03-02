/**
 ------------------------------------------------------------------------------------------------
 Image File Manager
 ------------------------------------------------------------------------------------------------
 */
var manager_image_type = "main";
$(document).on('click', '.btn-file-manager', function () {
    manager_image_type = $(this).attr("data-image-type");
    refresh_file_manager_images();
    $('#selected_file_manager_img_id').val('');
    $('#selected_file_manager_img_path').val('');
    $('#btn_file_manager_delete').hide();
    $('#btn_file_manager_select').hide();
});
$(document).on('click', '#imageFileManagerModal .file-box', function () {
    $('.file-manager .file-box').removeClass('selected');
    $(this).addClass('selected');
    var val_id = $(this).attr('data-file-id');
    var val_path = $(this).attr('data-file-path');
    $('#selected_file_manager_img_id').val(val_id);
    $('#selected_file_manager_img_path').val(val_path);

    $('#btn_file_manager_delete').show();
    $('#btn_file_manager_select').show();
});

//refresh file manager images
function refresh_file_manager_images() {
    var data = {};
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/get_blog_images",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("image_file_manager_upload_response").innerHTML = obj.content;
            }
        }
    });
}

//select image file
$(document).on('click', '#imageFileManagerModal #btn_file_manager_select', function () {
    select_image();
});

//select image file on double click
$(document).on('dblclick', '#imageFileManagerModal .file-box', function () {
    select_image();
});

//select image
function select_image() {
    var img_id = $('#selected_file_manager_img_id').val();
    var img_path = $('#selected_file_manager_img_path').val();
    if (manager_image_type == "editor") {
        tinymce.activeEditor.execCommand('mceInsertContent', false, '<p><img src="' + img_path + '" alt=""/></p>');
    } else {
        var image = '<div class="post-select-image-container">' +
            '<img src="' + img_path + '" alt="">' +
            '<a id="btn_delete_blog_main_image" class="btn btn-danger btn-sm btn-delete-selected-file-image">' +
            '<i class="fa fa-times"></i> ' +
            '</a>' +
            '</div>';
        document.getElementById("blog_select_image_container").innerHTML = image;
        $('input[name=blog_image_id]').val(img_id);
    }
    $('#imageFileManagerModal').modal('toggle');
}

//delete image file
$(document).on('click', '#imageFileManagerModal #btn_file_manager_delete', function () {
    var file_id = $('#selected_file_manager_img_id').val();
    $('#file_manager_col_id_' + file_id).remove();
    var data = {
        "file_id": file_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_blog_image",
        data: data,
        success: function (response) {
            $('#btn_file_manager_delete').hide();
            $('#btn_file_manager_select').hide();
        }
    });
});

//delete blog main image
$(document).on('click', '#btn_delete_blog_main_image', function () {
    var content = '<a class="btn-select-image" data-toggle="modal" data-target="#imageFileManagerModal">' +
        '<div class="btn-select-image-inner">' +
        '<i class="fa fa-image"></i>' +
        '<button class="btn">' + txt_select_image + '</button>' +
        '</div>' +
        '</a>';
    document.getElementById("blog_select_image_container").innerHTML = content;
    $("#blog_image_id").val('');
});

//delete blog main image database
$(document).on('click', '#btn_delete_blog_main_image_database', function () {
    var data = {
        "post_id": $(this).attr("data-post-id")
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "blog_controller/delete_post_image_post",
        data: data,
        success: function (response) {
            var content = '<a class="btn-select-image" data-toggle="modal" data-target="#imageFileManagerModal">' +
                '<div class="btn-select-image-inner">' +
                '<i class="fa fa-image"></i>' +
                '<button class="btn">' + txt_select_image + '</button>' +
                '</div>' +
                '</a>';
            document.getElementById("blog_select_image_container").innerHTML = content;
            $("#blog_image_id").val('');
        }
    });
});