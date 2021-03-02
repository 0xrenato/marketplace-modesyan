<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (!empty($user->cover_image)):
    if ($user->cover_image_type == 'boxed'):?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="lazyload profile-cover-image" data-bg-cover="<?= base_url() . $user->cover_image; ?>"></div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container-fluid">
            <div class="row">
                <div class="lazyload profile-cover-image" data-bg-cover="<?= base_url() . $user->cover_image; ?>"></div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>