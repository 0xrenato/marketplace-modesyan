<div class="row table-filter-container">
    <div class="col-sm-12">
        <?php echo form_open($form_action, ['method' => 'GET']); ?>

        <div class="item-table-filter" style="width: 80px; min-width: 80px;">
            <label><?php echo trans("show"); ?></label>
            <select name="show" class="form-control">
                <option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
                <option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
                <option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
                <option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
            </select>
        </div>
        <div class="item-table-filter">
            <label><?php echo trans("status"); ?></label>
            <select name="status" class="form-control custom-select">
                <option value="" selected><?php echo trans("all"); ?></option>
                <option value="new_quote_request" <?= input_get('status') == 'new_quote_request' ? 'selected' : ''; ?>><?php echo trans("new_quote_request"); ?></option>
                <option value="pending_quote" <?= input_get('status') == 'pending_quote' ? 'selected' : ''; ?>><?php echo trans("pending_quote"); ?></option>
                <option value="pending_payment" <?= input_get('status') == 'pending_payment' ? 'selected' : ''; ?>><?php echo trans("pending_payment"); ?></option>
                <option value="rejected_quote" <?= input_get('status') == 'rejected_quote' ? 'selected' : ''; ?>><?php echo trans("rejected_quote"); ?></option>
                <option value="closed" <?= input_get('status') == 'closed' ? 'selected' : ''; ?>><?php echo trans("closed"); ?></option>
                <option value="completed" <?= input_get('status') == 'completed' ? 'selected' : ''; ?>><?php echo trans("completed"); ?></option>
            </select>
        </div>
        <div class="item-table-filter">
            <label><?php echo trans("search"); ?></label>
            <input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>

        <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
            <label style="display: block">&nbsp;</label>
            <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
