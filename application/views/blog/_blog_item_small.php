<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="blog-item blog-item-small">
	<div class="blog-item-img">
		<a href="<?php echo generate_url("blog") . "/" . $item->category_slug . "/" . $item->slug; ?>">
			<img src="<?php echo base_url().IMG_BG_BLOG_SMALL; ?>" data-src="<?php echo get_blog_image_url($item, 'image_small'); ?>" alt="<?php echo html_escape($item->title); ?>"
				 class="img-fluid lazyload" onerror="this.src='<?php echo base_url().IMG_BG_BLOG_SMALL; ?>'">
		</a>
	</div>
	<h3 class="blog-post-title">
		<a href="<?php echo generate_url("blog") . "/" . $item->category_slug . "/" . $item->slug; ?>">
			<?php echo html_escape(character_limiter($item->title, 56, '...')); ?>
		</a>
	</h3>
	<div class="blog-post-meta">
		<span><i class="icon-clock"></i><?php echo time_ago($item->created_at); ?></span>
		<a href="<?php echo generate_url("blog") . "/" . $item->category_slug; ?>">
			<i class="icon-folder"></i><?php echo html_escape($item->category_name); ?>
		</a>
	</div>
</div>
