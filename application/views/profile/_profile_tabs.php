<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<ul class="nav nav-tabs nav-tabs-horizontal nav-tabs-profile" role="tablist">
    <?php if (is_multi_vendor_active()):
        if ($user->role == 'admin' || $user->role == 'vendor'): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($active_tab == 'products') ? 'active' : ''; ?>" href="<?php echo generate_profile_url($user->slug); ?>"><?php echo trans("products"); ?><span class="count">(<?php echo get_user_products_count($user->id); ?>)</span></a>
            </li>
        <?php endif;
    endif; ?>
    <li class="nav-item">
        <a class="nav-link <?php echo ($active_tab == 'wishlist') ? 'active' : ''; ?>" href="<?php echo generate_url("wishlist") . "/" . $user->slug; ?>"><?php echo trans("wishlist"); ?><span class="count">(<?php echo get_user_wishlist_products_count($user->id); ?>)</span></a>
    </li>
    <?php if (is_multi_vendor_active()): ?>
        <?php if ($this->auth_check && $this->auth_user->id == $user->id && $this->is_sale_active && $this->general_settings->digital_products_system == 1): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($active_tab == 'downloads') ? 'active' : ''; ?>" href="<?php echo generate_url("downloads"); ?>"><?php echo trans("downloads"); ?><span class="count">(<?php echo get_user_downloads_count($user->id); ?>)</span></a>
            </li>
        <?php endif; ?>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link <?php echo ($active_tab == 'followers') ? 'active' : ''; ?>" href="<?php echo generate_url("followers") . "/" . $user->slug; ?>"><?php echo trans("followers"); ?><span class="count">(<?php echo get_followers_count($user->id); ?>)</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo ($active_tab == 'following') ? 'active' : ''; ?>" href="<?php echo generate_url("following") . "/" . $user->slug; ?>"><?php echo trans("following"); ?><span class="count">(<?php echo get_following_users_count($user->id); ?>)</span></a>
    </li>
    <?php if (($this->general_settings->reviews == 1) && ($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active()): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo ($active_tab == 'reviews') ? 'active' : ''; ?>" href="<?php echo generate_url("reviews") . "/" . $user->slug; ?>"><?php echo trans("reviews"); ?><span class="count">(<?php echo $user_rating->count; ?>)</span></a>
        </li>
    <?php endif; ?>
</ul>