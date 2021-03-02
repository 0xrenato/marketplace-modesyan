<?php defined('BASEPATH') or exit('No direct script access allowed');
if (!empty($payment_gateway) && $payment_gateway->name_key == "iyzico"):
    require_once(APPPATH . 'third_party/iyzipay/vendor/autoload.php');
    require_once(APPPATH . 'third_party/iyzipay/vendor/iyzico/iyzipay-php/IyzipayBootstrap.php');
    IyzipayBootstrap::init();
    $options = new \Iyzipay\Options();
    $options->setApiKey($payment_gateway->public_key);
    $options->setSecretKey($payment_gateway->secret_key);
    if ($payment_gateway->environment == "sandbox") {
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");
    } else {
        $options->setBaseUrl("https://api.iyzipay.com");
    }

    $conversation_id = generate_short_unique_id();
    $customer = get_cart_customer_data();

    $ci =& get_instance();
    if ($mds_payment_type == 'membership') {
        $item_basket_name = get_membership_plan_name($plan->title_array, $this->selected_lang->id);
        $item_basket_category = trans("membership_plan_payment");
        $item_basket_price = $total_amount;
        $callback_url = base_url() . "iyzico-payment-post?payment_type=membership&lang=" . $this->selected_lang->short_form . "&conversation_id=" . $conversation_id;
    } elseif ($mds_payment_type == 'promote') {
        $item_basket_name = $promoted_plan->purchased_plan;
        $item_basket_category = trans("promote_plan");
        $item_basket_price = $total_amount;
        $callback_url = base_url() . "iyzico-payment-post?payment_type=promote&lang=" . $this->selected_lang->short_form . "&conversation_id=" . $conversation_id;
    } else {
        $product_ids = "";
        $i = 0;
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                if ($i != 0) {
                    $product_ids .= ", ";
                }
                $product_ids .= $cart_item->product_id;
                $i++;
            }
        }
        $item_basket_name = trans("product") . " (" . $product_ids . ")";
        $item_basket_category = trans("sale");
        $item_basket_price = $total_amount;
        $callback_url = base_url() . "iyzico-payment-post?payment_type=sale&lang=" . $this->selected_lang->short_form . "&conversation_id=" . $conversation_id;
        $country = "Turkey";
    }

    $buyer_id = "guest_" . uniqid();
    if ($this->auth_check) {
        $buyer_id = $this->auth_user->id;
    }
    $ip = $this->input->ip_address();
    if (empty($ip)) {
        $ip = "85.34.78.112";
    }
    # create request class
    $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
    $request->setLocale(\Iyzipay\Model\Locale::TR);
    $request->setConversationId($conversation_id);
    $request->setPrice($item_basket_price);
    $request->setPaidPrice($item_basket_price);
    $request->setCurrency(\Iyzipay\Model\Currency::TL);
    $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
    $request->setCallbackUrl($callback_url);
    $request->setEnabledInstallments(array(2, 3, 6, 9));

    $buyer = new \Iyzipay\Model\Buyer();
    $buyer->setId($customer->id);
    $buyer->setName($customer->first_name);
    $buyer->setSurname($customer->last_name);
    $buyer->setGsmNumber($customer->phone_number);
    $buyer->setEmail($customer->email);
    $buyer->setIdentityNumber("11111111111");
    $buyer->setRegistrationAddress("not_set");
    $buyer->setIp($ip);
    $buyer->setCity("not_set");
    $buyer->setCountry("not_set");
    $buyer->setZipCode("not_set");
    $request->setBuyer($buyer);

    $shippingAddress = new \Iyzipay\Model\Address();
    $shippingAddress->setContactName("not_set");
    $shippingAddress->setCity("not_set");
    $shippingAddress->setCountry("not_set");
    $shippingAddress->setAddress("not_set");
    $shippingAddress->setZipCode("");
    $request->setShippingAddress($shippingAddress);

    $billingAddress = new \Iyzipay\Model\Address();
    $billingAddress->setContactName("not_set");
    $billingAddress->setCity("not_set");
    $billingAddress->setCountry("not_set");
    $billingAddress->setAddress("not_set");
    $billingAddress->setZipCode("");
    $request->setBillingAddress($billingAddress);

    $basketItems = array();
    $BasketItem = new \Iyzipay\Model\BasketItem();
    $BasketItem->setId("0");
    $BasketItem->setName($item_basket_name);
    $BasketItem->setCategory1($item_basket_category);
    $BasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
    $BasketItem->setPrice($item_basket_price);
    $basketItems[0] = $BasketItem;

    $request->setBasketItems($basketItems);
    # make request
    $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);

    if ($checkoutFormInitialize->getStatus() == "failure") {
        $this->session->set_flashdata('error', $checkoutFormInitialize->getErrorMessage());
    } else {
        echo $checkoutFormInitialize->getcheckoutFormContent();
    } ?>

    <div class="row">
        <div class="col-12">
            <!-- include message block -->
            <?php $this->load->view('product/_messages'); ?>
        </div>
    </div>

    <div id="iyzipay-checkout-form" class="responsive"></div>
<?php endif; ?>
<?php reset_flash_data(); ?>