<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!empty($product_variations)): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-product-variations">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo trans("id"); ?></th>
                        <th scope="col"><?php echo trans("label"); ?></th>
                        <th scope="col"><?php echo trans("variation_type"); ?></th>
                        <th scope="col"></th>
                        <th scope="col"><?php echo trans("visible"); ?></th>
                        <th scope="col" style="width: 250px;"><?php echo trans("options"); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($product_variations as $variation): ?>
                        <tr>
                            <td><?php echo $variation->id; ?></td>
                            <td><?php echo get_variation_label($variation->label_names, $this->selected_lang->id); ?></td>
                            <td><?php echo trans($variation->variation_type); ?></td>
                            <td>
                                <?php if ($variation->variation_type != 'text' && $variation->variation_type != 'number'): ?>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info btn-variation-table" onclick="add_product_variation_option('<?php echo $variation->id; ?>');">
                                        <span id="btn-variation-text-add-<?php echo $variation->id; ?>"><i class="icon-plus"></i><?php echo trans('add_option'); ?></span>
                                        <div id="sp-options-add-<?php echo $variation->id; ?>" class="spinner spinner-btn-variation">
                                            <div class="bounce1"></div>
                                            <div class="bounce2"></div>
                                            <div class="bounce3"></div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info btn-variation-table" onclick="view_product_variation_options('<?php echo $variation->id; ?>');">
                                        <span id="btn-variation-text-options-<?php echo $variation->id; ?>"><i class="icon-menu"></i><?php echo trans('view_options'); ?></span>
                                        <div id="sp-options-<?php echo $variation->id; ?>" class="spinner spinner-btn-variation">
                                            <div class="bounce1"></div>
                                            <div class="bounce2"></div>
                                            <div class="bounce3"></div>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($variation->is_visible == 1):
                                    echo trans("yes");
                                else:
                                    echo trans("no");
                                endif; ?>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-variation-table" onclick="edit_product_variation('<?php echo $variation->id; ?>');">
                                    <span id="btn-variation-edit-<?php echo $variation->id; ?>"><i class="icon-edit"></i><?php echo trans('edit'); ?></span>
                                    <div id="sp-edit-<?php echo $variation->id; ?>" class="spinner spinner-btn-variation">
                                        <div class="bounce1"></div>
                                        <div class="bounce2"></div>
                                        <div class="bounce3"></div>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-variation-table" onclick='delete_product_variation("<?php echo $variation->id; ?>","<?php echo trans("confirm_variation"); ?>");'><i class="icon-trash"></i><?php echo trans('delete'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    $(document).ajaxStop(function () {
        $('#drag-and-drop-zone-variation-image-session').dmUploader({
            url: '<?php echo base_url(); ?>upload-variation-image-session',
            maxFileSize: <?php echo $this->general_settings->max_file_size_image; ?>,
            queue: true,
            allowedTypes: 'image/*',
            extFilter: ["jpg", "jpeg", "png", "gif"],
            extraData: function (id) {
                return {
                    "file_id": id,
                    "<?php echo $this->security->get_csrf_token_name(); ?>": $.cookie(csfr_cookie_name)
                };
            },
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onInit: function () {
            },
            onComplete: function (id) {
            },
            onNewFile: function (id, file) {
                ui_multi_add_file(id, file, "variation-image-session");
                if (typeof FileReader !== "undefined") {
                    var reader = new FileReader();
                    var img = $('#uploaderFile' + id).find('img');

                    reader.onload = function (e) {
                        img.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            },
            onBeforeUpload: function (id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id, data) {
                var data = {
                    "file_id": id,
                    "sys_lang_id": sys_lang_id
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "get-uploaded-variation-image-session",
                    data: data,
                    success: function (response) {
                        document.getElementById("uploaderFile" + id).innerHTML = response;
                    }
                });
                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                ui_multi_update_file_progress(id, 100, 'success', false);
            },
            onUploadError: function (id, xhr, status, message) {
                if (message == "Not Acceptable") {
                    $("#uploaderFile" + id).remove();
                    $(".error-message-img-upload").show();
                    $(".error-message-img-upload p").html("You can upload 5 files.");
                    setTimeout(function () {
                        $(".error-message-img-upload").fadeOut("slow");
                    }, 4000)
                }
            },
            onFallbackMode: function () {
            },
            onFileSizeError: function (file) {
                $(".error-message-img-upload").html("<?php echo trans('file_too_large') . ' ' . formatSizeUnits($this->general_settings->max_file_size_image); ?>");
                setTimeout(function () {
                    $(".error-message-img-upload").empty();
                }, 4000);
            },
            onFileTypeError: function (file) {
            },
            onFileExtError: function (file) {
                $(".error-message-img-upload").html("<?php echo trans('invalid_file_type'); ?>");
                setTimeout(function () {
                    $(".error-message-img-upload").empty();
                }, 4000);
            },
        });

        $('#drag-and-drop-zone-variation-image').dmUploader({
            url: '<?php echo base_url(); ?>upload-variation-image',
            maxFileSize: <?php echo $this->general_settings->max_file_size_image; ?>,
            queue: true,
            allowedTypes: 'image/*',
            extFilter: ["jpg", "jpeg", "png", "gif"],
            extraData: function (id) {
                return {
                    "variation_option_id": $("#drag-and-drop-zone-variation-image #variation_option_id").val(),
                    "<?php echo $this->security->get_csrf_token_name(); ?>": $.cookie(csfr_cookie_name)
                };
            },
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onInit: function () {
            },
            onComplete: function (id) {
            },
            onNewFile: function (id, file) {
                ui_multi_add_file(id, file, "variation-image");
                if (typeof FileReader !== "undefined") {
                    var reader = new FileReader();
                    var img = $('#uploaderFile' + id).find('img');

                    reader.onload = function (e) {
                        img.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            },
            onBeforeUpload: function (id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id, data) {
                var obj = JSON.parse(data);
                var data = {
                    "image_id": obj.image_id,
                    "sys_lang_id": sys_lang_id
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "get-uploaded-variation-image",
                    data: data,
                    success: function (response) {
                        document.getElementById("uploaderFile" + id).innerHTML = response;
                    }
                });
            },
            onUploadError: function (id, xhr, status, message) {
                if (message == "Not Acceptable") {
                    $("#uploaderFile" + id).remove();
                    $(".error-message-img-upload").show();
                    $(".error-message-img-upload p").html("You can upload 5 files.");
                    setTimeout(function () {
                        $(".error-message-img-upload").fadeOut("slow");
                    }, 4000)
                }
            },
            onFallbackMode: function () {
            },
            onFileSizeError: function (file) {
                $(".error-message-img-upload").html("<?php echo trans('file_too_large') . ' ' . formatSizeUnits($this->general_settings->max_file_size_image); ?>");
                setTimeout(function () {
                    $(".error-message-img-upload").empty();
                }, 4000);
            },
            onFileTypeError: function (file) {
            },
            onFileExtError: function (file) {
                $(".error-message-img-upload").html("<?php echo trans('invalid_file_type'); ?>");
                setTimeout(function () {
                    $(".error-message-img-upload").empty();
                }, 4000);
            },
        });
    });
</script>