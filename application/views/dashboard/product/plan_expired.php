<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2 m-t-30">
        <div class="alert alert-danger alert-large">
            <?php if (empty($this->membership_model->get_user_plan_by_user_id($this->auth_user->id))): ?>
                <strong><?php echo trans("warning"); ?>!</strong>&nbsp;&nbsp;<?= trans("do_not_have_membership_plan"); ?>
            <?php else: ?>
                <strong><?php echo trans("warning"); ?>!</strong>&nbsp;&nbsp;<?= trans("msg_reached_ads_limit"); ?>
            <?php endif; ?>
        </div>
        <a href="<?= generate_url("select_membership_plan"); ?>" class="btn btn-md btn-block btn-slate m-t-30" style="padding: 10px 12px;"><?php echo trans("select_your_plan") ?></a>
    </div>
</div>