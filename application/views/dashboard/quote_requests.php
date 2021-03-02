<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= html_escape($title); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('dashboard/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <div class="row table-filter-container">
                        <div class="col-sm-12">
                            <?php echo form_open(current_url(), ['method' => 'GET']); ?>
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
                                <input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?= input_get('q'); ?>">
                            </div>

                            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                <label style="display: block">&nbsp;</label>
                                <button type="submit" class="btn bg-purple btn-filter"><?php echo trans("filter"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th><?php echo trans('quote'); ?></th>
                            <th><?php echo trans('product'); ?></th>
                            <th><?php echo trans('buyer'); ?></th>
                            <th><?php echo trans('status'); ?></th>
                            <th><?php echo trans('sellers_bid'); ?></th>
                            <th><?php echo trans('updated'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($quote_requests as $item): ?>
                            <tr>
                                <td>#<?php echo $item->id; ?></td>
                                <td>
                                    <?php $product = get_product($item->product_id);
                                    if (!empty($product)):?>
                                        <div class="img-table">
                                            <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                <img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                            </a>
                                        </div>
                                        <a href="<?php echo generate_product_url($product); ?>" target="_blank" class="table-product-title">
                                            <?php echo html_escape($item->product_title); ?>
                                        </a><br>
                                        <?php echo trans("quantity") . ": " . $item->product_quantity; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php $user = get_user($item->buyer_id);
                                    if (!empty($user)):?>
                                        <div class="table-orders-user">
                                            <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
                                                <?php echo html_escape($user->username); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item->status == "new_quote_request"): ?>
                                        <label class="label label-success"><?= trans($item->status); ?></label>
                                    <?php elseif ($item->status == "pending_quote"): ?>
                                        <label class="label label-warning"><?= trans($item->status); ?></label>
                                    <?php elseif ($item->status == "pending_payment"): ?>
                                        <label class="label label-info"><?= trans($item->status); ?></label>
                                    <?php elseif ($item->status == "rejected_quote"): ?>
                                        <label class="label label-danger"><?= trans($item->status); ?></label>
                                    <?php elseif ($item->status == "closed"): ?>
                                        <label class="label label-default"><?= trans($item->status); ?></label>
                                    <?php elseif ($item->status == "completed"): ?>
                                        <label class="label label-primary"><?= trans($item->status); ?></label>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item->status != 'new_quote_request' && $item->price_offered != 0): ?>
                                        <div class="table-seller-bid">
                                            <p><strong><?php echo price_formatted($item->price_offered, $item->price_currency); ?></strong></p>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo time_ago($item->updated_at); ?></td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <?php if ($item->status == 'new_quote_request'): ?>
                                                <li>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalSubmitQuote<?php echo $item->id; ?>"><i class="fa fa-plus option-icon"></i><?= trans("submit_a_quote"); ?></a>
                                                </li>
                                            <?php elseif ($item->status == 'pending_quote'): ?>
                                                <li>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalSubmitQuote<?php echo $item->id; ?>"><i class="fa fa-edit option-icon"></i><?= trans("update_quote"); ?></a>
                                                </li>
                                            <?php elseif ($item->status == 'rejected_quote'): ?>
                                                <li>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalSubmitQuote<?php echo $item->id; ?>"><i class="fa fa-refresh option-icon"></i><?= trans("submit_a_new_quote"); ?></a>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_quote_request(<?php echo $item->id; ?>,'<?php echo trans("confirm_quote_request"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>
                <?php if (empty($quote_requests)): ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($quote_requests)): ?>
                    <div class="number-of-entries">
                        <span><?= trans("number_of_entries"); ?>:</span>&nbsp;&nbsp;<strong><?= $num_rows; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="table-pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

<!-- Modal -->
<?php if (!empty($quote_requests)):
    foreach ($quote_requests as $quote_request):
        $quote_product = get_product($quote_request->product_id); ?>
        <div class="modal fade" id="modalSubmitQuote<?php echo $quote_request->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->
                    <?php echo form_open('submit-quote-post'); ?>
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo trans("submit_a_quote"); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" class="form-control" value="<?php echo $quote_request->id; ?>">

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('price'); ?></label>
                            <div class="input-group">
                                <span class="input-group-addon"><?= $this->default_currency->symbol; ?></span>
                                <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                                <input type="text" name="price" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" data-item-id="<?php echo $quote_request->id; ?>" data-product-quantity="<?php echo $quote_request->product_quantity; ?>"
                                       placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="calculated-price">
                                <strong><?php echo trans("unit_price"); ?> (<?= $this->default_currency->symbol; ?>):&nbsp;&nbsp;
                                    <span id="unit_price_<?php echo $quote_request->id; ?>" class="earned-price">
                                        <?php echo number_format(0, 2, '.', ''); ?>
                                    </span>
                                </strong><br>
                                <strong><?php echo trans("you_will_earn"); ?> (<?= $this->default_currency->symbol; ?>):&nbsp;&nbsp;
                                    <span id="earned_price_<?php echo $quote_request->id; ?>" class="earned-price">
                                        <?php $earned_price = $quote_product->price - (($quote_product->price * $this->general_settings->commission_rate) / 100);
                                        $earned_price = number_format($earned_price, 2, '.', '');
                                        echo get_price($earned_price, 'input'); ?>
                                    </span>
                                </strong>&nbsp;&nbsp;&nbsp;
                                <small> (<?php echo trans("commission_rate"); ?>:&nbsp;&nbsp;<?php echo $this->general_settings->commission_rate; ?>%)</small>
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                        <button type="submit" class="btn btn-md btn-success"><?php echo trans("submit"); ?></button>
                    </div>
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>
        </div>
    <?php endforeach;
endif; ?>


<script>
    //calculate product earned value
    var thousands_separator = '<?php echo $this->thousands_separator; ?>';
    var commission_rate = '<?php echo $this->general_settings->commission_rate; ?>';
    $(document).on("input keyup paste change", ".price-input", function () {
        var input_val = $(this).val();
        var data_item_id = $(this).attr('data-item-id');
        var data_product_quantity = $(this).attr('data-product-quantity');
        input_val = input_val.replace(',', '.');
        var price = parseFloat(input_val);
        commission_rate = parseInt(commission_rate);
        //calculate earned price
        if (!Number.isNaN(price)) {
            var earned_price = price - ((price * commission_rate) / 100);
            earned_price = earned_price.toFixed(2);
            if (thousands_separator == ',') {
                earned_price = earned_price.replace('.', ',');
            }
        } else {
            earned_price = '0' + thousands_separator + '00';
        }

        //calculate unit price
        if (!Number.isNaN(price)) {
            var unit_price = price / data_product_quantity;
            unit_price = unit_price.toFixed(2);
            if (thousands_separator == ',') {
                unit_price = unit_price.replace('.', ',');
            }
        } else {
            unit_price = '0' + thousands_separator + '00';
        }

        $("#earned_price_" + data_item_id).html(earned_price);
        $("#unit_price_" + data_item_id).html(unit_price);
    });

    $(document).on("click", ".btn_submit_quote", function () {
        $('.modal-title').text("<?php echo trans("submit_a_quote"); ?>");
    });
    $(document).on("click", ".btn_update_quote", function () {
        $('.modal-title').text("<?php echo trans("update_quote"); ?>");
    });
</script>

<?php if (!empty($this->session->userdata('mds_send_email_data'))): ?>
    <script>
        $(document).ready(function () {
            var data = JSON.parse(<?php echo json_encode($this->session->userdata("mds_send_email_data"));?>);
            if (data) {
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                data["sys_lang_id"] = sys_lang_id;
                $.ajax({
                    type: "POST",
                    url: base_url + "mds-send-email-post",
                    data: data,
                    success: function (response) {
                    }
                });
            }
        });
    </script>
<?php endif;
$this->session->unset_userdata('mds_send_email_data'); ?>

