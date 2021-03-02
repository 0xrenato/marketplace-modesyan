<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-products">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <?php if (!empty($parent_categories)):
                            foreach ($parent_categories as $item):
                                if ($item->id == $category->id):?>
                                    <li class="breadcrumb-item active"><?php echo category_name($item); ?></li>
                                <?php else: ?>
                                    <li class="breadcrumb-item"><a href="<?php echo generate_category_url($item); ?>"><?php echo category_name($item); ?></a></li>
                                <?php endif; ?>
                            <?php endforeach;
                        else:?>
                            <li class="breadcrumb-item active"><?= trans("products"); ?></li>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>
        </div>
        <?php
        $search = clean_str($this->input->get('search', TRUE));
        if (!empty($search)):?>
            <input type="hidden" name="search" value="<?= $search; ?>">
        <?php endif; ?>
        <div class="row">
            <div class="col-12 product-list-header">
                <?php if (!empty($category)): ?>
                    <h1 class="page-title product-list-title"><?php echo category_name($category); ?></h1>
                <?php else: ?>
                    <h1 class="page-title product-list-title"><?php echo trans("products"); ?></h1>
                <?php endif; ?>
                <div class="product-sort-by">
                    <span class="span-sort-by"><?php echo trans("sort_by"); ?></span>
                    <?php $filter_sort = str_slug($this->input->get('sort', true)); ?>
                    <div class="sort-select">
                        <select id="select_sort_items" class="custom-select" data-current-url="<?= current_url(); ?>" data-query-string="<?= generate_filter_url($query_string_array, 'rmv_srt', ''); ?>" data-page="products">
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

        <div class="row">
            <?php $array_option_names = array(); ?>
            <div class="col-12 col-md-3 col-sidebar-products">
                <div id="collapseFilters" class="product-filters">
                    <?php if (!empty($categories)): ?>
                        <div class="filter-item">
                            <h4 class="title"><?= trans("category"); ?></h4>
                            <?php if (!empty($category)):
                                $url = generate_url("products");
                                if (!empty($parent_category)) {
                                    $url = generate_category_url($parent_category);
                                } ?>
                                <a href="<?= $url . generate_filter_url($query_string_array, '', ''); ?>" class="filter-list-categories-parent">
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
                                                <a href="<?= generate_category_url($item) . generate_filter_url($query_string_array, '', ''); ?>" <?= !empty($category) && $category->id == $item->id ? 'class="active"' : ''; ?>><?= category_name($item); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php $array_field_names = array();
                    if (!empty($custom_filters)):
                        foreach ($custom_filters as $custom_filter):
                            $filter_name = parse_serialized_name_array($custom_filter->name_array, $this->selected_lang->id);
                            @$array_field_names[$custom_filter->product_filter_key] = $filter_name;
                            $options = get_product_filters_options($custom_filter, $this->selected_lang->id, $subcategory_ids, $custom_filters, $query_string_array);
                            if (!empty($options)): ?>
                                <div class="filter-item">
                                    <h4 class="title"><?= $filter_name; ?></h4>
                                    <div class="filter-list-container">
                                        <?php if (item_count($options) > 11): ?>
                                            <input type="text" class="form-control filter-search-input" placeholder="<?= trans("search") . " " . $filter_name; ?>" data-filter-id="product_filter_<?= $custom_filter->id; ?>">
                                        <?php endif; ?>
                                        <ul id="product_filter_<?= $custom_filter->id; ?>" class="filter-list filter-custom-scrollbar">
                                            <?php foreach ($options as $option):
                                                $option_name = get_custom_field_option_name($option);
                                                @$array_option_names[$custom_filter->product_filter_key . "_" . $option->option_key] = $option_name; ?>
                                                <li>
                                                    <a href="<?= current_url() . generate_filter_url($query_string_array, $custom_filter->product_filter_key, $option->option_key); ?>" rel="nofollow">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" <?= is_custom_field_option_selected($query_string_object_array, $custom_filter->product_filter_key, $option->option_key) ? 'checked' : ''; ?>>
                                                            <label class="custom-control-label"><?= $option_name; ?></label>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif;
                        endforeach;
                    endif; ?>
                    <?php if ($this->general_settings->marketplace_system == 1 || $this->general_settings->bidding_system == 1 || $this->product_settings->classified_price == 1):
                        $filter_p_min = clean_number($this->input->get('p_min', true));
                        $filter_p_max = clean_number($this->input->get('p_max', true)); ?>
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
                                        <button type="button" id="btn_filter_price" data-current-url="<?= current_url(); ?>" data-query-string="<?= generate_filter_url($query_string_array, 'rmv_prc', ''); ?>" data-page="products" class="btn btn-sm btn-default btn-filter-price float-left"><i class="icon-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row-custom">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces_sidebar", ["ad_space" => "products_sidebar", "class" => "m-b-15"]); ?>
                </div>
            </div>

            <div class="col-12 col-md-9 col-content-products">
                <div class="filter-reset-tag-container">
                    <?php $show_reset_link = false;
                    if (!empty($query_string_object_array)):
                        foreach ($query_string_object_array as $filter):
                            if ($filter->key != 'sort'):
                                $show_reset_link = true;

                                if ($filter->key == "p_min"): ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>" rel="nofollow"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title"><?= trans("price") . '(' . $this->selected_currency->symbol . ')'; ?></span>
                                            <span><?= trans("min") . ": " . html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "p_max"): ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>" rel="nofollow"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title"><?= trans("price") . '(' . $this->selected_currency->symbol . ')'; ?></span>
                                            <span><?= trans("max") . ": " . html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php elseif ($filter->key == "search"): ?>
                                    <div class="filter-reset-tag">
                                        <div class="left">
                                            <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>" rel="nofollow"><i class="icon-close"></i></a>
                                        </div>
                                        <div class="right">
                                            <span class="reset-tag-title"><?= trans("search"); ?></span>
                                            <span><?= html_escape($filter->value); ?></span>
                                        </div>
                                    </div>
                                <?php else:
                                    if (!empty($array_option_names[$filter->key . "_" . $filter->value])):?>
                                        <div class="filter-reset-tag">
                                            <div class="left">
                                                <a href="<?= current_url() . generate_filter_url($query_string_array, $filter->key, $filter->value); ?>" rel="nofollow"><i class="icon-close"></i></a>
                                            </div>
                                            <div class="right">
                                                <span class="reset-tag-title"><?= isset($array_field_names[$filter->key]) ? $array_field_names[$filter->key] : ucfirst($filter->key); ?></span>
                                                <span><?= $array_option_names[$filter->key . "_" . $filter->value]; ?></span>
                                            </div>
                                        </div>
                                    <?php endif;
                                endif;
                            endif;
                        endforeach;
                    endif; ?>

                    <?php if ($show_reset_link): ?>
                        <a href="<?= current_url(); ?>" class="link-reset-filters" rel="nofollow"><?= trans("reset_filters"); ?></a>
                    <?php endif; ?>
                </div>
                <div class="product-list-content">
                    <div class="row row-product">
                        <!--print products-->
                        <?php foreach ($products as $product): ?>
                            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-product">
                                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
                            </div>
                        <?php endforeach; ?>
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

                <div class="col-12">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "products", "class" => "m-t-15"]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->
