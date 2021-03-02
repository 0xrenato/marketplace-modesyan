<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!empty($product)):
    $video = $this->file_model->get_product_video($product->id);
    if (!empty($video)):?>
        <div class="dm-uploader-container">
            <div id="drag-and-drop-zone-video" class="dm-uploader dm-uploader-media text-center">
                <ul class="dm-uploaded-files dm-uploaded-media-file">
                    <li class="media li-dm-media-preview">
                        <video id="player" playsinline controls>
                            <source src="<?php echo get_product_video_url($video); ?>" type="video/mp4">
                        </video>
                        <a href="javascript:void(0)" class="btn-img-delete btn-video-delete" onclick="delete_product_video_preview('<?php echo $product->id; ?>','<?php echo trans("confirm_product_video") ?>');">
                            <i class="icon-close"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    <?php else: ?>
        <div class="dm-uploader-container">
            <div id="drag-and-drop-zone-video" class="dm-uploader dm-uploader-media text-center">
                <p class="dm-upload-icon">
                    <i class="icon-upload"></i>
                </p>
                <p class="dm-upload-text"><?php echo trans("drag_drop_file_here"); ?>&nbsp;<span style="text-decoration: underline"><?php echo trans('browse_files'); ?></span></p>
                <a class='btn btn-md dm-btn-select-files'>
                    <input type="file" name="file">
                </a>
                <ul class="dm-uploaded-files dm-uploaded-media-file" id="files-video"></ul>
                <div class="error-message-file-upload">
                    <p class="m-b-5 text-center"></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
