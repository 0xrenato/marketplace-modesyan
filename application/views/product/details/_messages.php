<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ($this->session->flashdata('product_details_success')): ?>
	<div class="row-custom m-b-15">
		<div class="product-details-message success-message">
			<p>
				<i class="icon-check"></i>
				<?php echo $this->session->flashdata('product_details_success'); ?>
			</p>
		</div>
	</div>
<?php elseif ($this->session->flashdata('product_details_error')): ?>
	<div class="row-custom m-b-15">
		<div class="product-details-message error-message">
			<p>
				<i class="icon-times"></i>
				<?php echo $this->session->flashdata('product_details_error'); ?>
			</p>
		</div>
	</div>
<?php endif; ?>
