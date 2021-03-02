<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($cart_payment_method->payment_option == "cash_on_delivery"): ?>
	<?php if ($mds_payment_type != 'promote'): ?>
		<!--PRODUCT SALES-->
		<div class="row">
			<div class="col-12">
				<?php $this->load->view('product/_messages'); ?>
			</div>
		</div>
		<?php echo form_open('cash-on-delivery-payment-post'); ?>
		<div id="payment-button-container" class="payment-button-cnt">
			<p class="m-b-30">
				<?php echo trans("cash_on_delivery_warning"); ?>
			</p>
			<button type="submit" name="submit" value="update" class="btn btn-lg btn-custom btn-payment m-t-30"><?php echo trans("place_order") ?></button>
		</div>
		<?php echo form_close(); ?>
	<?php endif; ?>
<?php endif; ?>

<script>
    $('form').submit(function () {
        $(".btn-place-order").prop('disabled', true);
    });
</script>