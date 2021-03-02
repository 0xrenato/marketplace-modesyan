<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="rating">
    <i class="<?php echo ($review >= 1) ? 'icon-star' : 'icon-star-o'; ?>"></i>
    <i class="<?php echo ($review >= 2) ? 'icon-star' : 'icon-star-o'; ?>"></i>
    <i class="<?php echo ($review >= 3) ? 'icon-star' : 'icon-star-o'; ?>"></i>
    <i class="<?php echo ($review >= 4) ? 'icon-star' : 'icon-star-o'; ?>"></i>
    <i class="<?php echo ($review >= 5) ? 'icon-star' : 'icon-star-o'; ?>"></i>
</div>