<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="col-sm-12 col-lg-4 order-summary-container">
    <h2 class="cart-section-title"><?= trans("order_summary"); ?></h2>
    <div class="right">
        <?php if (!empty($plan)): ?>
            <div class="cart-order-details">
                <div class="item">
                    <div class="item-right">
                        <div class="list-item m-t-15">
                            <label><?= trans("membership_plan"); ?>:</label>
                            <strong class="lbl-price"><?= get_membership_plan_name($plan->title_array, $this->selected_lang->id); ?></strong>
                        </div>
                        <div class="list-item">
                            <label><?= trans("price"); ?>:</label>
                            <strong class="lbl-price"><?= price_formatted($plan->price, $this->selected_currency->code, true); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-custom m-t-30">
                <strong><?= trans("subtotal"); ?><span class="float-right"><?= price_formatted($plan->price, $this->selected_currency->code, true); ?></span></strong>
            </div>
            <div class="row-custom">
                <p class="line-seperator"></p>
            </div>
            <div class="row-custom">
                <strong><?= trans("total"); ?><span class="float-right"><?= price_formatted($plan->price, $this->selected_currency->code, true); ?></span></strong>
            </div>
        <?php endif; ?>
    </div>
</div>