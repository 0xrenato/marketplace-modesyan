<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view("profile/_cover_image"); ?>
<div id="wrapper">
    <div class="container">
        <?php if (empty($user->cover_image)): ?>
            <div class="row">
                <div class="col-12">
                    <nav class="nav-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo trans("followers"); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-12">
                <div class="profile-page-top">
                    <!-- load profile details -->
                    <?php $this->load->view("profile/_profile_user_info"); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php $this->load->view("profile/_profile_tabs"); ?>
            </div>
            <div class="col-12">
                <div class="profile-tab-content">
                    <div class="row row-follower">
                        <?php if (!empty($followers)):
                            foreach ($followers as $item): ?>
                                <div class="col-3 col-sm-2">
                                    <div class="follower-item">
                                        <a href="<?php echo generate_profile_url($item->slug); ?>">
                                            <img src="<?php echo get_user_avatar($item); ?>" alt="<?php echo get_shop_name($item); ?>" class="img-fluid img-profile lazyload">
                                            <p class="username">
                                                <?php echo get_shop_name($item); ?>
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach;
                        else:?>
                            <div class="col-12">
                                <p class="text-center text-muted"><?php echo trans("no_records_found"); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row-custom">
                        <!--Include banner-->
                        <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>

