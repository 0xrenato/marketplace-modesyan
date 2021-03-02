<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="modalPricing" class="modal fade modal-pricing-table" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= trans("promote_your_product"); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div id="pricing_plan_1" class="price-box">
                            <div class="pricing-name text-center">
                                <h4 class="name"><?php echo trans("daily_plan"); ?></h4>
                            </div>
                            <div class="plan-price text-center">
                                <?php if ($this->payment_settings->free_product_promotion == 1): ?>
                                    <h3><span class="price"><?php echo price_formatted(0, $this->default_currency->code); ?></span><span class="time">/<?= trans("day"); ?></span></h3>
                                <?php else: ?>
                                    <h3><span class="price"><?php echo price_formatted($this->payment_settings->price_per_day, $this->default_currency->code); ?></span><span class="time">/<?= trans("day"); ?></span></h3>
                                <?php endif; ?>
                            </div>
                            <div class="price-features">
                                <p>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                                    </svg>
                                    <?= trans("featured_badge"); ?>
                                </p>
                                <p>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                                    </svg>
                                    <?= trans("appear_on_homepage"); ?>
                                </p>
                                <p>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                                    </svg>
                                    <?= trans("show_first_search_lists"); ?>
                                </p>
                            </div>
                            <div class="text-center">
                                <a href="javascript:void(0)" class="btn btn-md btn-pricing-table" data-pricing-plan="pricing_plan_1"><?= trans("choose_plan"); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="pricing_plan_2" class="price-box">
                            <div class="pricing-name text-center">
                                <h4 class="name"><?php echo trans("monthly_plan"); ?></h4>
                            </div>
                            <div class="plan-price text-center">
                                <?php if ($this->payment_settings->free_product_promotion == 1): ?>
                                    <h3><span class="price"><?php echo price_formatted(0, $this->default_currency->code); ?></span><span class="time">/<?= trans("month"); ?></span></h3>
                                <?php else: ?>
                                    <h3><span class="price"><?php echo price_formatted($this->payment_settings->price_per_month, $this->default_currency->code); ?></span><span class="time">/<?= trans("month"); ?></span></h3>
                                <?php endif; ?>
                            </div>
                            <div class="price-features">
                                <p>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                                    </svg>
                                    <?= trans("featured_badge"); ?>
                                </p>
                                <p>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                                    </svg>
                                    <?= trans("appear_on_homepage"); ?>
                                </p>
                                <p>
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                                    </svg>
                                    <?= trans("show_first_search_lists"); ?>
                                </p>
                            </div>
                            <div class="text-center">
                                <a href="javascript:void(0)" class="btn btn-md btn-pricing-table" data-pricing-plan="pricing_plan_2"><?= trans("choose_plan"); ?></a>
                            </div>
                        </div>
                    </div>

                    <?php $price_per_day = get_price($this->payment_settings->price_per_day, 'separator_format');
                    $price_per_month = get_price($this->payment_settings->price_per_month, 'separator_format'); ?>
                    <input type="hidden" id="price_per_day" value="<?php echo $price_per_day; ?>">
                    <input type="hidden" id="price_per_month" value="<?php echo $price_per_month; ?>">


                    <div class="col-sm-12 container-pricing-plan" id="container_pricing_plan_1">
                        <?php echo form_open('pricing-post', ['onkeypress' => "return event.keyCode != 13;"]); ?>
                        <input type="hidden" class="pricing_product_id" name="product_id">
                        <input type="hidden" name="plan_type" value="daily">
                        <div class="form-group">
                            <label><?php echo trans("day_count"); ?></label>
                            <input type="number" id="pricing_day_count" name="day_count" class="form-control form-input price-input" min="1" value="1" maxlength="5" required>
                        </div>
                        <div class="form-group">
                            <?php if ($this->default_currency->symbol_direction == "left"): ?>
                                <strong class="price-total"><?php echo trans("total_amount"); ?>&nbsp;<?= $this->default_currency->symbol; ?><span class="span-price-total-daily"><?php echo $price_per_day; ?></span>&nbsp;<?= $this->default_currency->code; ?></strong>
                            <?php else: ?>
                                <strong class="price-total"><?php echo trans("total_amount"); ?>&nbsp;<span class="span-price-total-daily"><?php echo $price_per_day; ?></span><?= $this->default_currency->symbol; ?>&nbsp;<?= $this->default_currency->code; ?></strong>
                            <?php endif; ?>
                        </div>
                        <div class="form-group m-0">
                            <button type="submit" class="btn btn-lg btn-success"><?php echo trans("continue_to_checkout"); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>


                    <div class="col-sm-12 container-pricing-plan" id="container_pricing_plan_2">
                        <?php echo form_open('pricing-post', ['onkeypress' => "return event.keyCode != 13;"]); ?>
                        <input type="hidden" class="pricing_product_id" name="product_id">
                        <input type="hidden" name="plan_type" value="monthly">
                        <div class="form-group">
                            <label><?php echo trans("month_count"); ?></label>
                            <input type="number" id="pricing_month_count" name="month_count" class="form-control form-input price-input" min="1" value="1" required>
                        </div>
                        <div class="form-group">
                            <?php if ($this->default_currency->symbol_direction == "left"): ?>
                                <strong class="price-total"><?php echo trans("total_amount"); ?>&nbsp;<?= $this->default_currency->symbol; ?><span class="span-price-total-monthly"><?php echo $price_per_month; ?></span>&nbsp;<?= $this->default_currency->code; ?></strong>
                            <?php else: ?>
                                <strong class="price-total"><?php echo trans("total_amount"); ?>&nbsp;<span class="span-price-total-monthly"><?php echo $price_per_month; ?></span><?= $this->default_currency->symbol; ?>&nbsp;<?= $this->default_currency->code; ?></strong>
                            <?php endif; ?>
                        </div>
                        <div class="form-group m-0">
                            <button type="submit" class="btn btn-lg btn-success"><?php echo trans("continue_to_checkout"); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Wrapper End-->
<script src="<?php echo base_url(); ?>assets/vendor/jquery-number/jquery.number.min.js"></script>

<script>
    $(document).on('click', '.btn-pricing-table', function () {
        var pricing_plan = $(this).attr("data-pricing-plan");
        $('.price-box').removeClass('selected-plan');
        $('#' + pricing_plan).addClass('selected-plan');
        $('.container-pricing-plan').hide();
        $('#container_' + pricing_plan).show();
    });

    $("#pricing_day_count").on("input keypress paste change", function () {
        var day_count = $("#pricing_day_count").val();
        if (day_count > 1440) {
            day_count = 1440;
            $("#pricing_day_count").val('1440');
        }
        var price_per_day = '<?php echo get_price($this->payment_settings->price_per_day, 'decimal'); ?>';
        var calculated = day_count * price_per_day;
        if (!Number.isInteger(calculated)) {
            calculated = calculated.toFixed(2);
        }
        <?php if($this->thousands_separator == ','): ?>
        var calculated_formatted = $.number(calculated, 2, ',', '.');
        <?php else: ?>
        var calculated_formatted = $.number(calculated, 2, '.', ',');
        <?php endif; ?>
        $(".span-price-total-daily").text(calculated_formatted);
    });

    $("#pricing_month_count").on("input keypress paste change", function () {
        var month_count = $("#pricing_month_count").val();
        if (month_count > 48) {
            month_count = 48;
            $("#pricing_month_count").val('48');
        }
        var price_per_month = '<?php echo get_price($this->payment_settings->price_per_month, 'decimal'); ?>';
        var calculated = month_count * price_per_month;
        if (!Number.isInteger(calculated)) {
            calculated = calculated.toFixed(2);
        }
        <?php if($this->thousands_separator == ','): ?>
        var calculated_formatted = $.number(calculated, 2, ',', '.');
        <?php else: ?>
        var calculated_formatted = $.number(calculated, 2, '.', ',');
        <?php endif; ?>
        $(".span-price-total-monthly").text(calculated_formatted);
    });
</script>