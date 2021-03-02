<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>

                <h1 class="page-title"><?php echo trans("settings"); ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <!-- load profile nav -->
                    <?php $this->load->view("settings/_setting_tabs"); ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>

                        <?php echo form_open("social-media-post", ['id' => 'form_validate']); ?>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('personal_website_url'); ?></label>
                            <input type="text" class="form-control form-input" name="personal_website_url"
                                   placeholder="<?php echo trans('personal_website_url'); ?>" value="<?php echo html_escape($user->personal_website_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="900">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('facebook_url'); ?></label>
                            <input type="text" class="form-control form-input" name="facebook_url"
                                   placeholder="<?php echo trans('facebook_url'); ?>" value="<?php echo html_escape($user->facebook_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="900">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('twitter_url'); ?></label>
                            <input type="text" class="form-control form-input"
                                   name="twitter_url" placeholder="<?php echo trans('twitter_url'); ?>"
                                   value="<?php echo html_escape($user->twitter_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="900">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('instagram_url'); ?></label>
                            <input type="text" class="form-control form-input" name="instagram_url" placeholder="<?php echo trans('instagram_url'); ?>"
                                   value="<?php echo html_escape($user->instagram_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="900">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('pinterest_url'); ?></label>
                            <input type="text" class="form-control form-input" name="pinterest_url" placeholder="<?php echo trans('pinterest_url'); ?>"
                                   value="<?php echo html_escape($user->pinterest_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="900">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('linkedin_url'); ?></label>
                            <input type="text" class="form-control form-input" name="linkedin_url" placeholder="<?php echo trans('linkedin_url'); ?>"
                                   value="<?php echo html_escape($user->linkedin_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="900">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('vk_url'); ?></label>
                            <input type="text" class="form-control form-input" name="vk_url"
                                   placeholder="<?php echo trans('vk_url'); ?>" value="<?php echo html_escape($user->vk_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="900">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('whatsapp_url'); ?></label>
                            <input type="text" class="form-control form-input" name="whatsapp_url"
                                   placeholder="<?php echo trans('whatsapp_url'); ?>" value="<?php echo html_escape($user->whatsapp_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="900">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('telegram_url'); ?></label>
                            <input type="text" class="form-control form-input" name="telegram_url"
                                   placeholder="<?php echo trans('telegram_url'); ?>" value="<?php echo html_escape($user->telegram_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="900">
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('youtube_url'); ?></label>
                            <input type="text" class="form-control form-input" name="youtube_url"
                                   placeholder="<?php echo trans('youtube_url'); ?>" value="<?php echo html_escape($user->youtube_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> maxlength="900">
                        </div>
                        <button type="submit" class="btn btn-md btn-custom"><?php echo trans("save_changes") ?></button>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

