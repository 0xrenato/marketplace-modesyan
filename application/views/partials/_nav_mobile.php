<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="navMobile" class="nav-mobile">
    <div class="nav-mobile-sc">
        <div class="nav-mobile-inner">
            <div class="row">
                <div class="col-sm-12 mobile-nav-buttons">
                    <?php if (is_multi_vendor_active()):
                        if ($this->auth_check): ?>
                            <a href="<?= generate_dash_url("add_product"); ?>" class="btn btn-md btn-custom btn-block"><?= trans("sell_now"); ?></a>
                        <?php else: ?>
                            <a href="javascript:void(0)" class="btn btn-md btn-custom btn-block close-menu-click" data-toggle="modal" data-target="#loginModal"><?php echo trans("sell_now"); ?></a>
                        <?php endif;
                    endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 nav-mobile-links">
                    <div id="navbar_mobile_back_button"></div>
                    <ul id="navbar_mobile_categories" class="navbar-nav">
                        <?php if (!empty($this->parent_categories)):
                            foreach ($this->parent_categories as $category):
                                if ($category->has_subcategory > 0): ?>
                                    <li class="nav-item">
                                        <a href="javascript:void(0)" class="nav-link" data-id="<?= $category->id; ?>" data-parent-id="<?= $category->parent_id; ?>"><?php echo category_name($category); ?><i class="icon-arrow-right"></i></a>
                                    </li>
                                <?php else: ?>
                                    <li class="nav-item">
                                        <a href="<?php echo generate_category_url($category); ?>" class="nav-link"><?php echo category_name($category); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach;
                        endif; ?>
                    </ul>
                    <ul id="navbar_mobile_links" class="navbar-nav">
                        <?php if ($this->auth_check): ?>
                            <li class="nav-item">
                                <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>" class="nav-link">
                                    <?php echo trans("wishlist"); ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a href="<?php echo generate_url("wishlist"); ?>" class="nav-link">
                                    <?php echo trans("wishlist"); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($this->menu_links)):
                            foreach ($this->menu_links as $menu_link):
                                if ($menu_link->page_default_name == 'blog' || $menu_link->page_default_name == 'contact' || $menu_link->location == 'top_menu'):
                                    $item_link = generate_menu_item_url($menu_link);
                                    if (!empty($menu_link->page_default_name)):
                                        $item_link = generate_url($menu_link->page_default_name);
                                    endif; ?>
                                    <li class="nav-item"><a href="<?= $item_link; ?>" class="nav-link"><?= html_escape($menu_link->title); ?></a></li>
                                <?php endif;
                            endforeach;
                        endif; ?>

                        <?php if ($this->auth_check): ?>
                            <li class="dropdown profile-dropdown nav-item">
                                <a href="#" class="dropdown-toggle image-profile-drop nav-link" data-toggle="dropdown" aria-expanded="false">
                                    <?php if ($unread_message_count > 0): ?>
                                        <span class="span-message-count span-message-count-profile"><?php echo $unread_message_count; ?></span>
                                    <?php endif; ?>
                                    <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo html_escape($this->auth_user->username); ?>">
                                    <?php echo get_shop_name($this->auth_user); ?> <span class="icon-arrow-down"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if ($this->auth_user->role == "admin"): ?>
                                        <li>
                                            <a href="<?php echo admin_url(); ?>">
                                                <i class="icon-admin"></i>
                                                <?php echo trans("admin_panel"); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (is_user_vendor()): ?>
                                        <li>
                                            <a href="<?= dashboard_url(); ?>">
                                                <i class="icon-dashboard"></i>
                                                <?php echo trans("dashboard"); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a href="<?php echo generate_profile_url($this->auth_user->slug); ?>">
                                            <i class="icon-user"></i>
                                            <?php echo trans("profile"); ?>
                                        </a>
                                    </li>
                                    <?php if ($this->is_sale_active): ?>
                                        <li>
                                            <a href="<?php echo generate_url("orders"); ?>">
                                                <i class="icon-shopping-basket"></i>
                                                <?php echo trans("orders"); ?>
                                            </a>
                                        </li>
                                        <?php if (is_bidding_system_active()): ?>
                                            <li>
                                                <a href="<?php echo generate_url("quote_requests"); ?>">
                                                    <i class="icon-price-tag-o"></i>
                                                    <?php echo trans("quote_requests"); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->general_settings->digital_products_system == 1): ?>
                                            <li>
                                                <a href="<?php echo generate_url("downloads"); ?>">
                                                    <i class="icon-download"></i>
                                                    <?php echo trans("downloads"); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <li>
                                        <a href="<?php echo generate_url("messages"); ?>">
                                            <i class="icon-mail"></i>
                                            <?php echo trans("messages"); ?>&nbsp;<?php if ($unread_message_count > 0): ?>
                                                <span class="span-message-count"><?php echo $unread_message_count; ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo generate_url("settings", "update_profile"); ?>">
                                            <i class="icon-settings"></i>
                                            <?php echo trans("settings"); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>logout" class="logout">
                                            <i class="icon-logout"></i>
                                            <?php echo trans("logout"); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="nav-link close-menu-click"><?php echo trans("login"); ?></a></li>
                            <li class="nav-item"><a href="<?php echo generate_url("register"); ?>" class="nav-link"><?php echo trans("register"); ?></a></li>
                        <?php endif; ?>

                        <?php if ($this->general_settings->location_search_header == 1 && item_count($this->countries) > 0): ?>
                            <li class="nav-item nav-item-messages">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#locationModal" class="nav-link btn-modal-location close-menu-click">
                                    <i class="icon-map-marker float-left"></i>&nbsp;<?= !empty($this->default_location_input) ? $this->default_location_input : trans("location"); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($this->currencies)): ?>
                            <li class="nav-item dropdown language-dropdown currency-dropdown currency-dropdown-mobile">
                                <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                    <?= $this->selected_currency->code; ?>&nbsp;(<?= $this->selected_currency->symbol; ?>)<i class="icon-arrow-down"></i>
                                </a>
                                <?php echo form_open('set-selected-currency-post'); ?>
                                <ul class="dropdown-menu">
                                    <?php foreach ($this->currencies as $currency):
                                        if ($currency->status == 1):?>
                                            <li>
                                                <button type="submit" name="currency" value="<?= $currency->code; ?>"><?= $currency->code; ?>&nbsp;(<?= $currency->symbol; ?>)</button>
                                            </li>
                                        <?php endif;
                                    endforeach; ?>
                                </ul>
                                <?php echo form_close(); ?>
                            </li>
                        <?php endif; ?>

                        <?php if ($this->general_settings->multilingual_system == 1 && count($this->languages) > 1): ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?php echo trans("language"); ?>
                                </a>
                                <ul class="mobile-language-options">
                                    <?php foreach ($this->languages as $language): ?>
                                        <li>
                                            <a href="<?= convert_url_by_language($language); ?>" class="dropdown-item <?php echo ($language->id == $this->selected_lang->id) ? 'selected' : ''; ?>">
                                                <?= html_escape($language->name); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-mobile-footer">
        <?php $this->load->view('partials/_social_links', ['show_rss' => true]); ?>
    </div>
</div>