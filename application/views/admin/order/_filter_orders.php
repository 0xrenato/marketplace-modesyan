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
            <select name="status" class="form-control">
                <option value="" selected><?php echo trans("all"); ?></option>
                <option value="completed" <?php echo ($this->input->get('status', true) == 'completed') ? 'selected' : ''; ?>><?php echo trans("completed"); ?></option>
                <option value="processing" <?php echo ($this->input->get('status', true) == 'processing') ? 'selected' : ''; ?>><?php echo trans("order_processing"); ?></option>
            </select>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("payment_status"); ?></label>
            <select name="payment_status" class="form-control">
                <option value="" selected><?php echo trans("all"); ?></option>
                <option value="payment_received" <?php echo ($this->input->get('payment_status', true) == 'payment_received') ? 'selected' : ''; ?>><?php echo trans("payment_received"); ?></option>
                <option value="awaiting_payment" <?php echo ($this->input->get('payment_status', true) == 'awaiting_payment') ? 'selected' : ''; ?>><?php echo trans("awaiting_payment"); ?></option>
            </select>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("search"); ?></label>
            <input name="q" class="form-control" placeholder="<?php echo trans("order_id"); ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>

        <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
            <label style="display: block">&nbsp;</label>
            <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>