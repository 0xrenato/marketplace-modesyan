<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

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
                        <thead>
                        <tr role="row">
                            <th><?= trans("id"); ?></th>
                            <th><?= trans("reported_content"); ?></th>
                            <th><?= trans("sent_by"); ?></th>
                            <th><?= trans("description"); ?></th>
                            <th><?= trans("date"); ?></th>
                            <th class="max-width-120"><?= trans("options"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($abuse_reports as $item): ?>
                            <tr>
                                <td><?= $item->id; ?></td>
                                <?php if ($item->item_type == "product"):
                                    $product = get_product($item->item_id); ?>
                                    <td><?= trans("product"); ?></td>
                                    <td><?php $user = get_user($item->report_user_id);
                                        if (!empty($user)):?>
                                            <a href="<?= generate_profile_url($user->slug); ?>" target="_blank" class="link-black font-600">
                                                <?= html_escape($user->username); ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td style="width: 50%"><?= html_escape($item->description); ?></td>
                                    <td><?= formatted_date($item->created_at); ?></td>
                                    <td style="width: 130px;">
                                        <div class="btn-group btn-group-option">
                                            <a href="<?= !empty($product) ? generate_product_url($product) : ''; ?>" class="btn btn-sm btn-default btn-edit" target="_blank"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo trans("view_content"); ?></a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="delete_item('admin_controller/delete_abuse_report_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </td>
                                <?php elseif ($item->item_type == "seller"):
                                    $seller = get_user($item->item_id); ?>
                                    <td><?= trans("seller"); ?></td>
                                    <td><?php $user = get_user($item->report_user_id);
                                        if (!empty($user)):?>
                                            <a href="<?= generate_profile_url($user->slug); ?>" target="_blank" class="link-black font-600">
                                                <?= html_escape($user->username); ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td style="width: 50%"><?= html_escape($item->description); ?></td>
                                    <td><?= formatted_date($item->created_at); ?></td>
                                    <td style="width: 130px;">
                                        <div class="btn-group btn-group-option">
                                            <a href="<?= !empty($seller) ? generate_profile_url($seller->slug) : ''; ?>" class="btn btn-sm btn-default btn-edit" target="_blank"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo trans("view_content"); ?></a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="delete_item('admin_controller/delete_abuse_report_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </td>
                                <?php elseif ($item->item_type == "review"):
                                    $review = $this->review_model->get_review_by_id($item->item_id); ?>
                                    <td><?= trans("review"); ?></td>
                                    <td><?php $user = get_user($item->report_user_id);
                                        if (!empty($user)):?>
                                            <a href="<?= generate_profile_url($user->slug); ?>" target="_blank" class="link-black font-600">
                                                <?= html_escape($user->username); ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td style="width: 50%"><?= html_escape($item->description); ?></td>
                                    <td><?= formatted_date($item->created_at); ?></td>
                                    <td style="width: 130px;">
                                        <div class="btn-group btn-group-option">
                                            <?php if (!empty($review)): ?>
                                                <a href="#" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalAbuse<?= $item->id; ?>"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo trans("view_content"); ?></a>
                                                <div id="modalAbuse<?= $item->id; ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title"><?= trans("review"); ?></h4>
                                                            </div>
                                                            <div class="modal-body" style="white-space: normal !important;">
                                                                <?php $user = get_user($review->user_id);
                                                                if (!empty($user)):?>
                                                                    <p><strong><?= trans("user"); ?></strong>:&nbsp;<a href="<?= generate_profile_url($user->slug) ?>" target="_blank"><?= $user->username; ?></a></p>
                                                                <?php endif; ?>
                                                                <p>
                                                                    <?= html_escape($review->review); ?>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="javascript:void(0)" class="btn btn-danger pull-right" onclick="delete_item('product_controller/delete_review','<?php echo $review->id; ?>','<?php echo trans("confirm_review"); ?>');"><?= trans('delete'); ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="delete_item('admin_controller/delete_abuse_report_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </td>
                                <?php elseif ($item->item_type == "comment"):
                                    $comment = $this->comment_model->get_comment($item->item_id); ?>
                                    <td><?= trans("comment"); ?></td>
                                    <td><?php $user = get_user($item->report_user_id);
                                        if (!empty($user)):?>
                                            <a href="<?= generate_profile_url($user->slug); ?>" target="_blank" class="link-black font-600">
                                                <?= html_escape($user->username); ?>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td style="width: 50%"><?= html_escape($item->description); ?></td>
                                    <td><?= formatted_date($item->created_at); ?></td>
                                    <td style="width: 130px;">
                                        <div class="btn-group btn-group-option">
                                            <?php if (!empty($comment)): ?>
                                                <a href="#" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalAbuse<?= $item->id; ?>"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo trans("view_content"); ?></a>
                                                <div id="modalAbuse<?= $item->id; ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title"><?= trans("comment"); ?></h4>
                                                            </div>
                                                            <div class="modal-body" style="white-space: normal !important;">
                                                                <?php $user = get_user($comment->user_id);
                                                                if (!empty($user)):?>
                                                                    <p><strong><?= trans("user"); ?></strong>:&nbsp;<a href="<?= generate_profile_url($user->slug) ?>" target="_blank"><?= $user->username; ?></a></p>
                                                                <?php endif; ?>
                                                                <p>
                                                                    <?= html_escape($comment->comment); ?>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="javascript:void(0)" class="btn btn-danger pull-right" onclick="delete_item('product_controller/delete_comment','<?php echo $comment->id; ?>','<?php echo trans("confirm_comment"); ?>');"><?= trans('delete'); ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="delete_item('admin_controller/delete_abuse_report_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php if (empty($abuse_reports)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12">
                <?php if (!empty($abuse_reports)): ?>
                    <div class="number-of-entries">
                        <span><?= trans("number_of_entries"); ?>:</span>&nbsp;&nbsp;<strong><?= $num_rows; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="table-pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

<style>
    .swal-overlay {
        z-index: 999999999 !important;
    }
</style>
