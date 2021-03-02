<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (!empty($product)):
    if (!empty($audio)):?>
        <div class="dm-uploader-container">
            <div id="drag-and-drop-zone-audio" class="dm-uploader dm-uploader-media text-center">
                <ul class="dm-uploaded-files dm-uploaded-media-file">
                    <li class="media li-dm-media-preview">
                        <div class="audio-player audio-player-preview w-100">
                            <a href="javascript:void(0)" class="btn-img-delete btn-video-delete position-relative float-right m-l-5" onclick="delete_product_audio_preview('<?php echo $product->id; ?>','<?php echo trans("confirm_product_audio") ?>');">
                                <i class="icon-close"></i>
                            </a>
                            <audio id="audio_player" controls>
                                <source src="<?php echo get_product_audio_url($audio); ?>" type="audio/mp3"/>
                            </audio>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    <?php else: ?>
        <div class="dm-uploader-container">
            <div id="drag-and-drop-zone-audio" class="dm-uploader dm-uploader-media text-center">
                <p class="dm-upload-icon">
                    <i class="icon-upload"></i>
                </p>
                <p class="dm-upload-text"><?php echo trans("drag_drop_file_here"); ?>&nbsp;<span style="text-decoration: underline"><?php echo trans('browse_files'); ?></span></p>
                <a class='btn btn-md dm-btn-select-files'>
                    <input type="file" name="file">
                </a>
                <ul class="dm-uploaded-files dm-uploaded-media-file" id="files-audio"></ul>
                <div class="error-message-file-upload">
                    <p class="m-b-5 text-center"></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
