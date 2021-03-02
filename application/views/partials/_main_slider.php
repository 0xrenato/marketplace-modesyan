<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="index-main-slider <?php echo ($this->general_settings->slider_type == "boxed") ? "container container-boxed-slider" : "container-fluid"; ?>">
    <div class="row">
        <div class="slider-container" <?= $this->rtl == true ? 'dir="rtl"' : ''; ?>>
            <div id="main-slider" class="main-slider">
                <?php if (!empty($slider_items)):
                    foreach ($slider_items as $item): ?>
                        <div class="item lazyload" data-bg="<?php echo base_url() . $item->image; ?>">
                            <a href="<?php echo html_escape($item->link); ?>">
                                <div class="container">
                                    <div class="row row-slider-caption align-items-center">
                                        <div class="col-12">
                                            <div class="caption">
                                                <?php if (!empty($item->title)): ?>
                                                    <h2 class="title" data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>"><?php echo html_escape($item->title); ?></h2>
                                                <?php endif;
                                                if (!empty($item->description)): ?>
                                                    <p class="description" data-animation="<?php echo $item->animation_description; ?>" data-delay="0.5s" style="color: <?php echo $item->text_color; ?>"><?php echo html_escape($item->description); ?></p>
                                                <?php endif;
                                                if (!empty($item->button_text)): ?>
                                                    <button class="btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="background-color: <?php echo $item->button_color; ?>;border-color: <?php echo $item->button_color; ?>;color: <?php echo $item->button_text_color; ?>"><?php echo html_escape($item->button_text); ?></button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
            <div id="main-slider-nav" class="main-slider-nav">
                <button class="prev"><i class="icon-arrow-left"></i></button>
                <button class="next"><i class="icon-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid index-mobile-slider">
    <div class="row">
        <div class="slider-container" <?= $this->rtl == true ? 'dir="rtl"' : ''; ?>>
            <div id="main-mobile-slider" class="main-slider">
                <?php if (!empty($slider_items)):
                    foreach ($slider_items as $item):
                        $image = $item->image_mobile;
                        if (empty($image)) {
                            $image = $item->image;
                        } ?>
                        <div class="item lazyload" data-bg="<?php echo base_url() . $image; ?>">
                            <a href="<?php echo html_escape($item->link); ?>">
                                <div class="container">
                                    <div class="row row-slider-caption align-items-center">
                                        <div class="col-12">
                                            <div class="caption">
                                                <?php if (!empty($item->title)): ?>
                                                    <h2 class="title" data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>"><?php echo html_escape($item->title); ?></h2>
                                                <?php endif;
                                                if (!empty($item->description)): ?>
                                                    <p class="description" data-animation="<?php echo $item->animation_description; ?>" data-delay="0.5s" style="color: <?php echo $item->text_color; ?>"><?php echo html_escape($item->description); ?></p>
                                                <?php endif;
                                                if (!empty($item->button_text)): ?>
                                                    <button class="btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="background-color: <?php echo $item->button_color; ?>;border-color: <?php echo $item->button_color; ?>;color: <?php echo $item->button_text_color; ?>"><?php echo html_escape($item->button_text); ?></button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
            <div id="main-mobile-slider-nav" class="main-slider-nav">
                <button class="prev"><i class="icon-arrow-left"></i></button>
                <button class="next"><i class="icon-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>