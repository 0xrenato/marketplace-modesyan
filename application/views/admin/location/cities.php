<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo $title; ?></h3>
        </div>
        <div class="right">
            <a href="<?php echo admin_url(); ?>add-city" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo trans('add_city'); ?>
            </a>
        </div>
    </div>

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
                        <div class="row table-filter-container">
                            <div class="col-sm-12">
                                <?php echo form_open(admin_url() . "cities", ['method' => 'GET']); ?>

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
                                    <label><?php echo trans('country'); ?></label>
                                    <select name="country" class="form-control" onchange="get_states_by_country($(this).val());">
                                        <option value=""><?php echo trans("all"); ?></option>
                                        <?php
                                        foreach ($countries as $item): ?>
                                            <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('country', true) == $item->id) ? 'selected' : ''; ?>>
                                                <?php echo html_escape($item->name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="item-table-filter">
                                    <label><?php echo trans('state'); ?></label>
                                    <select name="state" id="select_states" class="form-control">
                                        <option value=""><?php echo trans("all"); ?></option>
                                        <?php
                                        $country_id = $this->input->get('country', true);
                                        if (!empty($country_id)) {
                                            $states = $this->location_model->get_states_by_country($country_id);
                                        }
                                        foreach ($states as $item): ?>
                                            <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('state', true) == $item->id) ? 'selected' : ''; ?>>
                                                <?php echo html_escape($item->name); ?>
                                            </option>
                                        <?php endforeach; ?>
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
                        <thead>
                        <tr role="row">
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('name'); ?></th>
                            <th><?php echo trans('country'); ?></th>
                            <th><?php echo trans('state'); ?></th>
                            <th><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($cities as $item): ?>
                            <tr>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td><?php echo html_escape($item->name); ?></td>
                                <td><?php echo html_escape($item->country_name); ?></td>
                                <td><?php echo html_escape($item->state_name); ?></td>
                                <td width="20%">
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="<?php echo admin_url(); ?>update-city/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_city_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($cities)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">

                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>