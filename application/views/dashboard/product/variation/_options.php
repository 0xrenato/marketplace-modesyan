<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo trans("options"); ?>&nbsp;(<?php echo html_escape(get_variation_label($variation->label_names, $this->selected_lang->id)); ?>)</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="icon-close"></i></span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="variation-options-container">
                <?php if (!empty($variation_options)): ?>
                    <ul>
                        <?php foreach ($variation_options as $option): ?>
                            <li>
                                <div class="pull-left">
                                    <strong class="font-500"><?php echo html_escape(get_variation_option_name($option->option_names, $this->selected_lang->id)); ?></strong>
                                    <?php if ($option->is_default != 1): ?>
                                        <span><?php echo trans("stock"); ?>:&nbsp;<strong><?php echo $option->stock; ?></strong></span>
                                    <?php endif; ?>
                                    <?php if ($option->is_default == 1): ?>
                                        <label class="label label-success"><?php echo trans("default"); ?></label>
                                    <?php endif; ?>
                                </div>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-sm btn-default btn-variation-table" onclick='edit_product_variation_option("<?php echo $variation->id; ?>","<?php echo $option->id; ?>");'><i class="icon-edit"></i><?php echo trans('edit'); ?></button>
                                    <button type="button" class="btn btn-sm btn-danger btn-variation-table" onclick='delete_product_variation_option("<?php echo $variation->id; ?>","<?php echo $option->id; ?>","<?php echo trans("confirm_delete"); ?>");'><i class="icon-trash"></i><?php echo trans('delete'); ?></button>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted text-center m-t-15"> <?php echo trans("no_records_found"); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="row-custom">
        <button type="submit" class="btn btn-md btn-secondary color-white pull-right" data-dismiss="modal"><?php echo trans("close"); ?></button>
    </div>
</div>
