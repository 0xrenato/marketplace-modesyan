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
						<?php $this->load->view('admin/earnings/_filter_earnings'); ?>
						<thead>
						<tr role="row">
							<th><?php echo trans('id'); ?></th>
							<th><?php echo trans('order'); ?></th>
							<th><?php echo trans('user'); ?></th>
							<th><?php echo trans('price'); ?></th>
							<th><?php echo trans('commission_rate'); ?></th>
							<th><?php echo trans('shipping_cost'); ?></th>
							<th><?php echo trans('earned_amount'); ?></th>
							<th><?php echo trans('date'); ?></th>
							<th class="max-width-120"><?php echo trans('options'); ?></th>
						</tr>
						</thead>
						<tbody>

						<?php foreach ($earnings as $item): ?>
							<tr>
								<td><?php echo $item->id; ?></td>
								<td>#<?php echo $item->order_number; ?></td>
								<td>
									<?php $user = get_user($item->user_id);
									if (!empty($user)):?>
										<div class="table-orders-user">
											<a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
												<?php echo html_escape($user->username); ?>
											</a>
										</div>
									<?php endif; ?>
								</td>
								<td><?php echo price_formatted($item->price, $item->currency); ?></td>
								<td><?php echo $item->commission_rate; ?>%</td>
								<td><?php echo price_formatted($item->shipping_cost, $item->currency); ?></td>
                                <td>
                                    <?php echo price_formatted($item->earned_amount, $item->currency);
                                    $order = get_order_by_order_number($item->order_number);
                                    if (!empty($order) && $order->payment_method == "Cash On Delivery"):?>
                                        <span class="text-danger">(-<?php echo price_formatted($item->earned_amount, $item->currency); ?>)</span><br><small class="text-danger"><?php echo trans("cash_on_delivery"); ?></small>
                                    <?php endif; ?>
                                </td>
								<td><?php echo formatted_date($item->created_at); ?></td>
								<td>
									<div class="dropdown">
										<button class="btn bg-purple dropdown-toggle btn-select-option"
												type="button"
												data-toggle="dropdown"><?php echo trans('select_option'); ?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu options-dropdown">
											<li>
												<a href="javascript:void(0)" onclick="delete_item('earnings_controller/delete_earning_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
											</li>
										</ul>
									</div>
								</td>
							</tr>

						<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($earnings)): ?>
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
