<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $title; ?></h3>
	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="row">
			<!-- include message block -->
			<div class="col-sm-12">
				<?php $this->load->view('admin/includes/_messages'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-bordered table-striped" role="grid">
						<?php $this->load->view('admin/order/_filter_digital_sales'); ?>
						<thead>
						<tr role="row">
							<th><?php echo trans('id'); ?></th>
							<th><?php echo trans('order'); ?></th>
							<th><?php echo trans('purchase_code'); ?></th>
							<th><?php echo trans('seller'); ?></th>
							<th><?php echo trans('buyer'); ?></th>
							<th><?php echo trans('total'); ?></th>
							<th><?php echo trans('currency'); ?></th>
							<th><?php echo trans('date'); ?></th>
							<th class="max-width-120"><?php echo trans('options'); ?></th>
						</tr>
						</thead>
						<tbody>

						<?php foreach ($digital_sales as $item): ?>
							<tr>
								<td><?php echo $item->id; ?></td>
								<td style="width: 120px;">
									<?php $order = get_order($item->order_id);
									if (!empty($order)):?>
										<a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($order->id); ?>" class="table-link">
											#<?php echo html_escape($order->order_number); ?>
										</a>
									<?php endif; ?>
								</td>
								<td><?php echo $item->purchase_code; ?></td>
								<td>
									<?php $seller = get_user($item->seller_id);
									if (!empty($seller)):?>
										<div class="table-orders-user">
											<a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank">
												<img src="<?php echo get_user_avatar($seller); ?>" alt="buyer" class="img-responsive" style="height: 30px;">
												<?php echo html_escape($seller->username); ?>
											</a>
										</div>
									<?php endif; ?>
								</td>
								<td>
									<?php if ($item->buyer_id == 0): ?>
										<div class="table-orders-user">
											<img src="<?php echo get_user_avatar(null); ?>" alt="buyer" class="img-responsive" style="height: 30px;">
											<span><?php echo $item->shipping_first_name . " " . $item->shipping_last_name; ?></span>
											<label class="label bg-olive" style="position: absolute;top: 0; left: 0;"><?php echo trans("guest"); ?></label>
										</div>
									<?php else:
										$buyer = get_user($item->buyer_id);
										if (!empty($buyer)):?>
											<div class="table-orders-user">
												<a href="<?php echo generate_profile_url($buyer->slug); ?>" target="_blank">
													<img src="<?php echo get_user_avatar($buyer); ?>" alt="buyer" class="img-responsive" style="height: 30px;">
													<?php echo html_escape($buyer->username); ?>
												</a>
											</div>
										<?php endif;
									endif;
									?>
								</td>
								<td><strong><?php echo price_formatted($item->price, $item->currency); ?></strong></td>
								<td><?php echo $item->currency; ?></td>
								<td><?php echo formatted_date($item->purchase_date); ?></td>
								<td>
									<input type="hidden" name="id" value="<?php echo $item->id; ?>">
									<div class="dropdown">
										<button class="btn bg-purple dropdown-toggle btn-select-option"
												type="button"
												data-toggle="dropdown"><?php echo trans('select_option'); ?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu options-dropdown" style="min-width: 190px;">
											<li>
												<a href="javascript:void(0)" onclick="delete_item('order_admin_controller/delete_digital_sales_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
											</li>
										</ul>
									</div>
								</td>
							</tr>

						<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($digital_sales)): ?>
						<p class="text-center">
							<?php echo trans("no_records_found"); ?>
						</p>
					<?php endif; ?>
					<div class="col-sm-12 table-ft">
						<div class="row">
							<div class="pull-right">
								<?php echo $this->pagination->create_links(); ?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
</div>
