<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="rating">
    <i class="<?php echo ($review >= 1) ? 'fa fa-star' : 'fa fa-star-o'; ?>"></i>
    <i class="<?php echo ($review >= 2) ? 'fa fa-star' : 'fa fa-star-o'; ?>"></i>
    <i class="<?php echo ($review >= 3) ? 'fa fa-star' : 'fa fa-star-o'; ?>"></i>
    <i class="<?php echo ($review >= 4) ? 'fa fa-star' : 'fa fa-star-o'; ?>"></i>
    <i class="<?php echo ($review >= 5) ? 'fa fa-star' : 'fa fa-star-o'; ?>"></i>
</div>