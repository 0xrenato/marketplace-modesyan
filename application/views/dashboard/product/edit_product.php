<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($product->is_draft == 1): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="wizard-product">
                <h1 class="product-form-title"><?= html_escape($title); ?></h1>
                <div class="row">
                    <div class="col-md-12 wizard-add-product">
                        <ul class="wizard-progress">
                            <li class="active" id="step_general"><strong><?= trans("general_information"); ?></strong></li>
                            <li id="step_dedails"><strong><?= trans("details"); ?></strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-add-product">
            <div class="box-body">
                <?php if ($product->is_draft != 1): ?>
                    <h1 class="product-form-title"><?= html_escape($title); ?></h1>
                <?php endif; ?>
                <div class="alert-message-lg">
                    <?php $this->load->view('dashboard/includes/_messages'); ?>
                </div>
                <div class="row">
                    <div class="col-sm-12 m-b-30">
                        <label class="control-label"><?php echo trans("images"); ?></label>
                        <?php $this->load->view("dashboard/product/_image_update_box"); ?>
                    </div>
                </div>
                <?php echo form_open('edit-product-post', ['id' => 'form_validate', 'class' => 'validate_price', 'onkeypress' => "return event.keyCode != 13;"]); ?>
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                <input type="hidden" name="sys_lang_id" value="<?= $this->selected_lang->id; ?>">
                <?php if ($this->general_settings->physical_products_system == 1 && $this->general_settings->digital_products_system == 0): ?>
                    <input type="hidden" name="product_type" value="physical">
                <?php elseif ($this->general_settings->physical_products_system == 0 && $this->general_settings->digital_products_system == 1): ?>
                    <input type="hidden" name="product_type" value="digital">
                <?php else: ?>
                    <div class="form-group">
                        <label class="control-label"><?= trans('product_type'); ?></label>
                        <div class="row">
                            <?php if ($this->general_settings->physical_products_system == 1): ?>
                                <div class="col-12 col-sm-6 col-custom-field">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="product_type" value="physical" id="product_type_1" class="custom-control-input" <?php echo ($product->product_type == 'physical') ? 'checked' : ''; ?> required>
                                        <label for="product_type_1" class="custom-control-label"><?php echo trans('physical'); ?></label>
                                        <p class="form-element-exp"><?php echo trans('physical_exp'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->general_settings->digital_products_system == 1): ?>
                                <div class="col-12 col-sm-6 col-custom-field">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="product_type" value="digital" id="product_type_2" class="custom-control-input" <?php echo ($product->product_type == 'digital') ? 'checked' : ''; ?> required>
                                        <label for="product_type_2" class="custom-control-label"><?php echo trans('digital'); ?></label>
                                        <p class="form-element-exp"><?php echo trans('digital_exp'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($active_product_system_array['active_system_count'] > 1): ?>
                    <div class="form-group">
                        <label class="control-label"><?= trans('listing_type'); ?></label>
                        <div class="row">
                            <?php if ($this->general_settings->marketplace_system == 1): ?>
                                <div class="col-12 col-sm-6 col-custom-field listing_sell_on_site">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="listing_type" value="sell_on_site" id="listing_type_1" class="custom-control-input" <?php echo ($product->listing_type == 'sell_on_site') ? 'checked' : ''; ?> required>
                                        <label for="listing_type_1" class="custom-control-label"><?php echo trans('add_product_for_sale'); ?></label>
                                        <p class="form-element-exp"><?php echo trans('add_product_for_sale_exp'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->general_settings->classified_ads_system == 1): ?>
                                <div class="col-12 col-sm-6 col-custom-field listing_ordinary_listing" <?= $product->product_type == 'digital' ? 'style="display:none;"' : ''; ?>>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="listing_type" value="ordinary_listing" id="listing_type_2" class="custom-control-input" <?php echo ($product->listing_type == 'ordinary_listing') ? 'checked' : ''; ?> required>
                                        <label for="listing_type_2" class="custom-control-label"><?php echo trans('add_product_services_listing'); ?></label>
                                        <p class="form-element-exp"><?php echo trans('add_product_services_listing_exp'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->general_settings->bidding_system == 1): ?>
                                <div class="col-12 col-sm-6 col-custom-field listing_bidding">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="listing_type" value="bidding" id="listing_type_3" class="custom-control-input" <?php echo ($product->listing_type == 'bidding') ? 'checked' : ''; ?> required>
                                        <label for="listing_type_3" class="custom-control-label"><?php echo trans('add_product_get_price_requests'); ?></label>
                                        <p class="form-element-exp"><?php echo trans('add_product_get_price_requests_exp'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->general_settings->digital_products_system == 1 && $this->general_settings->selling_license_keys_system == 1): ?>
                                <div class="col-12 col-sm-6 col-custom-field listing_license_keys" <?= $product->product_type == 'physical' ? 'style="display:none;"' : ''; ?>>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="listing_type" value="license_key" id="listing_type_4" class="custom-control-input" <?php echo ($product->listing_type == 'license_key') ? 'checked' : ''; ?> required>
                                        <label for="listing_type_4" class="custom-control-label"><?php echo trans('add_product_sell_license_keys'); ?></label>
                                        <p class="form-element-exp"><?php echo trans('add_product_sell_license_keys_exp'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="listing_type" value="<?php echo $active_product_system_array['active_system_value']; ?>">
                <?php endif; ?>

                <div class="form-group form-group-category">
                    <label class="control-label"><?php echo trans("category"); ?></label>
                    <div id="category_select_container">
                        <?php $i = 0;
                        if (!empty($parent_categories_array)):
                            foreach ($parent_categories_array as $category):?>
                                <select id="categories" name="category_id[]" class="form-control custom-select<?= $i == 0 ? ' category-select-first' : ''; ?>" data-select-id="<?= $i; ?>" onchange="get_subcategories(this.value, '<?= $i; ?>');" <?= $i == 0 ? 'required' : ''; ?>>
                                    <option value=""><?php echo trans('select_category'); ?></option>
                                    <?php $subcategories = get_subcategories($category->parent_id);
                                    if (!empty($subcategories)):?>
                                        <?php foreach ($subcategories as $subcategory): ?>
                                            <option value="<?php echo $subcategory->id; ?>" <?php echo ($subcategory->id == $category->id) ? 'selected' : ''; ?>> <?= category_name($subcategory); ?></option>
                                        <?php endforeach;
                                    endif; ?>
                                </select>
                                <?php $i++;
                            endforeach;
                            if (!empty($category)):
                                $subcategories = get_subcategories($category->id);
                                if (!empty($subcategories)): ?>
                                    <select name="category_id[]" class="form-control custom-select" data-select-id="<?= $i; ?>" onchange="get_subcategories(this.value, '<?= $i; ?>');">
                                        <option value=""><?php echo trans('select_category'); ?></option>
                                        <?php foreach ($subcategories as $subcategory): ?>
                                            <option value="<?php echo $subcategory->id; ?>"> <?= category_name($subcategory); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif;
                            endif;
                        else: ?>
                            <select id="categories" name="category_id[]" class="form-control custom-select m-0" onchange="get_subcategories(this.value, 0);" required>
                                <option value=""><?php echo trans('select_category'); ?></option>
                                <?php if (!empty($this->parent_categories)):
                                    foreach ($this->parent_categories as $item): ?>
                                        <option value="<?php echo html_escape($item->id); ?>"><?php echo category_name($item); ?></option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                            <div id="category_select_container"></div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (is_admin()): ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('slug'); ?></label>
                        <input type="text" name="slug" class="form-control form-input" value="<?= html_escape($product->slug); ?>" placeholder="<?= trans("slug"); ?>" maxlength="200">
                    </div>
                <?php endif; ?>

                <?php if ($product->is_draft != 1): ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('status'); ?></label>
                        <select name="is_sold" class="form-control custom-select" required>
                            <option value="0" <?= $product->is_sold != 1 ? 'selected' : ''; ?>><?= trans('active'); ?></option>
                            <option value="1" <?= $product->is_sold == 1 ? 'selected' : ''; ?>><?= trans('sold'); ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('visibility'); ?></label>
                        <select name="visibility" class="form-control custom-select" required>
                            <option value="1" <?php echo ($product->visibility == 1) ? 'selected' : ''; ?>><?php echo trans('visible'); ?></option>
                            <option value="0" <?php echo ($product->visibility == 0) ? 'selected' : ''; ?>><?php echo trans('hidden'); ?></option>
                        </select>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="panel-group panel-group-product">
            <?php $languages = array();
            array_push($languages, $this->selected_lang);
            if (!empty($this->languages)):
                foreach ($this->languages as $language):
                    if (!empty($language->id != $this->selected_lang->id)) {
                        array_push($languages, $language);
                    }
                endforeach;
            endif;
            if (!empty($languages)):
                foreach ($languages as $language):
                    $product_details = get_product_details($product->id, $language->id, false); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#collapse_<?= $language->id; ?>"><?= trans("details"); ?><?= item_count($this->languages) > 1 ? ':&nbsp;' . $language->name : ''; ?>&nbsp;<?= $this->selected_lang->id != $language->id ? "(" . trans("optional") . ")" : ''; ?><i class="fa fa-caret-down pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapse_<?= $language->id; ?>" class="panel-collapse collapse <?= $this->selected_lang->id == $language->id ? 'in' : ''; ?>">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label"><?php echo trans("title"); ?></label>
                                    <input type="text" name="title_<?= $language->id; ?>" value="<?= !empty($product_details) ? $product_details->title : ''; ?>" class="form-control form-input" placeholder="<?php echo trans("title"); ?>" <?= $this->selected_lang->id == $language->id ? 'required' : ''; ?> maxlength="490">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo trans("description"); ?></label>
                                    <div class="row">
                                        <div class="col-sm-12 m-b-5">
                                            <button type="button" id="btn_add_image_editor" class="btn btn-sm btn-info" data-editor-id="editor_<?= $language->id; ?>" data-toggle="modal" data-target="#fileManagerModal"><i class="icon-image"></i>&nbsp;&nbsp;<?php echo trans("add_image"); ?></button>
                                        </div>
                                    </div>
                                    <textarea name="description_<?= $language->id; ?>" id="editor_<?= $language->id; ?>" class="tinyMCEsmall text-editor"><?php echo !empty($product_details) ? $product_details->description : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= trans("seo"); ?></label>
                                    <input type="text" name="seo_title_<?= $language->id; ?>" value="<?= !empty($product_details) ? $product_details->seo_title : ''; ?>" class="form-control form-input m-b-5" placeholder="<?php echo trans("title"); ?>" maxlength="490">
                                    <input type="text" name="seo_description_<?= $language->id; ?>" value="<?= !empty($product_details) ? $product_details->seo_description : ''; ?>" class="form-control form-input m-b-5" placeholder="<?php echo trans("description"); ?>" maxlength="490">
                                    <input type="text" name="seo_keywords_<?= $language->id; ?>" value="<?= !empty($product_details) ? $product_details->seo_keywords : ''; ?>" class="form-control form-input m-b-5" placeholder="<?php echo trans("keywords"); ?> (E.g. book, new, pencil)" maxlength="490">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>

    <div class="col-sm-12">
        <?php if ($product->is_draft == 1): ?>
            <button type="submit" class="btn btn-lg btn-success pull-right"><?php echo trans("save_and_continue"); ?></button>
        <?php else: ?>
            <a href="<?php echo generate_dash_url("product", "product_details") . "/" . $product->id; ?>" class="btn btn-lg btn-primary pull-right"><?php echo trans("edit_details"); ?></a>
            <button type="submit" class="btn btn-lg btn-success pull-right m-r-10"><?php echo trans("save_changes"); ?></button>
        <?php endif; ?>
    </div>
</div>
<?php echo form_close(); ?>

<div class="modal fade" id="fileManagerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-file-manager" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo trans("images"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="file-manager">
                    <div class="file-manager-left">
                        <div class="dm-uploader-container">
                            <div id="drag-and-drop-zone-file-manager" class="dm-uploader text-center">
                                <p class="file-manager-file-types">
                                    <span>JPG</span>
                                    <span>JPEG</span>
                                    <span>PNG</span>
                                </p>
                                <p class="dm-upload-icon">
                                    <i class="icon-upload"></i>
                                </p>
                                <p class="dm-upload-text"><?php echo trans("drag_drop_images_here"); ?></p>
                                <p class="text-center">
                                    <button class="btn btn-default btn-browse-files"><?php echo trans('browse_files'); ?></button>
                                </p>
                                <a class='btn btn-md dm-btn-select-files'>
                                    <input type="file" name="file" size="40" multiple="multiple">
                                </a>
                                <ul class="dm-uploaded-files" id="files-file-manager"></ul>
                                <button type="button" id="btn_reset_upload_image" class="btn btn-reset-upload"><?php echo trans("reset"); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="file-manager-right">
                        <div class="file-manager-content">
                            <div id="ckimage_file_upload_response">
                                <?php foreach ($file_manager_images as $image): ?>
                                    <div class="col-file-manager" id="ckimg_col_id_<?php echo $image->id; ?>">
                                        <div class="file-box" data-file-id="<?php echo $image->id; ?>" data-file-path="<?php echo get_file_manager_image($image); ?>">
                                            <div class="image-container">
                                                <img src="<?php echo get_file_manager_image($image); ?>" alt="" class="img-responsive">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="selected_ckimg_file_id">
                    <input type="hidden" id="selected_ckimg_file_path">
                </div>
            </div>
            <div class="modal-footer">
                <div class="file-manager-footer">
                    <button type="button" id="btn_ckimg_delete" class="btn btn-sm btn-danger color-white pull-left btn-file-delete m-r-3"><i class="icon-trash"></i>&nbsp;&nbsp;<?php echo trans('delete'); ?></button>
                    <button type="button" id="btn_ckimg_select" class="btn btn-sm btn-info color-white btn-file-select"><i class="icon-check"></i>&nbsp;&nbsp;<?php echo trans('select_image'); ?></button>
                    <button type="button" class="btn btn-sm btn-secondary color-white" data-dismiss="modal"><?php echo trans('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function get_subcategories(category_id, data_select_id) {
        var subcategories = get_subcategories_array(category_id);
        var date = new Date();
        //reset subcategories
        $('#category_select_container select').each(function () {
            if (parseInt($(this).attr('data-select-id')) > parseInt(data_select_id)) {
                $(this).remove();
            }
        });
        if (category_id == 0) {
            return false;
        }
        if (subcategories.length > 0) {
            var new_data_select_id = date.getTime();
            var select_tag = '<select class="form-control custom-select" name="category_id[]" data-select-id="' + new_data_select_id + '" onchange="get_subcategories(this.value,' + new_data_select_id + ');">' +
                '<option value=""><?php echo trans("select_category"); ?></option>';
            for (i = 0; i < subcategories.length; i++) {
                select_tag += '<option value="' + subcategories[i].id + '">' + subcategories[i].name + '</option>';
            }
            select_tag += '</select>';
            $('#category_select_container').append(select_tag);
        }
    }

    function get_subcategories_array(category_id) {
        var categories_array = <?php echo get_categories_json($this->selected_lang->id); ?>;
        var subcategories_array = [];
        for (i = 0; i < categories_array.length; i++) {
            if (categories_array[i].parent_id == category_id) {
                subcategories_array.push(categories_array[i]);
            }
        }
        return subcategories_array;
    }
</script>

<script type="text/html" id="files-template-file-manager">
    <li class="media">
        <img class="preview-img" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="">
        <div class="media-body">
            <div class="progress">
                <div class="dm-progress-waiting"><?php echo trans("waiting"); ?></div>
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </li>
</script>

<script>
    var txt_processing = "<?php echo trans("txt_processing"); ?>";
    $(function () {
        $('#drag-and-drop-zone-file-manager').dmUploader({
            url: '<?php echo base_url(); ?>upload-file-manager-images-post',
            queue: true,
            allowedTypes: 'image/*',
            extFilter: ["jpg", "jpeg", "png"],
            extraData: function (id) {
                return {
                    "file_id": id,
                    "<?php echo $this->security->get_csrf_token_name(); ?>": $.cookie(csfr_cookie_name)
                };
            },
            onNewFile: function (id, file) {
                ui_multi_add_file(id, file, "file-manager");
                if (typeof FileReader !== "undefined") {
                    var reader = new FileReader();
                    var img = $('#uploaderFile' + id).find('img');
                    reader.onload = function (e) {
                        img.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            },
            onBeforeUpload: function (id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
                $("#btn_reset_upload_image").show();
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id, data) {
                document.getElementById("uploaderFile" + id).remove();
                refresh_ck_images();
                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                ui_multi_update_file_progress(id, 100, 'success', false);
                $("#btn_reset_upload_image").hide();
            }
        });
    });
    $(document).on('click', '#btn_reset_upload_image', function () {
        $("#drag-and-drop-zone-file-manager").dmUploader("reset");
        $("#files-file-manager").empty();
        $(this).hide();
    });
</script>
