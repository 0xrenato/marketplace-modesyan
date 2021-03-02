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
						<?php $this->load->view('admin/order/_filter_bank_transfers'); ?>
						<thead>
						<tr role="row">
							<th><?php echo trans('id'); ?></th>
							<th><?php echo trans('order'); ?></th>
							<th><?php echo trans('user'); ?></th>
							<th><?php echo trans('receipt'); ?></th>
							<th><?php echo trans('payment_note'); ?></th>
							<th><?php echo trans('status'); ?></th>
							<th><?php echo trans('ip_address'); ?></th>
							<th><?php echo trans('date'); ?></th>
							<th class="max-width-120"><?php echo trans('options'); ?></th>
						</tr>
						</thead>
						<tbody>

						<?php foreach ($bank_transfers as $item): ?>
							<tr>
								<td><?php echo $item->id; ?></td>
								<td>
									<?php
									$order = $this->order_admin_model->get_order_by_order_number($item->order_number);
									if (!empty($order)): ?>
										<a href="<?php admin_url(); ?>order-details/<?php echo $order->id; ?>" class="table-link" target="_blank">#<?php echo $item->order_number; ?></a>
									<?php else: ?>
										#<?php echo $item->order_number; ?>
									<?php endif; ?>
								</td>
								<td>
									<?php if ($item->user_id == 0): ?>
										<label class="label bg-olive"><?php echo trans("guest"); ?></label>
									<?php else:
										$user = get_user($item->user_id);
										if (!empty($user)):?>
											<div class="table-orders-user">
												<a href="<?php echo generate_profile_url($user->slug); ?>" class="table-link" target="_blank">
													<?php echo html_escape($user->username); ?>
												</a>
											</div>
										<?php endif;
									endif;
									?>
								</td>
								<td>
									<?php if (!empty($item->receipt_path)): ?>
										<a class="magnific-image-popup" href="<?php echo base_url() . $item->receipt_path; ?>">
											<img src="<?php echo base_url() . $item->receipt_path; ?>" alt="" style="max-width: 60px; max-height: 60px;">
										</a>
									<?php endif; ?>
								</td>
								<td style="max-width: 300px;"><?php echo $item->payment_note; ?></td>
								<td>
									<?php if ($item->status == 'pending'): ?>
										<label class="label label-default"><?php echo trans("pending"); ?></label>
									<?php elseif ($item->status == 'approved'): ?>
										<label class="label label-success"><?php echo trans("approved"); ?></label>
									<?php elseif ($item->status == 'declined'): ?>
										<label class="label label-danger"><?php echo trans("declined"); ?></label>
									<?php endif; ?>
								</td>
								<td><?php echo $item->ip_address; ?></td>
								<td><?php echo formatted_date($item->created_at); ?></td>
								<td>
									<?php echo form_open_multipart('order_admin_controller/bank_transfer_options_post'); ?>
									<input type="hidden" name="id" value="<?php echo $item->id; ?>">
									<div class="dropdown">
										<button class="btn bg-purple dropdown-toggle btn-select-option"
												type="button"
												data-toggle="dropdown"><?php echo trans('select_option'); ?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu options-dropdown">
											<?php if ($item->status == 'pending'):
												if (!empty($order)): ?>
													<li>
														<a href="javascript:void(0)" onclick="approve_bank_transfer('<?php echo $item->id; ?>','<?php echo $order->id; ?>','<?php echo trans("msg_accept_bank_transfer"); ?>');"><i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?></a>
													</li>
												<?php endif; ?>
												<li>
													<button type="submit" name="option" value="declined" class="btn-list-button">
														<i class="fa fa-times option-icon"></i><?php echo trans('decline'); ?>
													</button>
												</li>
											<?php endif; ?>
											<li>
												<a href="javascript:void(0)" onclick="delete_item('order_admin_controller/delete_bank_transfer_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
											</li>
										</ul>
									</div>
									<?php echo form_close(); ?>
								</td>
							</tr>

						<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($bank_transfers)): ?>
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
