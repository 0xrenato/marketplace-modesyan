<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $exts = str_replace('"', '', $this->product_settings->digital_allowed_file_extensions);
$exts = str_replace(',', ", ", $exts);
$exts = strtoupper($exts); ?>
<div class="form-box">
    <div class="form-box-head">
        <h4 class="title">
            <?php echo trans('digital_files'); ?>
            <small><?php echo trans("allowed_file_extensions"); ?>:&nbsp;<strong class="font-500"><?php echo $exts; ?></strong></small>
        </h4>
    </div>
    <div class="form-box-body">
        <div class="row">
            <div class="col-sm-12">
                <div id="digital_files_upload_result" class="row-custom">
                    <?php $this->load->view('dashboard/product/_digital_files_upload_response'); ?>
                </div>
                <div class="error-message error-message-file-upload"></div>
            </div>
        </div>
    </div>
</div>

<!-- File item template -->
<script type="text/html" id="files-template-digital-files">
    <li class="media">
        <div class="media-body">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </li>
</script>

<script>
    $('#drag-and-drop-zone-digital-files').dmUploader({
        url: '<?php echo base_url(); ?>upload-digital-files-post',
        queue: true,
        extFilter: [<?php echo $this->product_settings->digital_allowed_file_extensions;?>],
        multiple: false,
        extraData: function (id) {
            return {
                "product_id": <?php echo $product->id; ?>,
                "<?php echo $this->security->get_csrf_token_name(); ?>": $.cookie(csfr_cookie_name)
            };
        },
        onDragEnter: function () {
            this.addClass('active');
        },
        onDragLeave: function () {
            this.removeClass('active');
        },
        onNewFile: function (id, file) {
            ui_multi_add_file(id, file, "digital-files");
        },
        onBeforeUpload: function (id) {
            ui_multi_update_file_progress(id, 0, '', true);
            ui_multi_update_file_status(id, 'uploading', 'Uploading...');
        },
        onUploadProgress: function (id, percent) {
            ui_multi_update_file_progress(id, percent);
        },
        onUploadSuccess: function (id, data) {
            var obj = JSON.parse(data);
            if (obj.result == 1) {
                document.getElementById("digital_files_upload_result").innerHTML = obj.html_content;
            }
        },
        onFileExtError: function (file) {
            $(".error-message-file-upload").html("<?php echo trans('invalid_file_type'); ?>");
            setTimeout(function () {
                $(".error-message-file-upload").empty();
            }, 4000);
        },
    });
    $(document).ajaxStop(function () {
        $('#drag-and-drop-zone-digital-files').dmUploader({
            url: '<?php echo base_url(); ?>upload-digital-files-post',
            queue: true,
            extFilter: [<?php echo $this->product_settings->digital_allowed_file_extensions;?>],
            multiple: false,
            extraData: function (id) {
                return {
                    "product_id": <?php echo $product->id; ?>,
                    "<?php echo $this->security->get_csrf_token_name(); ?>": $.cookie(csfr_cookie_name)
                };
            },
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onNewFile: function (id, file) {
                ui_multi_add_file(id, file, "digital-files");
            },
            onBeforeUpload: function (id) {
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id, data) {
                var obj = JSON.parse(data);
                if (obj.result == 1) {
                    document.getElementById("digital_files_upload_result").innerHTML = obj.html_content;
                }
            },
            onFileExtError: function (file) {
                $(".error-message-file-upload").html("<?php echo trans('invalid_file_type'); ?>");
                setTimeout(function () {
                    $(".error-message-file-upload").empty();
                }, 4000);
            },
        });
    });
</script>

