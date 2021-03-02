<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
	<div class="box-header with-border">
		<div class="left">
			<h3 class="box-title"><?php echo trans('payout_requests'); ?></h3>
		</div>
		<div class="right">
			<a href="<?php echo admin_url(); ?>add-payout" class="btn btn-success btn-add-new">
				<i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo trans('add_payout'); ?>
			</a>
		</div>
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
						<?php $this->load->view('admin/earnings/_filter_payouts'); ?>
						<thead>
						<tr role="row">
							<th><?php echo trans('id'); ?></th>
							<th><?php echo trans('user_id'); ?></th>
							<th><?php echo trans('user'); ?></th>
							<th><?php echo trans('withdraw_method'); ?></th>
							<th><?php echo trans('withdraw_amount'); ?></th>
							<th><?php echo trans('status'); ?></th>
							<th><?php echo trans('date'); ?></th>
							<th class="max-width-120"><?php echo trans('options'); ?></th>
						</tr>
						</thead>
						<tbody>

						<?php foreach ($payout_requests as $item): ?>
							<tr>
								<td><?php echo $item->id; ?></td>
								<td><?php echo $item->user_id; ?></td>
								<td>
									<?php $user = get_user($item->user_id);
									if (!empty($user)):?>
										<div class="table-orders-user">
											<a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
												<img src="<?php echo get_user_avatar($user); ?>" alt="buyer" class="img-responsive" style="height: 50px;">
												<?php echo html_escape($user->username); ?>
											</a>
										</div>
									<?php endif; ?>
								</td>
								<td>
									<?php echo trans($item->payout_method); ?>
									<p class="m-0">
										<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#accountDetailsModel_<?php echo $item->id; ?>"><?php echo trans("see_details"); ?></button>
									</p>
								</td>
								<td><?php echo price_formatted($item->amount, $item->currency); ?></td>
								<td>
									<?php if ($item->status == 1) {
										echo trans("completed");
									} else {
										echo trans("pending");
									} ?>
								</td>
								<td><?php echo formatted_date($item->created_at); ?></td>
								<td>
									<?php echo form_open_multipart('earnings_controller/complete_payout_request_post'); ?>
									<input type="hidden" name="payout_id" value="<?php echo $item->id; ?>">
									<input type="hidden" name="user_id" value="<?php echo $item->user_id; ?>">
									<input type="hidden" name="amount" value="<?php echo $item->amount; ?>">

									<div class="dropdown">
										<button class="btn bg-purple dropdown-toggle btn-select-option"
												type="button"
												data-toggle="dropdown"><?php echo trans('select_option'); ?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu options-dropdown">
											<li>
												<button type="submit" name="option" value="completed" class="btn-list-button">
													<i class="fa fa-check option-icon"></i><?php echo trans('completed'); ?>
												</button>
											</li>
											<li>
												<a href="javascript:void(0)" onclick="delete_item('earnings_controller/delete_payout_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
											</li>
										</ul>
									</div>
									<?php echo form_close(); ?>
								</td>
							</tr>

						<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($payout_requests)): ?>
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

<?php foreach ($payout_requests as $item):
	$payout = $this->earnings_model->get_user_payout_account($item->user_id);
	?>
	<!-- Modal -->
	<div id="accountDetailsModel_<?php echo $item->id; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo trans($item->payout_method); ?></h4>
				</div>
				<div class="modal-body">
					<?php if (!empty($payout)): ?>
						<?php if ($item->payout_method == "paypal"): ?>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("user"); ?>
								</div>
								<div class="col-sm-8">
									<?php $user = get_user($payout->user_id);
									if (!empty($user)):?>
										<strong>
											&nbsp;<?php echo $user->username; ?>
										</strong>
									<?php endif; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("paypal_email_address"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->payout_paypal_email; ?>
									</strong>
								</div>
							</div>
						<?php elseif ($item->payout_method == "iban"): ?>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("user"); ?>
								</div>
								<div class="col-sm-8">
									<?php $user = get_user($payout->user_id);
									if (!empty($user)):?>
										<strong>
											&nbsp;<?php echo $user->username; ?>
										</strong>
									<?php endif; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("full_name"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->iban_full_name; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("country"); ?>
								</div>
								<div class="col-sm-8">
									<?php $country = get_country($payout->iban_country_id);
									if (!empty($country)):?>
										<strong>
											&nbsp;<?php echo $country->name; ?>
										</strong>
									<?php endif; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("bank_name"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->iban_bank_name; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("iban"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->iban_number; ?>
									</strong>
								</div>
							</div>
						<?php elseif ($item->payout_method == "swift"): ?>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("user"); ?>
								</div>
								<div class="col-sm-8">
									<?php $user = get_user($payout->user_id);
									if (!empty($user)):?>
										<strong>
											&nbsp;<?php echo $user->username; ?>
										</strong>
									<?php endif; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("full_name"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->swift_full_name; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("address"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->swift_address; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("state"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->swift_state; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("city"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->swift_city; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("postcode"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->swift_postcode; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("country"); ?>
								</div>
								<div class="col-sm-8">
									<?php $branch_country = get_country($payout->swift_country_id);
									if (!empty($branch_country)):?>
										<strong>
											&nbsp;<?php echo $branch_country->name; ?>
										</strong>
									<?php endif; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("bank_account_holder_name"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->swift_bank_account_holder_name; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("iban"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->swift_iban; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("swift_code"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->swift_code; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("bank_name"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->swift_bank_name; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("bank_branch_city"); ?>
								</div>
								<div class="col-sm-8">
									<strong>
										&nbsp;<?php echo $payout->swift_bank_branch_city; ?>
									</strong>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<?php echo trans("bank_branch_country"); ?>
								</div>
								<div class="col-sm-8">
									<?php $branch_country = get_country($payout->swift_bank_branch_country_id);
									if (!empty($branch_country)):?>
										<strong>
											&nbsp;<?php echo $branch_country->name; ?>
										</strong>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
<?php endforeach; ?>

<style>
	.modal-body .row {
		margin-bottom: 8px;
	}
</style>
