<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-10">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('edit_shipping_zone'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?php echo generate_dash_url("shipping_settings"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= trans('shipping_zones'); ?>
                    </a>
                </div>
            </div>

            <div class="box-body">
                <?php $this->load->view('dashboard/includes/_messages'); ?>

                <?php echo form_open("edit-shipping-zone-post"); ?>
                <input type="hidden" name="zone_id" value="<?= $shipping_zone->id; ?>">
                <div class="form-group">
                    <label class="control-label"><?php echo trans("zone_name"); ?></label>
                    <?php foreach ($this->languages as $language): ?>
                        <input type="text" name="zone_name_lang_<?= $language->id; ?>" class="form-control form-input m-b-5" value="<?= @parse_serialized_name_array($shipping_zone->name_array, $language->id); ?>" placeholder="<?= $language->name; ?>" maxlength="255" required>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans("regions"); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="selected_regions_container" class="selected-regions">
                                <?php $locations = get_shipping_locations_by_zone($shipping_zone->id);
                                if (!empty($locations)):
                                    $i = 0;
                                    $array_regions = array();
                                    foreach ($locations as $location):
                                        if (!empty($location->country_name) && !empty($location->state_name)):
                                            array_push($array_regions, "state-" . $location->state_id); ?>
                                            <div class="region"><?= $location->country_name . "/" . $location->state_name; ?><a href="javascript:void(0)" onclick="delete_shipping_location('<?= $location->id; ?>');"><i class="fa fa-times"></i></a><input type="hidden" value="<?= $location->state_id; ?>" name="state[]"></div>
                                        <?php elseif (!empty($location->country_name) && empty($location->state_name)):
                                            array_push($array_regions, "country-" . $location->country_id); ?>
                                            <div class="region"><?= $location->country_name; ?><a href="javascript:void(0)"><i class="fa fa-times" onclick="delete_shipping_location('<?= $location->id; ?>');"></i></a><input type="hidden" value="<?= $location->country_id; ?>" name="country[]"></div>
                                        <?php else:
                                            array_push($array_regions, "continent-" . $location->continent_code); ?>
                                            <div class="region"><?= get_continent_name_by_key($location->continent_code); ?><a href="javascript:void(0)" onclick="delete_shipping_location('<?= $location->id; ?>');"><i class="fa fa-times"></i></a><input type="hidden" value="<?= $location->continent_code; ?>" name="continent[]"></div>
                                        <?php endif;
                                        $i++;
                                    endforeach;
                                endif; ?>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-5">
                                <select id="select_continents" class="select2 form-control" data-placeholder="<?= trans("continent"); ?>">
                                    <option></option>
                                    <?php if (!empty($continents)):
                                        foreach ($continents as $key => $continent):?>
                                            <option value="<?= $key; ?>"><?= $continent; ?></option>
                                        <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div id="form_group_countries" class="form-group m-b-5" style="display: none;">
                                <select id="select_countries" class="select2 form-control" data-placeholder="<?= trans("country"); ?>">
                                    <option></option>
                                </select>
                            </div>
                            <div id="form_group_states" class="form-group m-b-5" style="display: none;">
                                <select id="select_states" class="select2 form-control" data-placeholder="<?= trans("state"); ?>">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div id="btn_select_region_container" class="col-sm-12" style="display: none;">
                            <a href="javascript:void(0)" id="btn_select_region" class="btn btn-sm btn-info"><i class="fa fa-check"></i>&nbsp;<?php echo trans("select_region") ?></a>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label m-b-10"><?php echo trans("shipping_methods"); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="selected_shipping_methods"></div>
                        </div>
                    </div>
                    <?php $methods = get_shipping_payment_methods_by_zone($shipping_zone->id);
                    if (!empty($methods)):
                        foreach ($methods as $method):
                            $this->load->view('dashboard/shipping/_response_shipping_method_edit', ['method' => $method]);
                        endforeach;
                    endif; ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="javascript:void(0)" id="btn_add_shipping_method" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalShippingMethod"><i class="fa fa-plus"></i>&nbsp;<?php echo trans("add_shipping_method") ?></a>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" name="submit" value="update" class="btn btn-md btn-success"><?php echo trans("save_changes") ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div id="modalShippingMethod" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h4 class="modal-title"><?= trans("shipping_methods"); ?></h4>
            </div>
            <div class="modal-body">
                <select id="select_shipping_methods" class="form-control custom-select">
                    <?php $options = get_shipping_methods();
                    if (!empty($options)):
                        foreach ($options as $option):?>
                            <option value="<?= $option; ?>"><?= trans($option); ?></option>
                        <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_select_shipping_method" class="btn btn-success" data-dismiss="modal"><?= trans("add_shipping_method"); ?></button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('dashboard/shipping/_js_shipping'); ?>

<script>
    <?php if (!empty($array_regions)):
    foreach ($array_regions as $array_region):?>
    array_regions.push("<?= $array_region; ?>");
    <?php endforeach;
    endif; ?>
</script>