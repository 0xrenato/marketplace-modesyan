<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="form-box">
    <div class="form-box-head">
        <h4 class="title">
            <?php echo trans('license_keys'); ?><br>
            <small><?php echo trans("license_keys_system_exp"); ?></small>
        </h4>
    </div>
    <div class="form-box-body">
        <button type="button" class="btn btn-md btn-info" data-toggle="modal" data-target="#addLicenseKeysModal"><?php echo trans("add_license_keys"); ?></button>
        <button type="button" class="btn btn-md btn-secondary" data-toggle="modal" data-target="#viewLicenseKeysModal"><?php echo trans("view_license_keys"); ?></button>
    </div>
</div>

<div class="modal fade" id="addLicenseKeysModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo trans("add_license_keys"); ?></h5>
                <p class="modal-title-exp"><?php echo trans("add_license_keys_exp"); ?></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div id="result-add-license-keys"></div>
                <div class="form-group">
                    <textarea name="license_keys" id="textarea_license_keys" class="form-control form-textarea" placeholder="<?php echo trans("license_keys"); ?>"></textarea>
                </div>
                <div class="form-group m-0">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <label class="control-label-small"><?php echo trans('allow_duplicate_license_keys'); ?></label>
                        </div>
                        <div class="col-sm-3 col-xs-12 col-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="allow_duplicate_license_keys" value="1" id="allow_duplicate_1" class="custom-control-input">
                                <label for="allow_duplicate_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 col-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="allow_duplicate_license_keys" value="0" id="allow_duplicate_2" class="custom-control-input" checked>
                                <label for="allow_duplicate_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="loader-license-keys">
                        <div class="spinner">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-success btn-add-license-keys" onclick="add_license_keys('<?php echo $product->id; ?>');"><?php echo trans("add_license_keys"); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewLicenseKeysModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo trans("license_keys"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="license_key_list_product_id" value="<?php echo $product->id; ?>">
                <div id="response_license_key" class="modal-license-key-list">
                    <?php $this->load->view("dashboard/product/license/_license_keys_list", ['product' => $product, 'license_keys' => $license_keys]); ?>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
