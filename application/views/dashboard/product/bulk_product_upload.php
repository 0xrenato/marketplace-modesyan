<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/file-uploader/css/jquery.dm-uploader.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/file-uploader/css/styles.css"/>
<script src="<?php echo base_url(); ?>assets/vendor/file-uploader/js/jquery.dm-uploader.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/file-uploader/js/ui.js"></script>

<div class="row">
    <div class="col-sm-12 col-lg-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo $title; ?></h3><br>
                    <small><?= trans("bulk_product_upload_exp"); ?></small>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label"><?php echo trans("listing_type"); ?></label>
                    <select id="select_listing_type" name="listing_type" class="form-control custom-select" required>
                        <option value=""><?= trans("select"); ?></option>
                        <?php if ($this->general_settings->marketplace_system == 1): ?>
                            <option value="sell_on_site"><?= trans('add_product_for_sale'); ?></option>
                        <?php endif;
                        if ($this->general_settings->classified_ads_system == 1): ?>
                            <option value="ordinary_listing"><?= trans('add_product_services_listing'); ?></option>
                        <?php endif;
                        if ($this->general_settings->bidding_system == 1): ?>
                            <option value="bidding"><?= trans('add_product_get_price_requests'); ?></option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("currency"); ?></label>
                    <select id="select_currency" name="currency" class="form-control custom-select" required>
                        <option value=""><?= trans("select"); ?></option>
                        <?php if (!empty($this->currencies)):
                            foreach ($this->currencies as $key => $value): ?>
                                <option value="<?php echo $key; ?>" <?= $key == $this->default_currency->code ? 'class="default"' : ''; ?>><?= $key . " (" . $value->symbol . ")"; ?></option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('csv_file'); ?></label>
                    <div class="dm-uploader-container">
                        <div id="drag-and-drop-zone" class="dm-uploader dm-uploader-csv text-center">
                            <p class="dm-upload-icon">
                                <i class="fa fa-cloud-upload"></i>
                            </p>
                            <p class="dm-upload-text"><?php echo trans("drag_drop_file_here"); ?></p>
                            <p class="text-center">
                                <button class="btn btn-default btn-browse-files"><?php echo trans('browse_files'); ?></button>
                            </p>
                            <a class='btn btn-md dm-btn-select-files'>
                                <input type="file" name="file" size="40" multiple="multiple">
                            </a>
                            <ul class="dm-uploaded-files" id="files-file"></ul>
                            <button type="button" id="btn_reset_upload" class="btn btn-reset-upload"><?php echo trans("reset"); ?></button>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div id="csv_upload_spinner" class="csv-upload-spinner">
                                <strong class="text-csv-importing"><?= trans("processing"); ?></strong>
                                <strong class="text-csv-import-completed"><?= trans("completed"); ?>!</strong>
                                <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="csv-uploaded-files-container">
                                <ul id="csv_uploaded_files" class="list-group csv-uploaded-files"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('help_documents'); ?></h3><br>
                    <small><?= trans("help_documents_exp"); ?></small>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <?php echo form_open('dashboard_controller/download_csv_files_post'); ?>
                    <button class="btn btn-success btn-block" name="submit" value="csv_template"><?= trans("download_csv_template"); ?></button>
                    <button class="btn btn-blue btn-block" name="submit" value="csv_example"><?= trans("download_csv_example"); ?></button>
                    <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modalDocumentation"><?= trans("documentation"); ?></button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('category_id_finder'); ?></h3><br>
                    <small><?= trans("category_id_finder_exp"); ?></small>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label><?= trans("search"); ?></label>
                    <input type="text" id="input_category_name" class="form-control" placeholder="<?= trans("category_name"); ?>">
                    <div id="category_search_result" class="category-search-result"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalDocumentation" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 0;">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h4 class="modal-title"><?php echo trans('bulk_product_upload'); ?></h4>
            </div>
            <div class="modal-body">
                <table style="width:100%" class="table table-bordered">
                    <tr>
                        <th><?php echo trans('field'); ?></th>
                        <th><?php echo trans('description'); ?></th>
                    </tr>
                    <tr>
                        <td style="width: 180px;">title</td>
                        <td><?= trans("data_type"); ?>: Text <br><strong><?= trans("required"); ?></strong><br><?= trans("example"); ?>: Modern grey couch and pillows</td>
                    </tr>
                    <tr>
                        <td style="width: 180px;">slug</td>
                        <td><?= trans("data_type"); ?>: Text <br><strong><?= trans("optional"); ?></strong> <small>(<?= trans("slug_exp"); ?>)</small> <br><?= trans("example"); ?>: modern-grey-couch-and-pillows</td>
                    </tr>
                    <tr>
                        <td style="width: 180px;">sku</td>
                        <td><?= trans("data_type"); ?>: Text <br><strong><?= trans("optional"); ?></strong><br><?= trans("example"); ?>: MD-GR-6898</td>
                    </tr>
                    <tr>
                        <td style="width: 180px;">category_id</td>
                        <td><?= trans("data_type"); ?>: Number <br><strong><?= trans("required"); ?></strong><br><?= trans("example"); ?>: 1</td>
                    </tr>
                    <tr>
                        <td style="width: 180px;">price</td>
                        <td><?= trans("data_type"); ?>: Decimal/Number <br><strong><?= trans("required"); ?></strong><br><?= trans("example"); ?>&nbsp;1: 50<br><?= trans("example"); ?>&nbsp;2: 45.90<br><?= trans("example"); ?>&nbsp;3: 3456.25<br></td>
                    </tr>
                    <tr>
                        <td style="width: 180px;">discount_rate</td>
                        <td><?= trans("data_type"); ?>: Number <br><strong><?= trans("optional"); ?></strong><br><?= trans("example"); ?>: 10</td>
                    </tr>
                    <tr>
                        <td style="width: 180px;">vat_rate</td>
                        <td><?= trans("data_type"); ?>: Number <br><strong><?= trans("optional"); ?></strong><br><?= trans("example"); ?>: 8</td>
                    </tr>
                    <tr>
                        <td style="width: 180px;">stock</td>
                        <td><?= trans("data_type"); ?>: Number <br><strong><?= trans("required"); ?></strong><br><?= trans("example"); ?>: 100</td>
                    </tr>
                    <tr>
                        <td style="width: 180px;">description</td>
                        <td><?= trans("data_type"); ?>: Text <br><strong><?= trans("optional"); ?></strong><br><?= trans("example"); ?>: It is a nice and comfortable couch...</td>
                    </tr>
                    <tr>
                        <td style="width: 180px;">image_url</td>
                        <td><?= trans("data_type"); ?>: Text <br><strong><?= trans("optional"); ?></strong><br><?= trans("example"); ?>&nbsp;1:<br>https://upload.wikimedia.org/wikipedia/commons/7/70/Labrador-sea-paamiut.jpg<br><br><?= trans("example"); ?>&nbsp;2:<br>https://upload.wikimedia.org/wikipedia/commons/7/70/Labrador-sea-paamiut.jpg,<br>https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Shaqi_jrvej.jpg/1600px-Shaqi_jrvej.jpg<br>
                            <br><strong class="text-danger font-600">**You can add multiple image links by placing commas between them.</strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var obj_csv = {
        listing_type: "",
        currency: ""
    };

    $(function () {
        $('#drag-and-drop-zone').dmUploader({
            url: '<?php echo base_url(); ?>dashboard_controller/generate_csv_object_post',
            multiple: false,
            extFilter: ["csv"],
            extraData: function (id) {
                return {
                    "<?php echo $this->security->get_csrf_token_name(); ?>": $.cookie(csfr_cookie_name)
                };
            },
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onNewFile: function (id, file) {
                var listing = $("#select_listing_type").val();
                if (listing.length < 1) {
                    $('#select_listing_type').addClass("is-invalid");
                    return false;
                } else {
                    $('#select_listing_type').removeClass("is-invalid");
                }
                var currency = $("#select_currency").val();
                if (currency.length < 1) {
                    $('#select_currency').addClass("is-invalid");
                    return false;
                } else {
                    $('#select_currency').removeClass("is-invalid");
                }
                $("#csv_upload_spinner").show();
                $("#csv_upload_spinner .spinner").show();
                $("#csv_upload_spinner .text-csv-importing").show();
                $("#csv_upload_spinner .text-csv-import-completed").hide();
                $("#csv_uploaded_files").empty();
            },
            onUploadSuccess: function (id, response) {
                //set form values
                obj_csv.currency = $("#select_currency").val();
                obj_csv.listing_type = $("#select_listing_type").val();
                var number_of_items = 0;
                var txt_file_name = "";
                try {
                    var obj = JSON.parse(response);
                    if (obj.result == 1) {
                        number_of_items = obj.number_of_items;
                        txt_file_name = obj.txt_file_name;
                        if (number_of_items > 0) {
                            add_csv_item(number_of_items, txt_file_name, 1);
                        } else {
                            $("#csv_upload_spinner").hide();
                        }
                    } else {
                        $("#csv_upload_spinner").hide();
                    }

                } catch (e) {
                    alert("Invalid CSV file! Make sure there are no double quotes in your content. Double quotes can brake the CSV structure.");
                }
            }
        });
    });

    function add_csv_item(number_of_items, txt_file_name, index) {
        if (index <= number_of_items) {
            var data = {
                "txt_file_name": txt_file_name,
                "index": index,
                "listing_type": obj_csv.listing_type,
                "currency": obj_csv.currency
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "dashboard_controller/import_csv_item_post",
                data: data,
                success: function (response) {
                    try {
                        var obj_sub = JSON.parse(response);
                        if (obj_sub.result == 1) {
                            $("#csv_uploaded_files").prepend('<li class="list-group-item list-group-item-success"><i class="fa fa-check"></i>&nbsp;' + obj_sub.index + '.&nbsp;' + obj_sub.name + '</li>');
                        } else {
                            $("#csv_uploaded_files").prepend('<li class="list-group-item list-group-item-danger"><i class="fa fa-times"></i>&nbsp;' + obj_sub.index + '.</li>');
                        }
                        if (obj_sub.index == number_of_items) {
                            $("#csv_upload_spinner .text-csv-importing").hide();
                            $("#csv_upload_spinner .spinner").hide();
                            $("#csv_upload_spinner .text-csv-import-completed").css('display', 'block');
                        }
                    } catch (e) {
                        alert(response);
                    }
                    index = index + 1;
                    add_csv_item(number_of_items, txt_file_name, index);
                },
                error: function (response) {
                    $("#csv_uploaded_files").prepend('<li class="list-group-item list-group-item-danger"><i class="fa fa-times"></i>&nbsp;' + index + '.</li>');
                    if (index == number_of_items) {
                        $("#csv_upload_spinner .text-csv-importing").hide();
                        $("#csv_upload_spinner .spinner").hide();
                        $("#csv_upload_spinner .text-csv-import-completed").css('display', 'block');
                    }
                    index = index + 1;
                    add_csv_item(number_of_items, txt_file_name, index);
                }
            });
        }
    }

    $(document).on("input", "#input_category_name", function () {
        var val = $(this).val();
        val = val.trim();
        if (val.length > 1) {
            var data = {
                "category_name": val,
                "sys_lang_id": sys_lang_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "ajax_controller/search_categories",
                data: data,
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.result == 1) {
                        document.getElementById("category_search_result").innerHTML = obj.content;
                    }
                }
            });
        } else {
            document.getElementById("category_search_result").innerHTML = "";
        }
    });


    $(document).on("change", "#select_listing_type", function () {
        var val = $(this).val();
        if (val == "ordinary_listing") {
            $("#select_currency").addClass("select-currency-all");
            $("#select_currency").removeClass("select-currency-default");
        } else {
            $("#select_currency").removeClass("select-currency-all");
            $("#select_currency").addClass("select-currency-default");
        }
        $("#select_listing_type").removeClass("is-invalid");
        $("#select_currency").prop('selectedIndex', 0);
    });
    $(document).on("change", "#select_currency", function () {
        $("#select_currency").removeClass("is-invalid");
    });
</script>

<style>
    #select_currency option {
        display: none;
    }

    .select-currency-default .default {
        display: block !important;
    }

    .select-currency-all option {
        display: block !important;
    }
</style>