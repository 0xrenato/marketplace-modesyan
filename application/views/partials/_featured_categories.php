<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if (!empty($featured_categories)): ?>
    <div class="featured-categories">
        <div class="card-columns">
            <?php foreach ($featured_categories as $category): ?>
                <div class="card lazyload" data-bg="<?php echo get_category_image_url($category); ?>">
                    <a href="<?php echo generate_category_url($category); ?>">
                        <div class="caption text-truncate">
                            <span><?php echo category_name($category); ?></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

