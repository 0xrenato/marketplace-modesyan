<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;margin-top: 10px;"><?php echo trans('preferences'); ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('general'); ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('admin_controller/preferences_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_general"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('multilingual_system'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="multilingual_system" value="1" id="multilingual_system_1"
                                   class="square-purple" <?php echo ($this->general_settings->multilingual_system == 1) ? 'checked' : ''; ?>>
                            <label for="multilingual_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="multilingual_system" value="0" id="multilingual_system_2"
                                   class="square-purple" <?php echo ($this->general_settings->multilingual_system != 1) ? 'checked' : ''; ?>>
                            <label for="multilingual_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('rss_system'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="rss_system" value="1" id="rss_system_1"
                                   class="square-purple" <?php echo ($this->general_settings->rss_system == 1) ? 'checked' : ''; ?>>
                            <label for="rss_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="rss_system" value="0" id="rss_system_2"
                                   class="square-purple" <?php echo ($this->general_settings->rss_system != 1) ? 'checked' : ''; ?>>
                            <label for="rss_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('vendor_verification_system'); ?></label>
                            <small><?php echo "(" . trans('vendor_verification_system_exp') . ")"; ?></small>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="vendor_verification_system" value="1" id="vendor_verification_system_1"
                                   class="square-purple" <?php echo ($this->general_settings->vendor_verification_system == 1) ? 'checked' : ''; ?>>
                            <label for="vendor_verification_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="vendor_verification_system" value="0" id="vendor_verification_system_2"
                                   class="square-purple" <?php echo ($this->general_settings->vendor_verification_system != 1) ? 'checked' : ''; ?>>
                            <label for="vendor_verification_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans("hide_vendor_contact_information"); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="hide_vendor_contact_information" value="1" id="hide_vendor_contact_information_1"
                                   class="square-purple" <?php echo ($this->general_settings->hide_vendor_contact_information == 1) ? 'checked' : ''; ?>>
                            <label for="hide_vendor_contact_information_1" class="option-label"><?php echo trans("yes"); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="hide_vendor_contact_information" value="0" id="hide_vendor_contact_information_2"
                                   class="square-purple" <?php echo ($this->general_settings->hide_vendor_contact_information != 1) ? 'checked' : ''; ?>>
                            <label for="hide_vendor_contact_information_2" class="option-label"><?php echo trans("no"); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans("guest_checkout"); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="guest_checkout" value="1" id="guest_checkout_1"
                                   class="square-purple" <?php echo ($this->general_settings->guest_checkout == 1) ? 'checked' : ''; ?>>
                            <label for="guest_checkout_1" class="option-label"><?php echo trans("enable"); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="guest_checkout" value="0" id="guest_checkout_2"
                                   class="square-purple" <?php echo ($this->general_settings->guest_checkout != 1) ? 'checked' : ''; ?>>
                            <label for="guest_checkout_2" class="option-label"><?php echo trans("disable"); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans("search_by_location"); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="location_search_header" value="1" id="location_search_header_1"
                                   class="square-purple" <?php echo ($this->general_settings->location_search_header == 1) ? 'checked' : ''; ?>>
                            <label for="location_search_header_1" class="option-label"><?php echo trans("enable"); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="location_search_header" value="0" id="location_search_header_2"
                                   class="square-purple" <?php echo ($this->general_settings->location_search_header != 1) ? 'checked' : ''; ?>>
                            <label for="location_search_header_2" class="option-label"><?php echo trans("disable"); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?= trans("pwa"); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" id="pwa_status_1" name="pwa_status" value="1" class="square-purple" <?php echo ($this->general_settings->pwa_status == "1") ? 'checked' : ''; ?>>
                            <label for="pwa_status_1" class="cursor-pointer"><?php echo trans("enable"); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" id="pwa_status_2" name="pwa_status" value="0" class="square-purple" <?php echo ($this->general_settings->pwa_status != "1") ? 'checked' : ''; ?>>
                            <label for="pwa_status_2" class="cursor-pointer"><?php echo trans("disable"); ?></label>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info alert-large m-t-10">
                    <strong><?php echo trans("warning"); ?>!</strong>&nbsp;&nbsp;<?php echo trans("pwa_warning"); ?>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="general" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('products'); ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('admin_controller/preferences_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_products"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('approve_before_publishing'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="approve_before_publishing" value="1" id="approve_before_publishing_1"
                                   class="square-purple" <?php echo ($this->general_settings->approve_before_publishing == 1) ? 'checked' : ''; ?>>
                            <label for="approve_before_publishing_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="approve_before_publishing" value="0" id="approve_before_publishing_2"
                                   class="square-purple" <?php echo ($this->general_settings->approve_before_publishing != 1) ? 'checked' : ''; ?>>
                            <label for="approve_before_publishing_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans("featured_products_system"); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="promoted_products" value="1" id="promoted_products_1"
                                   class="square-purple" <?php echo ($this->general_settings->promoted_products == 1) ? 'checked' : ''; ?>>
                            <label for="promoted_products_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="promoted_products" value="0" id="promoted_products_2"
                                   class="square-purple" <?php echo ($this->general_settings->promoted_products != 1) ? 'checked' : ''; ?>>
                            <label for="promoted_products_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans("vendor_bulk_product_upload"); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="vendor_bulk_product_upload" value="1" id="vendor_bulk_product_upload_1" class="square-purple" <?php echo ($this->general_settings->vendor_bulk_product_upload == 1) ? 'checked' : ''; ?>>
                            <label for="vendor_bulk_product_upload_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="vendor_bulk_product_upload" value="0" id="vendor_bulk_product_upload_2" class="square-purple" <?php echo ($this->general_settings->vendor_bulk_product_upload != 1) ? 'checked' : ''; ?>>
                            <label for="vendor_bulk_product_upload_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans("show_sold_products_on_site"); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="show_sold_products" value="1" id="show_sold_products_1" class="square-purple" <?= $this->general_settings->show_sold_products == 1 ? 'checked' : ''; ?>>
                            <label for="show_sold_products_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="show_sold_products" value="0" id="show_sold_products_2" class="square-purple" <?= $this->general_settings->show_sold_products != 1 ? 'checked' : ''; ?>>
                            <label for="show_sold_products_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('product_link_structure'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="product_link_structure" value="slug-id" id="product_link_structure_1"
                                   class="square-purple" <?php echo ($this->general_settings->product_link_structure == "slug-id") ? 'checked' : ''; ?>>
                            <label for="product_link_structure_1" class="option-label">domain.com/slug-id</label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="product_link_structure" value="id-slug" id="product_link_structure_2"
                                   class="square-purple" <?php echo ($this->general_settings->product_link_structure == "id-slug") ? 'checked' : ''; ?>>
                            <label for="product_link_structure_2" class="option-label">domain.com/id-slug</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="products" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12"></div>
    <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('reviews') . " & " . trans('comments'); ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('admin_controller/preferences_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_reviews_comments"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('reviews'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="reviews" value="1" id="reviews_1"
                                   class="square-purple" <?php echo ($this->general_settings->reviews == 1) ? 'checked' : ''; ?>>
                            <label for="reviews_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="reviews" value="0" id="reviews_2"
                                   class="square-purple" <?php echo ($this->general_settings->reviews != 1) ? 'checked' : ''; ?>>
                            <label for="reviews_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('product_comments'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="product_comments" value="1" id="product_comments_1"
                                   class="square-purple" <?php echo ($this->general_settings->product_comments == 1) ? 'checked' : ''; ?>>
                            <label for="product_comments_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="product_comments" value="0" id="product_comments_2"
                                   class="square-purple" <?php echo ($this->general_settings->product_comments != 1) ? 'checked' : ''; ?>>
                            <label for="product_comments_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('blog_comments'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="blog_comments" value="1" id="blog_comments_1"
                                   class="square-purple" <?php echo ($this->general_settings->blog_comments == 1) ? 'checked' : ''; ?>>
                            <label for="blog_comments_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="blog_comments" value="0" id="blog_comments_2"
                                   class="square-purple" <?php echo ($this->general_settings->blog_comments != 1) ? 'checked' : ''; ?>>
                            <label for="blog_comments_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('comment_approval_system'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="comment_approval_system" value="1" id="comment_approval_system_1"
                                   class="square-purple" <?php echo ($this->general_settings->comment_approval_system == 1) ? 'checked' : ''; ?>>
                            <label for="comment_approval_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="comment_approval_system" value="0" id="comment_approval_system_2"
                                   class="square-purple" <?php echo ($this->general_settings->comment_approval_system != 1) ? 'checked' : ''; ?>>
                            <label for="comment_approval_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="reviews_comments" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>
