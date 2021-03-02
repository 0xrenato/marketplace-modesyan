<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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

                        <?php echo form_open_multipart("update-profile-post", ['id' => 'form_validate']); ?>
                        <div class="form-group">
                            <p>
                                <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo $user->username; ?>" class="form-avatar">
                            </p>
                            <p>
                                <a class='btn btn-md btn-secondary btn-file-upload'>
                                    <?php echo trans('select_image'); ?>
                                    <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, ''));">
                                </a>
                                <span class='badge badge-info' id="upload-file-info"></span>
                            </p>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans("email_address"); ?></label>
                            <?php if ($this->general_settings->email_verification == 1): ?>
                                <?php if ($user->email_status == 1): ?>
                                    &nbsp;
                                    <small class="text-success">(<?php echo trans("confirmed"); ?>)</small>
                                <?php else: ?>
                                    &nbsp;
                                    <small class="text-danger">(<?php echo trans("unconfirmed"); ?>)</small>
                                    <button type="submit" name="submit" value="resend_activation_email" class="btn float-right btn-resend-email"><?php echo trans("resend_activation_email"); ?></button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <input type="email" name="email" class="form-control form-input" value="<?php echo html_escape($user->email); ?>" placeholder="<?php echo trans("email_address"); ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans("username"); ?></label>
                            <input type="text" name="username" class="form-control form-input" value="<?php echo html_escape($user->username); ?>" placeholder="<?php echo trans("username"); ?>" maxlength="<?php echo $this->username_maxlength; ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans("slug"); ?></label>
                            <input type="text" name="slug" class="form-control form-input" value="<?php echo html_escape($user->slug); ?>" placeholder="<?php echo trans("slug"); ?>" maxlength="200" required>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans("first_name"); ?></label>
                            <input type="text" name="first_name" class="form-control form-input" value="<?php echo html_escape($this->auth_user->first_name); ?>" placeholder="<?php echo trans("first_name"); ?>" maxlength="250" required>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans("last_name"); ?></label>
                            <input type="text" name="last_name" class="form-control form-input" value="<?php echo html_escape($this->auth_user->last_name); ?>" placeholder="<?php echo trans("last_name"); ?>" maxlength="250" required>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans("phone_number"); ?></label>
                            <input type="text" name="phone_number" class="form-control form-input" value="<?php echo html_escape($this->auth_user->phone_number); ?>" placeholder="<?php echo trans("phone_number"); ?>" maxlength="100">
                        </div>

                        <div class="form-group m-t-10">
                            <div class="row">
                                <div class="col-12">
                                    <label class="control-label"><?php echo trans('email_option_send_email_new_message'); ?></label>
                                </div>
                                <div class="col-md-3 col-sm-4 col-12 col-option">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="send_email_new_message" value="1" id="send_email_new_message_1" class="custom-control-input" <?php echo ($user->send_email_new_message == 1) ? 'checked' : ''; ?>>
                                        <label for="send_email_new_message_1" class="custom-control-label"><?php echo trans("yes"); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-12 col-option">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="send_email_new_message" value="0" id="send_email_new_message_2" class="custom-control-input" <?php echo ($user->send_email_new_message != 1) ? 'checked' : ''; ?>>
                                        <label for="send_email_new_message_2" class="custom-control-label"><?php echo trans("no"); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($this->auth_user->role == "admin" || $this->general_settings->hide_vendor_contact_information != 1): ?>
                            <div class="form-group m-t-15">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="show_email" value="1" id="checkbox_show_email" class="custom-control-input" <?php echo ($this->auth_user->show_email == 1) ? 'checked' : ''; ?>>
                                    <label for="checkbox_show_email" class="custom-control-label"><?php echo trans("show_my_email"); ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="show_phone" value="1" id="checkbox_show_phone" class="custom-control-input" <?php echo ($this->auth_user->show_phone == 1) ? 'checked' : ''; ?>>
                                    <label for="checkbox_show_phone" class="custom-control-label"><?php echo trans("show_my_phone"); ?></label>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group m-b-30">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="show_location" value="1" id="checkbox_show_location" class="custom-control-input" <?php echo ($this->auth_user->show_location == 1) ? 'checked' : ''; ?>>
                                <label for="checkbox_show_location" class="custom-control-label"><?php echo trans("show_my_location"); ?></label>
                            </div>
                        </div>
                        <button type="submit" name="submit" value="update" class="btn btn-md btn-custom"><?php echo trans("save_changes") ?></button>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

