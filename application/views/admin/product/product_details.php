<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('product_details'); ?></h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <?php $images = $this->file_model->get_product_images($product->id);
                if (!empty($images)):?>
                    <div class="row row-product-details row-product-images">
                        <div class="col-sm-12">
                            <?php foreach ($images as $image): ?>
                                <div class="image m-b-10">
                                    <img src="<?php echo get_product_image_url($image, 'image_small'); ?>" alt="">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('link'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <a href="<?php echo generate_product_url($product); ?>" target="_blank"><?php echo generate_product_url($product); ?></a>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('status'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if ($product->status == 1): ?>
                            <label class="label label-success"><?php echo trans("active"); ?></label>
                        <?php else: ?>
                            <label class="label label-danger"><?php echo trans("pending"); ?></label>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('visibility'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if ($product->visibility == 1): ?>
                            <label class="label label-success"><?php echo trans("visible"); ?></label>
                        <?php else: ?>
                            <label class="label label-danger"><?php echo trans("hidden"); ?></label>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('id'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $product->id; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('title'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo html_escape($product_details->title); ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('slug'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $product->slug; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('product_type'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo trans($product->product_type); ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('listing_type'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo get_product_listing_type($product); ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('category'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php
                        $category = get_category_by_id($product->category_id);
                        if (!empty($category)) {
                            $i = 0;
                            $categories = get_parent_categories_tree($category, false);
                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    if ($i != 0) {
                                        echo ", ";
                                    }
                                    echo html_escape($category->name);
                                    $i++;
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('price'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo price_formatted($product->price, $product->currency) . " " . $product->currency; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('stock'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if ($product->product_type == "digital"):
                            echo trans("in_stock");
                        else:
                            echo $product->stock;
                        endif; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('location'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo get_location($product); ?>
                    </div>
                </div>


                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('user'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php $user = get_user($product->user_id);
                        if (!empty($user)): ?>
                            <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
                                <img src="<?php echo get_user_avatar($user); ?>" alt="" style="width: 50px; height: 50px;">
                                &nbsp;<strong><?php echo $user->username; ?></strong>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('promoted'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if ($product->is_promoted == 1): ?>
                            <label class="label label-success"><?php echo trans("yes"); ?></label><br><br>

                            <?php if ($product->status == 1): ?>
                                <label><?php echo trans("start"); ?>: &nbsp;<?php echo $product->promote_start_date; ?></label><br>
                                <label><?php echo trans("end"); ?>: &nbsp;<?php echo $product->promote_end_date; ?></label><br>
                                <label><?php echo trans("remaining_days"); ?>: &nbsp;<strong><?php echo date_difference($product->promote_end_date, date('Y-m-d H:i:s')); ?></strong></label>
                            <?php else: ?>
                                <label><?php echo trans("purchased_plan") . ": " . $product->promote_plan; ?></label>
                            <?php endif; ?>
                        <?php else: ?>
                            <label class="label label-danger"><?php echo trans("no"); ?></label>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('reviews'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php $this->load->view('admin/includes/_review_stars', ['review' => $product->rating]); ?>
                        <span>(<?php echo $review_count; ?>)</span>
                        <style>
                            .rating {
                                float: left;
                                display: inline-block;
                                margin-right: 10px;
                            }
                        </style>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('page_views'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $product->pageviews; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('demo_url'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if (!empty($product->demo_url)): ?>
                            <a href="<?php echo $product->demo_url; ?>" target="_blank"><?php echo $product->demo_url; ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('external_link'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if (!empty($product->external_link)): ?>
                            <a href="<?php echo $product->external_link; ?>" target="_blank" rel="nofollow"><?php echo $product->external_link; ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('files_included'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $product->files_included; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('draft'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if ($product->is_draft == 1): ?>
                            <label class="label label-success"><?php echo trans("yes"); ?></label>
                        <?php else: ?>
                            <label class="label label-danger"><?php echo trans("no"); ?></label>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('video_preview'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php $video = $this->file_model->get_product_video($product->id);
                        if (!empty($video)):?>
                            <div style="width: 500px; max-width: 100%;">
                                <video controls style="width: 100%;">
                                    <source src="<?php echo get_product_video_url($video); ?>" type="video/mp4">
                                </video>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('audio_preview'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php $audio = $this->file_model->get_product_audio($product->id);
                        if (!empty($audio)):?>
                            <div style="width: 500px; max-width: 100%;">
                                <audio controls style="width: 100%;">
                                    <source src="<?php echo get_product_audio_url($audio); ?>" type="audio/mp3"/>
                                </audio>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('digital_files'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php $digital_file = $this->file_model->get_product_digital_file($product->id);
                        if (!empty($digital_file)): ?>
                            <?php echo form_open('file_controller/download_digital_file', ['id' => 'form_download_digital_file']); ?>
                            <input type="hidden" name="file_id" value="<?php echo $digital_file->id; ?>">
                            <div class="dm-uploaded-digital-file">
                                <a href="javascript:void(0)" class="float-left button-link-style" onclick="$('#form_download_digital_file').submit();">
                                    <i class="icon-file-archive file-icon"></i>&nbsp;&nbsp;<strong><?php echo $digital_file->file_name; ?></strong>
                                </a>
                                <button type="submit" class="btn btn-sm btn-info color-white float-right m-r-5">
                                    <i class="icon-cloud-download"></i><?php echo trans("download"); ?>
                                </button>
                            </div>
                            <?php echo form_close();
                        endif; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('description'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right description">
                        <?php echo $product_details->description; ?>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <!-- form start -->
                <?php echo form_open('product_controller/approve_product'); ?>
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                <input type="hidden" name="redirect_url" value="<?php echo $this->agent->referrer(); ?>">

                <?php if ($product->status != 1): ?>
                    <button type="submit" name="option" value="approve" class="btn btn-primary pull-right"><?php echo trans('approve'); ?></button>
                <?php endif; ?>
                <a href="<?php echo generate_dash_url("edit_product"); ?>/<?php echo $product->id; ?>" target="_blank" class="btn btn-info pull-right m-r-5"><?php echo trans('edit'); ?></a>
                <a href="<?php echo $this->agent->referrer(); ?>" class="btn btn-danger pull-right m-r-5"><?php echo trans('back'); ?></a>
                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box-footer -->

        </div>
        <!-- /.box -->
    </div>
</div>
