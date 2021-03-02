<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

    <div class="box">
        <div class="box-header with-border">
            <div class="left">
                <h3 class="box-title"><?php echo trans("vendors"); ?></h3>
            </div>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <?php $this->load->view('admin/includes/_messages'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <?php $this->load->view('admin/membership/_filters'); ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr role="row">
                                <th width="20"><?php echo trans("id"); ?></th>
                                <th><?php echo trans("image"); ?></th>
                                <th><?php echo trans("username"); ?></th>
                                <th><?php echo trans("email"); ?></th>
                                <th><?= trans("membership_plan"); ?></th>
                                <th><?php echo trans("status"); ?></th>
                                <th><?php echo str_replace(":", "", trans("last_seen")); ?></th>
                                <th><?php echo trans("date"); ?></th>
                                <th class="max-width-120"><?php echo trans("options"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user):
                                $membership_plan = $this->membership_model->get_user_plan_by_user_id($user->id); ?>
                                <tr>
                                    <td><?php echo html_escape($user->id); ?></td>
                                    <td>
                                        <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="table-link">
                                            <img src="<?php echo get_user_avatar($user); ?>" alt="user" class="img-responsive" style="width: 50px;">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="table-link"><?php echo html_escape($user->username); ?></a>
                                    </td>
                                    <td>
                                        <?php echo html_escape($user->email);
                                        if ($user->email_status == 1): ?>
                                            <small class="text-success">(<?php echo trans("confirmed"); ?>)</small>
                                        <?php else: ?>
                                            <small class="text-danger">(<?php echo trans("unconfirmed"); ?>)</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= !empty($membership_plan) ? $membership_plan->plan_title : ''; ?></td>
                                    <td>
                                        <?php if ($user->banned == 0): ?>
                                            <label class="label label-success"><?php echo trans('active'); ?></label>
                                        <?php else: ?>
                                            <label class="label label-danger"><?php echo trans('banned'); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo time_ago($user->last_seen); ?></td>
                                    <td><?php echo formatted_date($user->created_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                    type="button"
                                                    data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="javascript:void(0)" onclick="open_close_user_shop(<?php echo $user->id; ?>,'<?php echo trans("confirm_close_user_shop"); ?>');"><i class="fa fa-times option-icon"></i><?php echo trans('close_user_shop'); ?></a>
                                                </li>
                                                <?php if (!empty($membership_plans)): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalAssign<?= $user->id; ?>"><i class="fa fa-check-circle-o option-icon"></i><?php echo trans('assign_membership_plan'); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <?php if ($user->email_status != 1): ?>
                                                        <a href="javascript:void(0)" onclick="confirm_user_email(<?php echo $user->id; ?>);"><i class="fa fa-check option-icon"></i><?php echo trans('confirm_user_email'); ?></a>
                                                    <?php endif; ?>
                                                </li>
                                                <li>
                                                    <?php if ($user->banned == 0): ?>
                                                        <a href="javascript:void(0)" onclick="ban_remove_ban_user(<?php echo $user->id; ?>);"><i class="fa fa-stop-circle option-icon"></i><?php echo trans('ban_user'); ?></a>
                                                    <?php else: ?>
                                                        <a href="javascript:void(0)" onclick="ban_remove_ban_user(<?php echo $user->id; ?>);"><i class="fa fa-circle option-icon"></i><?php echo trans('remove_user_ban'); ?></a>
                                                    <?php endif; ?>
                                                </li>
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>edit-user/<?php echo $user->id; ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit_user'); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="delete_item('membership_controller/delete_user_post','<?php echo $user->id; ?>','<?php echo trans("confirm_user"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php if (empty($users)): ?>
                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-sm-12 text-right">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>

<?php if (!empty($users)):
    foreach ($users as $user): ?>
        <div id="modalAssign<?= $user->id; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?php echo form_open("membership_controller/assign_membership_plan_post"); ?>
                    <input type="hidden" name="user_id" value="<?= $user->id; ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?= trans("assign_membership_plan"); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?= trans("membership_plan"); ?></label>
                            <?php if (!empty($membership_plans)): ?>
                                <select class="form-control" name="plan_id" required>
                                    <option value=""><?= trans("select"); ?></option>
                                    <?php foreach ($membership_plans as $plan): ?>
                                        <option value="<?= $plan->id; ?>"><?= get_membership_plan_name($plan->title_array, $this->selected_lang->id); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><?= trans("submit"); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    <?php endforeach;
endif; ?>