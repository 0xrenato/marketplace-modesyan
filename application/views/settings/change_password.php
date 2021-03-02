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

                        <?php echo form_open_multipart("change-password-post", ['id' => 'form_validate']); ?>
                        <?php if (!empty($user->password)): ?>
                            <div class="form-group">
                                <label class="control-label"><?php echo trans("old_password"); ?></label>
                                <input type="password" name="old_password" class="form-control form-input" value="<?php echo old("old_password"); ?>" placeholder="<?php echo trans("old_password"); ?>" maxlength="255" required>
                            </div>
                            <input type="hidden" name="old_password_exists" value="1">
                        <?php else: ?>
                            <input type="hidden" name="old_password_exists" value="0">
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans("password"); ?></label>
                            <input type="password" name="password" class="form-control form-input" value="<?php echo old("password"); ?>" placeholder="<?php echo trans("password"); ?>" minlength="4" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans("password_confirm"); ?></label>
                            <input type="password" name="password_confirm" class="form-control form-input" value="<?php echo old("password_confirm"); ?>" placeholder="<?php echo trans("password_confirm"); ?>" maxlength="255" required>
                        </div>

                        <button type="submit" class="btn btn-md btn-custom"><?php echo trans("change_password") ?></button>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

