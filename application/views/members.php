<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Wrapper -->
<div id="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">

				<nav class="nav-breadcrumb" aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php echo trans("members"); ?></li>
					</ol>
				</nav>

				<h1 class="page-title page-title-product"><?php echo trans("members"); ?></h1>

				<div class="row">
					<?php if (!empty($members)): ?>
						<?php foreach ($members as $member): ?>
							<div class="col-md-3 col-sm-6 col-12">
								<div class="member-list-item">
									<div class="left">
										<a href="<?php echo generate_profile_url($member->slug); ?>">
											<img src="<?php echo get_user_avatar($member); ?>" alt="<?php echo get_shop_name($member); ?>" class="img-fluid img-profile lazyload">
										</a>
									</div>
									<div class="right">
										<a href="<?php echo generate_profile_url($member->slug); ?>">
											<p class="username"><?php echo get_shop_name($member); ?></p>
										</a>
										<p><?php echo trans("products") . ": " . get_user_products_count($member->id); ?></p>

										<?php if ($this->auth_check): ?>
											<?php if ($member->id != $this->auth_user->id): ?>
												<?php echo form_open('follow-unfollow-user-post', ['class' => 'form-inline']); ?>
												<input type="hidden" name="following_id" value="<?php echo $member->id; ?>">
												<input type="hidden" name="follower_id" value="<?php echo $this->auth_user->id; ?>">
												<?php if (is_user_follows($member->id, $this->auth_user->id)): ?>
													<p>
														<button class="btn btn-md btn-outline-gray"><i class="icon-user-minus"></i><?php echo trans("unfollow"); ?></button>
													</p>
												<?php else: ?>
													<p>
														<button class="btn btn-md btn-outline-gray"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
													</p>
												<?php endif; ?>
												<?php echo form_close(); ?>
											<?php endif; ?>
										<?php else: ?>
											<p>
												<button class="btn btn-md btn-outline" data-toggle="modal" data-target="#loginModal"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
											</p>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="col-12">
							<p class="no-records-found">
								<?php echo trans("no_members_found"); ?>
							</p>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- Wrapper End-->


