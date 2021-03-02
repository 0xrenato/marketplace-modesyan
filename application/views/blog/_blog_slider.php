<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="blog-slider-container">
    <div id="blog-slider" class="blog-slider">
        <?php foreach ($blog_slider_posts as $item):
            $this->load->view('blog/_blog_item', ['item' => $item]);
        endforeach; ?>
    </div>
    <div id="blog-slider-nav" class="blog-slider-nav">
        <button class="prev"><i class="icon-arrow-left"></i></button>
        <button class="next"><i class="icon-arrow-right"></i></button>
    </div>
</div>