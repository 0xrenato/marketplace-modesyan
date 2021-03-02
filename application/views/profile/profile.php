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
                            <li class="breadcrumb-item active" aria-current="page"><?php echo trans("profile"); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-12">
                <div class="profile-page-top">
                    <?php $this->load->view("profile/_profile_user_info"); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php $this->load->view("profile/_profile_tabs"); ?>
            </div>
            <?php if (!empty($products) && ($user->role == "admin" || $user->role == "vendor")): ?>
                <div class="col-12">
                    <div class="profile-tab-content">
                        <div class="row">
                            <div class="col-12 col-md-3 col-sidebar-products">
                                <div id="collapseFilters" class="product-filters">
                                    <div class="filter-item">
                                        <div class="profile-search">
                                            <input type="search" name="search" id="input_search_vendor" class="form-control form-input profile-search" placeholder="<?= trans("search"); ?>">
                                            <button id="btn_search_vendor" class="btn btn-default btn-search" data-current-url="<?= current_url(); ?>" data-query-string="<?= generate_filter_url($query_string_array, 'rmv_psrc', ''); ?>"><i class="icon-search"></i></button>
                                        </div>
                                    </div>
                                    <?php if (!empty($categories)): ?>
                                        <div class="filter-item">
                                            <h4 class="title"><?= trans("category"); ?></h4>
                                            <?php if (!empty($category)):
                                                $url = generate_profile_url($user->slug) . generate_filter_url($query_string_array, 'rmv_p_cat', '');
                                                if (!empty($parent_category)) {
                                                    $url = generate_profile_url($user->slug) . generate_filter_url($query_string_array, 'p_cat', $parent_category->id);
                                                } ?>
                                                <a href="<?= $url . '#products'; ?>" class="filter-list-categories-parent">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                                                    </svg>
                                                    <span><?= category_name($category); ?></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (item_count($subcategory_ids) > 1): ?>
                                                <div class="filter-list-container">
                                                    <ul class="filter-list filter-custom-scrollbar<?= !empty($category) ? ' filter-list-subcategories' : ' filter-list-categories'; ?>">
                                                        <?php foreach ($categories as $item): ?>
                                                            <li>
                                                                <a href="<?= generate_profile_url($user->slug) . generate_filter_url($query_string_array, 'p_cat', $item->id) . '#products'; ?>" <?= !empty($category) && $category->id == $item->id ? 'class="active"' : ''; ?>><?= category_name($item); ?></a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($this->general_settings->marketplace_system == 1 || $this->general_settings->bidding_system == 1 || $this->product_settings->classified_price == 1):
                                        $filter_p_min = clean_number(input_get("p_min"));
                                        $filter_p_max = clean_number(input_get("p_max")); ?>
                                        <div class="filter-item">
                                            <h4 class="title"><?php echo trans("price"); ?></h4>
                                            <div class="price-filter-inputs">
                                                <div class="row align-items-baseline row-price-inputs">
                                                    <div class="col-4 col-md-4 col-lg-5 col-price-inputs">
                                                        <span><?php echo trans("min"); ?></span>
                                                        <input type="input" id="price_min" value="<?= !empty($filter_p_min) ? $filter_p_min : ''; ?>" class="form-control price-filter-input" placeholder="<?php echo trans("min"); ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                    </div>
                                                    <div class="col-4 col-md-4 col-lg-5 col-price-inputs">
                                                        <span><?php echo trans("max"); ?></span>
                                                        <input type="input" id="price_max" value="<?= !empty($filter_p_max) ? $filter_p_max : ''; ?>" class="form-control price-filter-input" placeholder="<?php echo trans("max"); ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                    </div>
                                                    <div class="col-4 col-md-4 col-lg-2 col-price-inputs text-left">
                                                        <button type="button" id="btn_filter_price" data-current-url="<?= current_url(); ?>" data-query-string="<?= generate_filter_url($query_string_array, 'rmv_prc', ''); ?>" data-page="profile" class="btn btn-sm btn-default btn-filter-price float-left"><i class="icon-arrow-right"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="row-custom m-b-30">
                                    <?php if ($this->auth_check):
                                        if ($user->id != $this->auth_user->id):?>
                                            <a href="javascript:void(0)" class="text-muted link-abuse-report" data-toggle="modal" data-target="#reportSellerModal">
                                                <?= trans("report_this_seller"); ?>
                                            </a>
                                        <?php endif;
                                    else: ?>
                                        <a href="javascript:void(0)" class="text-muted link-abuse-report" data-toggle="modal" data-target="#loginModal">
                                            <?= trans("report_this_seller"); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="row-custom">
                                    <?php $this->load->view("partials/_ad_spaces_sidebar", ["ad_space" => "profile_sidebar", "class" => "m-t-30"]); ?>
                                </div>
                            </div>

                            <div class="col-12 col-md-9 col-content-products">
                                <div class="row">
                                    <div class="col-12 product-list-header">
                                        <div class="filter-reset-tag-container">
                                            <?php $show_reset_link = false;
                                            if (!empty($query_string_object_array)):
                                                foreach ($query_string_object_array as $filter):
                                                    if ($filter->key != 'sort' && $filter->key != 'p_cat'):
                                                        $show_reset_link = true;
                                                        if ($filter->key == "p_min"): ?>
                                                            <div class="filter-reset-tag">
                                                                <div class="left">
                                                                    <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value) . "#products"; ?>" rel="nofollow"><i class="icon-close"></i></a>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="reset-tag-title"><?= trans("price") . '(' . $this->selected_currency->symbol . ')'; ?></span>
                                                                    <span><?= trans("min") . ": " . html_escape($filter->value); ?></span>
                                                                </div>
                                                            </div>
                                                        <?php elseif ($filter->key == "p_max"): ?>
                                                            <div class="filter-reset-tag">
                                                                <div class="left">
                                                                    <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value) . "#products"; ?>" rel="nofollow"><i class="icon-close"></i></a>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="reset-tag-title"><?= trans("price") . '(' . $this->selected_currency->symbol . ')'; ?></span>
                                                                    <span><?= trans("max") . ": " . html_escape($filter->value); ?></span>
                                                                </div>
                                                            </div>
                                                        <?php elseif ($filter->key == "search"): ?>
                                                            <div class="filter-reset-tag">
                                                                <div class="left">
                                                                    <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value) . "#products"; ?>" rel="nofollow"><i class="icon-close"></i></a>
                                                                </div>
                                                                <div class="right">
                                                                    <span class="reset-tag-title"><?= trans("search"); ?></span>
                                                                    <span><?= html_escape($filter->value); ?></span>
                                                                </div>
                                                            </div>
                                                        <?php endif;
                                                    endif;
                                                endforeach;
                                            endif; ?>

                                            <?php if ($show_reset_link): ?>
                                                <a href="<?= current_url() . "#products"; ?>" class="link-reset-filters" rel="nofollow"><?= trans("reset_filters"); ?></a>
                                            <?php endif; ?>
                                        </div>

                                        <div class="product-sort-by">
                                            <span class="span-sort-by"><?php echo trans("sort_by"); ?></span>
                                            <?php $filter_sort = input_get('sort'); ?>
                                            <div class="sort-select">
                                                <select id="select_sort_items" class="custom-select" data-current-url="<?= current_url(); ?>" data-query-string="<?= generate_filter_url($query_string_array, 'rmv_srt', ''); ?>" data-page="profile">
                                                    <option value="most_recent"<?= $filter_sort == 'most_recent' ? ' selected' : ''; ?>><?= trans("most_recent"); ?></option>
                                                    <option value="lowest_price"<?= $filter_sort == 'lowest_price' ? ' selected' : ''; ?>><?= trans("lowest_price"); ?></option>
                                                    <option value="highest_price"<?= $filter_sort == 'highest_price' ? ' selected' : ''; ?>><?= trans("highest_price"); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-filter-products-mobile" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                                            <i class="icon-filter"></i>&nbsp;<?php echo trans("filter_products"); ?>
                                        </button>
                                    </div>
                                </div>

                                <div class="product-list-content">
                                    <div class="row row-product">
                                        <?php if (!empty($products)):
                                            foreach ($products as $product): ?>
                                                <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-product">
                                                    <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
                                                </div>
                                            <?php endforeach;
                                        endif; ?>
                                        <?php if (empty($products)): ?>
                                            <div class="col-12">
                                                <p class="no-records-found"><?php echo trans("no_products_found"); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="product-list-pagination">
                                    <div class="float-right">
                                        <?php echo $this->pagination->create_links(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-custom">
                        <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-12">
                    <div class="profile-tab-content"></div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>

<?php if ($this->auth_check && !empty($user) && $user->id != $this->auth_user->id): ?>
    <div class="modal fade" id="reportSellerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom modal-report-abuse">
                <form id="form_report_seller" method="post">
                    <input type="hidden" name="id" value="<?= $user->id; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo trans("report_this_seller"); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="response_form_report_seller" class="col-12"></div>
                            <div class="col-12">
                                <div class="form-group m-0">
                                    <label><?= trans("description"); ?></label>
                                    <textarea name="description" class="form-control form-textarea" placeholder="<?= trans("abuse_report_exp"); ?>" minlength="5" maxlength="10000" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-md btn-custom"><?php echo trans("submit"); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    var pagination_links = document.querySelectorAll(".pagination a");
    var i;
    for (i = 0; i < pagination_links.length; i++) {
        pagination_links[i].href = pagination_links[i].href + "#products";
    }
</script>

