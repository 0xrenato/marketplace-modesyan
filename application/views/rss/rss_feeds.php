<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="blog-content">
					<nav class="nav-breadcrumb" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?php echo html_escape($title); ?></li>
						</ol>
					</nav>
					<h1 class="page-title"><?php echo html_escape($title); ?></h1>
					<div class="row">
						<div class="col-sm-12">
							<div class="page-text-content">
								<div class="rss-item">
									<div class="left">
										<a href="<?php echo lang_base_url(); ?>rss/<?php echo get_route("latest_products"); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo trans("latest_products"); ?></a>
									</div>
									<div class="right">
										<p><?php echo lang_base_url() . "rss/" . get_route("latest_products"); ?></p>
									</div>
								</div>
								<div class="rss-item">
									<div class="left">
										<a href="<?php echo lang_base_url(); ?>rss/<?php echo get_route("featured_products"); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo trans("featured_products"); ?></a>
									</div>
									<div class="right">
										<p><?php echo lang_base_url() . "rss/" . get_route("featured_products"); ?></p>
									</div>
								</div>
								<?php if (!empty($this->parent_categories)):
									foreach ($this->parent_categories as $category): ?>
										<div class="rss-item">
											<div class="left">
												<a href="<?php echo lang_base_url(); ?>rss/<?php echo get_route("category"); ?>/<?php echo html_escape($category->slug); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo category_name($category); ?></a>
											</div>
											<div class="right">
												<p><?php echo lang_base_url(); ?>rss/<?php echo get_route("category"); ?>/<?php echo html_escape($category->slug); ?></p>
											</div>
										</div>
									<?php
									endforeach;
								endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- Wrapper End-->
