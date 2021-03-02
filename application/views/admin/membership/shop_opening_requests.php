<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans("shop_opening_requests"); ?></h3>
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
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr role="row">
                            <th width="20"><?php echo trans("id"); ?></th>
                            <th><?php echo trans("image"); ?></th>
                            <th><?php echo trans("username"); ?></th>
                            <th><?php echo trans("shop_name"); ?></th>
                            <th><?php echo trans("shop_description"); ?></th>
                            <th><?php echo trans("location"); ?></th>
                            <th><?= trans("membership_plan"); ?></th>
                            <th><?= trans("payment"); ?></th>
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
                                <td><?php echo html_escape($user->shop_name); ?></td>
                                <td><?php echo html_escape($user->about_me); ?></td>
                                <td><?php echo get_location($user); ?></td>
                                <td><?= !empty($membership_plan) ? $membership_plan->plan_title : ''; ?></td>
                                <td><?php if (!empty($membership_plan)):
                                        echo get_payment_method($membership_plan->payment_method) . "<br>";
                                        if ($membership_plan->payment_status == "awaiting_payment"):?>
                                            <label class="label label-danger"><?= trans("awaiting_payment"); ?></label>
                                        <?php elseif ($membership_plan->payment_status == "payment_received"): ?>
                                            <label class="label label-success"><?= trans("payment_received"); ?></label>
                                        <?php endif;
                                    endif; ?>
                                </td>
                                <td>
                                    <?php echo form_open('membership_controller/approve_shop_opening_request'); ?>
                                    <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <button type="submit" name="submit" value="1" class="btn-list-button">
                                                    <i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?>
                                                </button>
                                            </li>
                                            <li>
                                                <button type="submit" name="submit" value="0" class="btn-list-button">
                                                    <i class="fa fa-times option-icon"></i><?php echo trans('decline'); ?>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php echo form_close(); ?>
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

<?php if (!empty($this->session->userdata('mds_send_email_data'))): ?>
    <script>
        $(document).ready(function () {
            var data = JSON.parse(<?php echo json_encode($this->session->userdata("mds_send_email_data"));?>);
            if (data) {
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "ajax_controller/send_email",
                    data: data,
                    success: function (response) {
                    }
                });
            }
        });
    </script>
<?php endif;
$this->session->unset_userdata('mds_send_email_data'); ?>
