<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (!empty($index_banners_array) && !empty($banner_location) && !empty($index_banners_array[$banner_location])): ?>
    <div class="col-12 section section-index-bn">
        <div class="row">
            <?php foreach ($index_banners_array[$banner_location] as $banner):
                if ($banner->banner_location == $banner_location):?>
                    <div class="col-6 col-index-bn index_bn_<?= $banner->id; ?>">
                        <a href="<?= $banner->banner_url; ?>">
                            <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= base_url() . $banner->banner_image_path; ?>" alt="banner" class="lazyload img-fluid">
                        </a>
                    </div>
                <?php endif;
            endforeach; ?>
        </div>
    </div>
<?php endif; ?>