<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?php echo base_url(); ?>assets/admin/vendor/sortable/Sortable.js"></script>
<?php function print_sub_categories($parent_id)
{
    $ci =& get_instance();
    if (isset($ci->categories_array[$parent_id])) {
        $subcategories = $ci->categories_array[$parent_id];
        if (!empty($subcategories)) {
            foreach ($subcategories as $category) {
                $i = 0;
                if ($i == 0) {
                    echo '<div id="panel_group_' . $category->id . '" class="panel-group">';
                    echo '<div id="category_item_' . $category->id . '" data-item-id="' . $category->id . '" class="panel panel-default category-item">';
                    $div_content = '<div class="panel-heading" data-item-id="' . $category->id . '" href="#collapse_' . $category->id . '">';
                    $div_content .= '<div class="left">';
                    $div_content .= '<i class="fa fa-caret-right"></i>' . category_name($category) . '<span class="id">(' . trans("id") . ': ' . $category->id . ')</span>';
                    $div_content .= '</div>';
                    $div_content .= '<div class="right">';
                    $div_content .= ($category->is_featured == 1) ? '<label class="label bg-teal">' . trans("featured") . '</label>' : '';
                    $div_content .= ($category->visibility == 1) ? '<label class="label bg-olive">' . trans("visible") . '</label>' : '<label class="label bg-danger">' . trans("hidden") . '</label>';
                    $div_content .= '<div class="btn-group btn-group-option">';
                    $div_content .= '<a href="' . admin_url() . 'update-category/' . $category->id . '" class="btn btn-sm btn-default btn-edit">' . trans("edit") . '</a>';
                    $div_content .= '<a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" data-item-id="' . $category->id . '"><i class="fa fa-trash-o"></i></a>';
                    $div_content .= '</div>';
                    $div_content .= '</div>';
                    $div_content .= '</div>';
                    echo $div_content;
                    echo '<div id="collapse_' . $category->id . '" class="panel-collapse collapse"><div class="panel-body nested-sortable" data-parent-id="' . $category->id . '">';
                } else {
                    echo '<div id="collapse_' . $category->id . '" class="list-group-item category-item" data-item-id="' . $category->id . '">' . category_name($category) . '<span class="id">(' . trans("id") . ': ' . $category->id . ')</span>' . '</div>';
                }
                print_sub_categories($category->id);
                $i++;
                if ($i > 0) {
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
    }
} ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('categories'); ?></h3>
        </div>
        <div class="right">
            <a href="<?php echo admin_url(); ?>add-category" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo trans('add_category'); ?>
            </a>
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="col-sm-12">

            <div class="row">
                <div class="category-filters">
                    <?php if (item_count($this->languages) > 1): ?>
                        <div class="item-filter">
                            <label><?php echo trans("language"); ?></label>
                            <select name="lang_id" class="form-control" onchange="window.location.href = '<?php echo admin_url(); ?>categories?lang='+this.value+'&parent=<?= $parent; ?>'" style="max-width: 600px;">
                                <?php foreach ($this->languages as $language): ?>
                                    <option value="<?php echo $language->id; ?>" <?php echo ($language->id == $lang) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($parent_categories)): ?>
                        <div class="item-filter item-filter-select">
                            <label><?php echo trans("parent_category"); ?></label>
                            <select class="form-control" onchange="window.location.href = '<?php echo admin_url(); ?>categories?lang=<?= $lang; ?>&parent='+this.value;" style="max-width: 600px;">
                                <option value=""><?= trans("all"); ?></option>
                                <?php foreach ($parent_categories as $category): ?>
                                    <option value="<?php echo $category->id; ?>" <?php echo ($category->id == $parent) ? 'selected' : ''; ?>><?= category_name($category); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row row-category-message">
                <?php if (empty($this->session->flashdata('msg_settings'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
            </div>

            <div class="row">
                <div class="categories-panel-group nested-sortable">
                    <?php if (!empty($parent)):
                        $parent_category = $this->category_model->get_category_back_end($parent);
                        if (!empty($parent_category)):?>
                            <div id="panel_group_<?= $parent_category->id; ?>" class="panel-group" draggable="false">
                                <div id="category_item_<?= $parent_category->id; ?>" data-item-id="<?= $parent_category->id; ?>" class="panel panel-default category-item">
                                    <div class="panel-heading" data-item-id="<?= $parent_category->id; ?>" href="#collapse_<?= $parent_category->id; ?>">
                                        <div class="left"><i class="fa fa-caret-down"></i><?= category_name($parent_category); ?> <span class="id">( <?= trans("id") . ': ' . $parent_category->id; ?>)</span></div>
                                        <div class="right">
                                            <?php if ($parent_category->is_featured == 1): ?>
                                                <label class="label bg-teal"><?= trans("featured"); ?></label>
                                            <?php endif; ?>
                                            <?php if ($parent_category->visibility == 1): ?>
                                                <label class="label bg-olive"><?= trans("visible"); ?></label>
                                            <?php else: ?>
                                                <label class="label bg-danger"><?= trans("hidden"); ?></label>
                                            <?php endif; ?>
                                            <div class="btn-group">
                                                <a href="<?= admin_url(); ?>update-category/<?= $parent_category->id; ?>" class="btn btn-sm btn-default btn-edit"><?= trans("edit"); ?></a>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" data-item-id="<?= $parent_category->id; ?>"><i class="fa fa-trash-o"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapse_<?= $parent_category->id; ?>" class="panel-collapse collapse in" aria-expanded="true" style="">
                                        <div class="panel-body nested-sortable" data-parent-id="<?= $parent_category->id; ?>">
                                            <?php print_sub_categories($parent_category->id); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                    else:
                        print_sub_categories(0);
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('settings'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('category_controller/category_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('msg_settings'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group m-b-30">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans("sort_categories"); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-12 col-option">
                            <input type="radio" name="sort_categories" value="category_order" id="by_category_order_1" class="square-purple" <?php echo ($this->general_settings->sort_categories == 'category_order') ? 'checked' : ''; ?>>
                            <label for="by_category_order_1" class="option-label"><?php echo trans('by_category_order'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-12 col-option">
                            <input type="radio" name="sort_categories" value="date" id="by_date_1" class="square-purple" <?php echo ($this->general_settings->sort_categories == 'date') ? 'checked' : ''; ?>>
                            <label for="by_date_1" class="option-label"><?php echo trans('by_date'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-12 col-option">
                            <input type="radio" name="sort_categories" value="date_desc" id="by_date_desc_1" class="square-purple" <?php echo ($this->general_settings->sort_categories == 'date_desc') ? 'checked' : ''; ?>>
                            <label for="by_date_desc_1" class="option-label"><?php echo trans('by_date'); ?>&nbsp;(DESC)</label>
                        </div>
                        <div class="col-md-3 col-sm-12 col-option">
                            <input type="radio" name="sort_categories" value="alphabetically" id="alphabetically_1" class="square-purple" <?php echo ($this->general_settings->sort_categories == 'alphabetically') ? 'checked' : ''; ?>>
                            <label for="alphabetically_1" class="option-label"><?php echo trans('alphabetically'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('sort_parent_categories_by_category_order'); ?></label>&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="sort_parent_categories_by_order" value="1" class="square-purple" <?php echo ($this->general_settings->sort_parent_categories_by_order == 1) ? 'checked' : ''; ?>>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->

            <?php echo form_close(); ?><!-- form end -->
        </div>
        <div class="alert alert-info alert-large">
            <strong><?php echo trans("warning"); ?>!</strong>&nbsp;&nbsp;<?php echo trans("warning_category_sort"); ?>
        </div>
    </div>
</div>

<script>
    var categories_array = JSON.parse(JSON.stringify(<?= $json_categories;?>));
    $(document).on("click", ".panel .panel-heading", function (e) {
        if ($(e.target).is('div') || $(e.target).is('span') || $(e.target).is('.fa-caret-right') || $(e.target).is('.fa-caret-down')) {
            var id = $(this).attr('data-item-id');
            $('#collapse_' + id).collapse("toggle");
            $('.left .fa', this).toggleClass('fa-caret-right').toggleClass('fa-caret-down');
        }
    });

    $(document).on("click", ".panel .panel-heading .btn-delete", function (e) {
        var id = $(this).attr('data-item-id');
        delete_item("category_controller/delete_category_post", id, "<?= trans("confirm_category");?>");
    });
</script>

<?php if ($this->general_settings->sort_categories == 'category_order'): ?>
    <script>
        var nestedSortables = [].slice.call(document.querySelectorAll('.nested-sortable'));
        for (var i = 0; i < nestedSortables.length; i++) {
            new Sortable(nestedSortables[i], {
                group: 'nested',
                animation: 50,
                fallbackOnBody: true,
                swapThreshold: 0.65,
                ghostClass: "sortable-chosen",
                chosenClass: "sortable-chosen",
                dragClass: "sortable-chosen",
                onEnd: function (event) {
                    var i;
                    for (i = 0; i < categories_array.length; i++) {
                        var parent_id = $("#category_item_" + categories_array[i].id).parent().closest(".category-item").attr("data-item-id");
                        var index = $("#panel_group_" + categories_array[i].id).index();
                        if (parent_id == null || parent_id == undefined) {
                            parent_id = 0;
                        }
                        if (index == null || index == undefined) {
                            index = 0;
                        }
                        categories_array[i].parent_id = parent_id;
                        categories_array[i].index = index + 1;
                    }
                    var data = {
                        'json_categories': JSON.stringify(categories_array)
                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);
                    $.ajax({
                        type: "POST",
                        url: base_url + "category_controller/sort_categories_json",
                        data: data,
                        success: function (response) {
                        }
                    });
                }
            });
        }
    </script>
<?php endif; ?>
<style>
    .btn-group-option {
        display: inline-block !important;
    }
</style>
