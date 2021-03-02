<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo trans("contact"); ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?php echo trans("contact"); ?></h1>
            </div>

            <div class="col-12">
                <div class="page-contact">

                    <div class="row contact-text">
                        <div class="col-12">
                            <?php echo $this->settings->contact_text; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h2 class="contact-leave-message"><?php echo trans("leave_message"); ?></h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12 order-1 order-lg-0">
                            <!-- include message block -->
                            <?php $this->load->view('partials/_messages'); ?>

                            <!-- form start -->
                            <?php echo form_open('contact-post', ['id' => 'form_validate', 'class' => 'validate_terms']); ?>
                            <div class="form-group">
                                <input type="text" class="form-control form-input" name="name" placeholder="<?php echo trans("name"); ?>" maxlength="199" minlength="1" pattern=".*\S+.*" value="<?php echo old('name'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-input" name="email" maxlength="199" placeholder="<?php echo trans("email_address"); ?>" value="<?php echo old('email'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control form-input form-textarea" name="message" placeholder="<?php echo trans("message"); ?>" maxlength="4970" minlength="5" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required><?php echo old('message'); ?></textarea>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox custom-control-validate-input">
                                    <input type="checkbox" class="custom-control-input" name="terms" id="checkbox_terms" required>
                                    <label for="checkbox_terms" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;
                                        <?php $page_terms = get_page_by_default_name("terms_conditions", $this->selected_lang->id);
                                        if (!empty($page_terms)): ?>
                                            <a href="<?= generate_url($page_terms->page_default_name); ?>" class="link-terms" target="_blank"><strong><?= html_escape($page_terms->title); ?></strong></a>
                                        <?php endif; ?>
                                    </label>
                                </div>
                            </div>

                            <?php generate_recaptcha(); ?>

                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-custom">
                                    <?php echo trans("submit"); ?>
                                </button>
                            </div>

                            <?php echo form_close(); ?>
                        </div>

                        <div class="col-md-6 col-12 order-0 order-lg-1 contact-right">

                            <?php if ($this->settings->contact_phone): ?>
                                <div class="col-12 contact-item">
                                    <i class="icon-phone" aria-hidden="true"></i>
                                    <?php echo html_escape($this->settings->contact_phone); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->settings->contact_email): ?>
                                <div class="col-12 contact-item">
                                    <i class="icon-envelope" aria-hidden="true"></i>
                                    <?php echo html_escape($this->settings->contact_email); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->settings->contact_address): ?>
                                <div class="col-12 contact-item">
                                    <i class="icon-map-marker" aria-hidden="true"></i>
                                    <?php echo html_escape($this->settings->contact_address); ?>
                                </div>
                            <?php endif; ?>


                            <div class="col-sm-12 contact-social">
                                <!--Include social media links-->
                                <?php $this->load->view('partials/_social_links', ['show_rss' => null]); ?>
                            </div>


                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php if (!empty($this->settings->contact_address)): ?>
        <div class="container-fluid">
            <div class="row">
                <div class="contact-map-container">
                    <iframe id="contact_iframe" src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?php echo $this->settings->contact_address; ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<!-- Wrapper End-->
<script>
    var iframe = document.getElementById("contact_iframe");
    iframe.src = iframe.src;
</script>
<style>
    #footer {
        margin-top: 0;
    }
</style>
