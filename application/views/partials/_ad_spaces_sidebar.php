<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--print sidebar banner-->
<?php if (!empty($ad_space)):
    $ad_codes = get_ad_codes($ad_space);
    if (!empty($ad_codes)): ?>
        <?php if (trim($ad_codes->ad_code_300) != ''):
            if ($ad_space == "products_sidebar" || $ad_space == "profile_sidebar") : ?>
                <!--Sidebar 160x600 Ad-->
                <div class="bn-sidebar-160 <?php echo(isset($class) ? $class : ''); ?>">
                    <?php echo $ad_codes->ad_code_300; ?>
                </div>
            <?php else: ?>
                <!--Sidebar 300x250 Ad-->
                <div class="bn-lg-sidebar <?php echo(isset($class) ? $class : ''); ?>">
                    <?php echo $ad_codes->ad_code_300; ?>
                </div>
            <?php endif; endif; ?>
        <?php if (trim($ad_codes->ad_code_250) != ''): ?>
            <div class="bn-sm-sidebar <?php echo(isset($class) ? $class : ''); ?>">
                <?php echo $ad_codes->ad_code_250; ?>
            </div>
        <?php endif;
    endif;
endif; ?>


