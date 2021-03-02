<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $menu_subcategory_display_limit = 6;
if ($this->general_settings->selected_navigation == 1): ?>
<div class="container">
<div class="navbar navbar-light navbar-expand">
<ul class="nav navbar-nav mega-menu">
<?php $limit = $this->general_settings->menu_limit;
$count = 1;
if (!empty($this->parent_categories)):
foreach ($this->parent_categories as $category):
$array_image_categories = array();
if (!empty($category->image) && $category->show_image_on_navigation == 1) {
array_push($array_image_categories, $category);
}
if ($count <= $limit):?>
<li class="nav-item dropdown" data-category-id="<?php echo $category->id; ?>">
<a id="nav_main_category_<?= $category->id; ?>" href="<?php echo generate_category_url($category); ?>" class="nav-link dropdown-toggle nav-main-category" data-id="<?= $category->id; ?>" data-parent-id="<?= $category->parent_id; ?>" data-has-sb="<?= !empty($category->has_subcategory) ? '1' : '0'; ?>"><?php echo category_name($category); ?></a>
<?php $subcategories = !empty($this->categories_array[$category->id]) ? $this->categories_array[$category->id] : null;
if (!empty($subcategories)): ?>
<div id="mega_menu_content_<?php echo $category->id; ?>" class="dropdown-menu">
<div class="row">
<div class="col-8 menu-subcategories col-category-links">
<div class="card-columns">
<?php foreach ($subcategories as $subcategory):
if (!empty($subcategory->image) && $subcategory->show_image_on_navigation == 1) {
array_push($array_image_categories, $subcategory);
} ?>
<div class="card">
<div class="row">
<div class="col-12">
<a id="nav_main_category_<?= $subcategory->id; ?>" href="<?php echo generate_category_url($subcategory); ?>" class="second-category nav-main-category" data-id="<?= $subcategory->id; ?>" data-parent-id="<?= $subcategory->parent_id; ?>" data-has-sb="<?= !empty($subcategory->has_subcategory) ? '1' : '0'; ?>"><?php echo category_name($subcategory); ?></a>
<?php
$third_categories = !empty($this->categories_array[$subcategory->id]) ? $this->categories_array[$subcategory->id] : null;
if (!empty($third_categories)):
$display_limit = 1; ?>
<ul>
<?php foreach ($third_categories as $third_category):
if (!empty($third_category->image) && $third_category->show_image_on_navigation == 1) {
array_push($array_image_categories, $third_category);
} ?>
<li><a id="nav_main_category_<?= $third_category->id; ?>" href="<?php echo generate_category_url($third_category); ?>" class="nav-main-category <?= ($display_limit > $menu_subcategory_display_limit) ? 'hidden' : ''; ?>" data-id="<?= $third_category->id; ?>" data-parent-id="<?= $third_category->parent_id; ?>" data-has-sb="0"><?= category_name($third_category); ?></a></li>
<?php $display_limit++;
endforeach; ?>
<?php if ($display_limit > $menu_subcategory_display_limit): ?>
<li><a href="<?php echo generate_category_url($subcategory); ?>" class="link-view-all"><?php echo trans("show_all"); ?></a></li>
<?php endif; ?>
</ul>
<?php endif; ?>
</div>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
<div class="col-4 col-category-images">
<?php foreach ($array_image_categories as $image_category): ?>
<div class="nav-category-image">
<a href="<?php echo generate_category_url($image_category); ?>">
<img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_category_image_url($image_category); ?>" alt="<?php echo category_name($image_category); ?>" class="lazyload img-fluid">
<span><?php echo character_limiter(category_name($image_category), 20, '..'); ?></span>
</a>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
<?php endif; ?>
</li>
<?php $count++;
endif;
endforeach;
if (item_count($this->parent_categories) > $limit): ?>
<li class="nav-item dropdown menu-li-more">
<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo trans("more"); ?></a>
<div class="dropdown-menu dropdown-menu-more-items">
<?php $count = 1;
if (!empty($this->parent_categories)):
foreach ($this->parent_categories as $category):
if ($count > $limit):?>
<a href="<?php echo generate_category_url($category); ?>" class="dropdown-item" data-id="<?= $category->id; ?>" data-parent-id="<?= $category->parent_id; ?>" data-has-sb="<?= !empty($category->has_subcategory) ? '1' : '0'; ?>"><?php echo category_name($category); ?></a>

<?php $subcategories = !empty($this->categories_array[$category->id]) ? $this->categories_array[$category->id] : null;
if (!empty($subcategories)):
foreach ($subcategories as $subcategory): ?>
<a id="nav_main_category_<?= $subcategory->id; ?>" href="<?php echo generate_category_url($subcategory); ?>" class="hidden" data-id="<?= $subcategory->id; ?>" data-parent-id="<?= $subcategory->parent_id; ?>" data-has-sb="<?= !empty($subcategory->has_subcategory) ? '1' : '0'; ?>"><?php echo category_name($subcategory); ?></a>
<?php $third_categories = !empty($this->categories_array[$subcategory->id]) ? $this->categories_array[$subcategory->id] : null;
if (!empty($third_categories)):
foreach ($third_categories as $third_category): ?>
<a id="nav_main_category_<?= $third_category->id; ?>" href="<?php echo generate_category_url($third_category); ?>" class="hidden" data-id="<?= $third_category->id; ?>" data-parent-id="<?= $third_category->parent_id; ?>" data-has-sb="0"><?= category_name($third_category); ?></a>
<?php endforeach;
endif;
endforeach;
endif; ?>

<?php endif;
$count++;
endforeach;
endif; ?>
</div>
</li>
<?php endif;
endif; ?>
</ul>
</div>
</div>
<?php else: ?>
<div class="container">
<div class="navbar navbar-light navbar-expand">
<ul class="nav navbar-nav mega-menu">
<?php
$limit = $this->general_settings->menu_limit;
$menu_item_count = 1;
if (!empty($this->parent_categories)):
foreach ($this->parent_categories as $category):
if ($menu_item_count <= $limit):?>
<li class="nav-item dropdown" data-category-id="<?php echo $category->id; ?>">
<a id="nav_main_category_<?= $category->id; ?>" href="<?php echo generate_category_url($category); ?>" class="nav-link dropdown-toggle nav-main-category" data-id="<?= $category->id; ?>" data-parent-id="<?= $category->parent_id; ?>" data-has-sb="<?= !empty($category->has_subcategory) ? '1' : '0'; ?>"><?php echo category_name($category); ?></a>
<?php $subcategories = !empty($this->categories_array[$category->id]) ? $this->categories_array[$category->id] : null;
if (!empty($subcategories)):?>
<div id="mega_menu_content_<?php echo $category->id; ?>" class="dropdown-menu dropdown-menu-large">
<div class="row">
<div class="col-4 left">
<?php $count = 0;
foreach ($subcategories as $subcategory): ?>
<div class="large-menu-item <?php echo ($count == 0) ? 'large-menu-item-first active' : ''; ?>" data-subcategory-id="<?php echo $subcategory->id; ?>">
<a id="nav_main_category_<?= $subcategory->id; ?>" href="<?php echo generate_category_url($subcategory); ?>" class="second-category nav-main-category" data-id="<?= $subcategory->id; ?>" data-parent-id="<?= $subcategory->parent_id; ?>" data-has-sb="<?= !empty($subcategory->has_subcategory) ? '1' : '0'; ?>"><?php echo category_name($subcategory); ?>&nbsp;<i class="icon-arrow-right"></i></a>
</div>
<?php $count++;
endforeach; ?>
</div>
<div class="col-8 right">
<?php
$count = 0;
foreach ($subcategories as $subcategory): ?>
<div id="large_menu_content_<?php echo $subcategory->id; ?>" class="large-menu-content <?php echo ($count == 0) ? 'large-menu-content-first active' : ''; ?>">
<?php $third_categories = !empty($this->categories_array[$subcategory->id]) ? $this->categories_array[$subcategory->id] : null;
if (!empty($third_categories)): ?>
<div class="row">
<div class="card-columns">
<?php foreach ($third_categories as $third_category): ?>
<div class="card item-large-menu-content">
<a id="nav_main_category_<?= $third_category->id; ?>" href="<?php echo generate_category_url($third_category); ?>" class="second-category nav-main-category" data-id="<?= $third_category->id; ?>" data-parent-id="<?= $third_category->parent_id; ?>" data-has-sb="0"><?php echo category_name($third_category); ?></a>
<?php $i = 1;
$fourth_categories = !empty($this->categories_array[$third_category->id]) ? $this->categories_array[$third_category->id] : null;
if (!empty($fourth_categories)): ?>
<ul>
<?php foreach ($fourth_categories as $fourth_category): ?>
<li><a id="nav_main_category_<?= $fourth_category->id; ?>" href="<?php echo generate_category_url($fourth_category); ?>" class="nav-main-category <?= ($i > $menu_subcategory_display_limit) ? 'hidden' : ''; ?>" data-id="<?= $fourth_category->id; ?>" data-parent-id="<?= $fourth_category->parent_id; ?>" data-has-sb="0"><?= category_name($fourth_category); ?></a></li>
<?php $i++;
endforeach; ?>
</ul>
<?php endif; ?>
<?php if ($i - 1 > $menu_subcategory_display_limit): ?>
<div><a href="<?php echo generate_category_url($third_category); ?>" class="link-view-all"><?php echo trans("show_all"); ?></a></div>
<?php endif; ?>
</div>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>
</div>
<?php
$count++;
endforeach; ?>
</div>
</div>
</div>
<?php endif; ?>
</li>
<?php $menu_item_count++;
endif;
endforeach;
if (item_count($this->parent_categories) > $limit): ?>
<li class="nav-item dropdown menu-li-more">
<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo trans("more"); ?></a>
<div class="dropdown-menu dropdown-menu-more-items">
<?php $menu_item_count = 1;
if (!empty($this->parent_categories)):
foreach ($this->parent_categories as $category):
if ($menu_item_count > $limit): ?>
<a href="<?php echo generate_category_url($category); ?>" class="dropdown-item" data-id="<?= $category->id; ?>" data-parent-id="<?= $category->parent_id; ?>" data-has-sb="<?= !empty($category->has_subcategory) ? '1' : '0'; ?>"><?php echo category_name($category); ?></a>

<?php $subcategories = !empty($this->categories_array[$category->id]) ? $this->categories_array[$category->id] : null;
if (!empty($subcategories)):
foreach ($subcategories as $subcategory): ?>
<a id="nav_main_category_<?= $subcategory->id; ?>" href="<?php echo generate_category_url($subcategory); ?>" class="hidden" data-id="<?= $subcategory->id; ?>" data-parent-id="<?= $subcategory->parent_id; ?>" data-has-sb="<?= !empty($subcategory->has_subcategory) ? '1' : '0'; ?>"><?php echo category_name($subcategory); ?></a>
<?php $third_categories = !empty($this->categories_array[$subcategory->id]) ? $this->categories_array[$subcategory->id] : null;
if (!empty($third_categories)):
foreach ($third_categories as $third_category): ?>
<a id="nav_main_category_<?= $third_category->id; ?>" href="<?php echo generate_category_url($third_category); ?>" class="hidden" data-id="<?= $third_category->id; ?>" data-parent-id="<?= $third_category->parent_id; ?>" data-has-sb="0"><?= category_name($third_category); ?></a>
<?php endforeach;
endif;
endforeach;
endif; ?>

<?php endif;
$menu_item_count++;
endforeach;
endif; ?>
</div>
</li>
<?php endif;
endif; ?>
</ul>
</div>
</div>
<?php endif; ?>