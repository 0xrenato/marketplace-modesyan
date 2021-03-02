<div class="row table-filter-container">
    <div class="col-sm-12">
        <?php echo form_open($page_url, ['method' => 'GET']); ?>
        <div class="item-table-filter">
            <label><?php echo trans('product_type'); ?></label>
            <select name="product_type" class="form-control custom-select">
                <option value="" selected><?php echo trans("all"); ?></option>
                <option value="physical" <?= input_get('product_type') == 'physical' ? 'selected' : ''; ?>><?= trans("physical"); ?></option>
                <option value="digital" <?= input_get('product_type') == 'digital' ? 'selected' : ''; ?>><?= trans("digital"); ?></option>
            </select>
        </div>
        <div class="item-table-filter">
            <label><?php echo trans('category'); ?></label>
            <select id="categories" name="category" class="form-control custom-select" onchange="get_filter_subcategories_dashboard(this.value);">
                <option value=""><?php echo trans("all"); ?></option>
                <?php $categories = $this->category_model->get_parent_categories();
                foreach ($categories as $item): ?>
                    <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('category', true) == $item->id) ? 'selected' : ''; ?>>
                        <?php echo category_name($item); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="item-table-filter">
            <div class="form-group">
                <label class="control-label"><?php echo trans('subcategory'); ?></label>
                <select id="subcategories" name="subcategory" class="form-control custom-select">
                    <option value=""><?php echo trans("all"); ?></option>
                    <?php if (!empty($this->input->get('category', true))):
                        $subcategories = get_subcategories(input_get('category'));
                        if (!empty($subcategories)) {
                            foreach ($subcategories as $item):?>
                                <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('subcategory', true) == $item->id) ? 'selected' : ''; ?>><?php echo $item->name; ?></option>
                            <?php endforeach;
                        }
                    endif;
                    ?>
                </select>
            </div>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans('stock'); ?></label>
            <select name="stock" class="form-control custom-select">
                <option value="" selected><?php echo trans("all"); ?></option>
                <option value="in_stock" <?= input_get("stock") == "in_stock" ? 'selected' : ''; ?>><?php echo trans("in_stock"); ?></option>
                <option value="out_of_stock" <?= input_get("stock") == 'out_of_stock' ? 'selected' : ''; ?>><?php echo trans("out_of_stock"); ?></option>
            </select>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("search"); ?></label>
            <input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>


        <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
            <label style="display: block">&nbsp;</label>
            <button type="submit" class="btn bg-purple btn-filter"><?php echo trans("filter"); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
