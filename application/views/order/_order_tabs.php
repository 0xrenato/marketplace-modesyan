<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="profile-tabs">
	<ul class="nav">
		<li class="nav-item <?php echo ($active_tab == 'active_orders') ? 'active' : ''; ?>">
			<a class="nav-link" href="<?php echo generate_url("orders"); ?>">
				<span><?php echo trans("active_orders"); ?></span>
			</a>
		</li>
		<li class="nav-item <?php echo ($active_tab == 'completed_orders') ? 'active' : ''; ?>">
			<a class="nav-link" href="<?php echo generate_url("orders", "completed_orders"); ?>">
				<span><?php echo trans("completed_orders"); ?></span>
			</a>
		</li>
	</ul>
</div>
