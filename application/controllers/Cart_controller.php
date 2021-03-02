<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart_controller extends Home_Core_Controller
{
    /*
     * Payment Types
     *
     * 1. sale: Product purchases
     * 2. membership: Membership purchases
     * 3. promote: Promote purchases
     *
     */

    public function __construct()
    {
        parent::__construct();
        $this->session_cart_items = $this->cart_model->get_sess_cart_items();
        $this->cart_model->calculate_cart_total($this->session_cart_items);
    }

    /**
     * Cart
     */
    public function cart()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;

        $data['cart_items'] = $this->session_cart_items;
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/cart', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Add to Cart
     */
    public function add_to_cart()
    {
        $product_id = $this->input->post('product_id', true);
        $is_ajax = $this->input->post('is_ajax', true);
        $product = $this->product_model->get_active_product($product_id);
        if (!empty($product)) {
            if ($product->status != 1) {
                $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
            } else {
                $this->cart_model->add_to_cart($product);
                if (empty($is_ajax)) {
                    redirect(generate_url("cart"));
                }
            }
        }
        if (empty($is_ajax)) {
            redirect($this->agent->referrer());
        }
    }

    /**
     * Add to Cart qQuote
     */
    public function add_to_cart_quote()
    {
        $quote_request_id = $this->input->post('id', true);
        if (!empty($this->cart_model->add_to_cart_quote($quote_request_id))) {
            redirect(generate_url("cart"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Remove from Cart
     */
    public function remove_from_cart()
    {
        $cart_item_id = $this->input->post('cart_item_id', true);
        $this->cart_model->remove_from_cart($cart_item_id);
    }

    /**
     * Update Cart Product Quantity
     */
    public function update_cart_product_quantity()
    {
        $product_id = $this->input->post('product_id', true);
        $cart_item_id = $this->input->post('cart_item_id', true);
        $quantity = $this->input->post('quantity', true);
        $this->cart_model->update_cart_product_quantity($product_id, $cart_item_id, $quantity);
    }

    /**
     * Shipping
     */
    public function shipping()
    {
        $this->cart_model->validate_cart();
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['cart_items'] = $this->cart_model->get_sess_cart_items();
        $data['mds_payment_type'] = 'sale';

        if (empty($data['cart_items'])) {
            redirect(generate_url("cart"));
        }
        //check shipping status
        if ($this->product_settings->marketplace_shipping != 1) {
            redirect(generate_url("cart"));
            exit();
        }
        //check guest checkout
        if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1) {
            redirect(generate_url("cart"));
            exit();
        }
        //check auth for digital products
        if (!$this->auth_check && $this->cart_model->check_cart_has_digital_product() == true) {
            $this->session->set_flashdata('error', trans("msg_digital_product_register_error"));
            redirect(generate_url("register"));
            exit();
        }
        //check physical products
        if ($this->cart_model->check_cart_has_physical_product() == false) {
            redirect(generate_url("cart"));
            exit();
        }
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        if ($data['cart_total']->is_stock_available != 1) {
            redirect(generate_url("cart"));
            exit();
        }

        $state_id = 0;
        if ($this->auth_check) {
            $data["shipping_addresses"] = $this->profile_model->get_shipping_addresses($this->auth_user->id);
            $first_id = 0;
            if (!empty($data["shipping_addresses"]) && !empty($data["shipping_addresses"][0])) {
                $first_id = $data["shipping_addresses"][0]->id;
            }
            $data['selected_shipping_address_id'] = $first_id;
            $data['selected_billing_address_id'] = $first_id;
            $data['selected_same_address_for_billing'] = 1;
            if (!empty($data["shipping_addresses"][0]->state_id)) {
                $state_id = $data["shipping_addresses"][0]->state_id;
            }
            if (!empty($this->session->userdata('mds_cart_shipping'))) {
                $selected_shipping = $this->session->userdata('mds_cart_shipping');
                if (!empty($selected_shipping->user_id) && $selected_shipping->user_id == $this->auth_user->id) {
                    if (!empty($selected_shipping->shipping_address_id)) {
                        $data['selected_shipping_address_id'] = $selected_shipping->shipping_address_id;
                    }
                    if (!empty($selected_shipping->billing_address_id)) {
                        $data['selected_billing_address_id'] = $selected_shipping->billing_address_id;
                    }
                    if (!empty($selected_shipping->use_same_address_for_billing)) {
                        $data['selected_same_address_for_billing'] = $selected_shipping->use_same_address_for_billing;
                    }
                    $selected_address = $this->profile_model->get_shipping_address_by_id($data['selected_shipping_address_id']);
                    if (!empty($selected_address)) {
                        $state_id = $selected_address->state_id;
                    }
                }
            }
        } else {
            $mds_cart_shipping = get_sess_data('mds_cart_shipping');
            if (!empty($mds_cart_shipping)) {
                if (!empty($mds_cart_shipping->guest_shipping_address) && item_count($mds_cart_shipping->guest_shipping_address) > 0) {
                    if (!empty($mds_cart_shipping->guest_shipping_address['state_id'])) {
                        $state_id = $mds_cart_shipping->guest_shipping_address['state_id'];
                    }
                }
            }
        }
        if (!empty($state_id)) {
            $data["shipping_methods"] = $this->shipping_model->get_seller_shipping_methods_array($data['cart_items'], $state_id);
        }
        $data['selected_shipping_method_ids'] = array();
        if (!empty($this->session->userdata('mds_selected_shipping_method_ids'))) {
            $data['selected_shipping_method_ids'] = $this->session->userdata('mds_selected_shipping_method_ids');
        }

        //cart seller ids
        $data['cart_seller_ids'] = null;
        if (!empty($this->session->userdata('mds_array_cart_seller_ids'))) {
            $data['cart_seller_ids'] = $this->session->userdata('mds_array_cart_seller_ids');
        }

        $this->load->view('partials/_header', $data);
        if ($this->auth_check) {
            $this->load->view('cart/shipping_information', $data);
        } else {
            $this->load->view('cart/shipping_information_guest', $data);
        }
        $this->load->view('partials/_footer');
    }

    /**
     * Shipping Post
     */
    public function shipping_post()
    {
        $cart_shipping = new stdClass();
        $cart_shipping->total_cost = 0;
        $cart_shipping->use_same_address_for_billing = $this->input->post('use_same_address_for_billing', true);
        $cart_shipping->user_id = $this->auth_user->id;
        if ($this->auth_check) {
            $cart_shipping->shipping_address_id = $this->input->post('shipping_address_id', true);
            $cart_shipping->billing_address_id = $this->input->post('billing_address_id', true);
            $cart_shipping->guest_shipping_address = null;
            $cart_shipping->guest_billing_address = null;
            if ($cart_shipping->use_same_address_for_billing == 1) {
                $cart_shipping->billing_address_id = $cart_shipping->shipping_address_id;
            }
            $cart_shipping->is_guest = false;
        } else {
            $cart_shipping->guest_shipping_address = $this->cart_model->set_guest_shipping_address();
            $cart_shipping->guest_billing_address = $this->cart_model->set_guest_billing_address();
            if ($cart_shipping->use_same_address_for_billing == 1) {
                $cart_shipping->guest_billing_address = $cart_shipping->guest_shipping_address;
            }
            $cart_shipping->is_guest = true;
        }

        $result = $this->shipping_model->calculate_cart_shipping_total_cost();
        if (!empty($result) && $result['is_valid'] != 1) {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
            exit();
        }
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        if (!empty($data['cart_total']) && !empty($result['total_cost'])) {
            $data['cart_total']->shipping_cost = $result['total_cost'];
            $cart_shipping->total_cost = $result['total_cost'];
            $this->session->set_userdata('mds_shopping_cart_total', $data['cart_total']);
        }
        $this->session->set_userdata('mds_cart_shipping', $cart_shipping);
        redirect(generate_url("cart", "payment_method"));
        exit();
    }

    /**
     * Payment Method
     */
    public function payment_method()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;

        $payment_type = input_get('payment_type');
        if ($payment_type != "membership" && $payment_type != "promote") {
            $payment_type = "sale";
        }

        if ($payment_type == "sale") {
            $this->cart_model->validate_cart();
            //sale payment
            $data['cart_items'] = $this->cart_model->get_sess_cart_items();
            $data['mds_payment_type'] = "sale";
            if ($data['cart_items'] == null) {
                redirect(generate_url("cart"));
            }
            //check auth for digital products
            if (!$this->auth_check && $this->cart_model->check_cart_has_digital_product() == true) {
                $this->session->set_flashdata('error', trans("msg_digital_product_register_error"));
                redirect(generate_url("register"));
                exit();
            }
            $data['cart_total'] = $this->cart_model->get_sess_cart_total();
            $user_id = null;
            if ($this->auth_check) {
                $user_id = $this->auth_user->id;
            }

            $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
            $data['cart_has_digital_product'] = $this->cart_model->check_cart_has_digital_product();
            $this->cart_model->unset_sess_cart_payment_method();
            $data['show_shipping_cost'] = 1;
        } elseif ($payment_type == 'membership') {
            //membership payment
            if ($this->general_settings->membership_plans_system != 1) {
                redirect(lang_base_url());
                exit();
            }
            $data['mds_payment_type'] = 'membership';
            $plan_id = $this->session->userdata('modesy_selected_membership_plan_id');
            if (empty($plan_id)) {
                redirect(lang_base_url());
                exit();
            }
            $data['plan'] = $this->membership_model->get_plan($plan_id);
            if (empty($data['plan'])) {
                redirect(lang_base_url());
                exit();
            }
        } elseif ($payment_type == 'promote') {
            //promote payment
            if ($this->general_settings->promoted_products != 1) {
                redirect(lang_base_url());
            }
            $data['mds_payment_type'] = 'promote';
            $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
            if (empty($data['promoted_plan'])) {
                redirect(lang_base_url());
            }
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/payment_method', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Payment Method Post
     */
    public function payment_method_post()
    {
        $this->cart_model->set_sess_cart_payment_method();

        $mds_payment_type = $this->input->post('mds_payment_type', true);
        $redirect = lang_base_url();
        if ($mds_payment_type == "sale") {
            $redirect = generate_url("cart", "payment");
        } elseif ($mds_payment_type == 'membership') {
            $transaction_number = 'bank-' . generate_transaction_number();
            $this->session->set_userdata('mds_membership_bank_transaction_number', $transaction_number);
            $redirect = generate_url("cart", "payment") . "?payment_type=membership";
        } elseif ($mds_payment_type == 'promote') {
            $transaction_number = 'bank-' . generate_transaction_number();
            $this->session->set_userdata('mds_promote_bank_transaction_number', $transaction_number);
            $redirect = generate_url("cart", "payment") . "?payment_type=promote";
        }
        redirect($redirect);
    }

    /**
     * Payment
     */
    public function payment()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['mds_payment_type'] = "sale";

        //check guest checkout
        if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1) {
            redirect(generate_url("cart"));
            exit();
        }

        //check is set cart payment method
        $data['cart_payment_method'] = $this->cart_model->get_sess_cart_payment_method();
        if (empty($data['cart_payment_method'])) {
            redirect(generate_url("cart", "payment_method"));
        }

        $payment_type = input_get('payment_type');
        if ($payment_type != "membership" && $payment_type != "promote") {
            $payment_type = "sale";
        }

        if ($payment_type == "sale") {
            $this->cart_model->validate_cart();
            //sale payment
            $data['cart_items'] = $this->cart_model->get_sess_cart_items();
            if ($data['cart_items'] == null) {
                redirect(generate_url("cart"));
            }
            $data['cart_total'] = $this->cart_model->get_sess_cart_total();
            $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();

            $obj_amount = $this->cart_model->convert_currency_by_payment_gateway($data['cart_total']->total, "sale");
            $data['total_amount'] = $obj_amount->total;
            $data['currency'] = $obj_amount->currency;
            if (filter_var($data['total_amount'], FILTER_VALIDATE_INT) === false) {
                $data['total_amount'] = number_format($data['total_amount'], 2, ".", "");
            }
            //set payment session
            if (!empty($data['cart_items'])) {
                $this->session->set_userdata('mds_shopping_cart_final', $data['cart_items']);
            }
            if (!empty($data['cart_total'])) {
                $this->session->set_userdata('mds_shopping_cart_total_final', $data['cart_total']);
            }
            $data['show_shipping_cost'] = 1;
        } elseif ($payment_type == 'membership') {
            //membership payment
            if ($this->general_settings->membership_plans_system != 1) {
                redirect(lang_base_url());
                exit();
            }
            $data['mds_payment_type'] = 'membership';
            $plan_id = $this->session->userdata('modesy_selected_membership_plan_id');
            if (empty($plan_id)) {
                redirect(lang_base_url());
                exit();
            }
            $data['plan'] = $this->membership_model->get_plan($plan_id);
            if (empty($data['plan'])) {
                redirect(lang_base_url());
                exit();
            }
            //total amount
            $price = $data['plan']->price;
            if ($this->payment_settings->currency_converter != 1) {
                $price = get_price($price, 'decimal');
            }
            $obj_amount = $this->cart_model->convert_currency_by_payment_gateway($price, "membership");
            $data['total_amount'] = $obj_amount->total;
            $data['currency'] = $obj_amount->currency;
            $data['transaction_number'] = $this->session->userdata('mds_membership_bank_transaction_number');
            $data['cart_total'] = null;
        } elseif ($payment_type == 'promote') {
            //promote payment
            if ($this->general_settings->promoted_products != 1) {
                redirect(lang_base_url());
            }
            $data['mds_payment_type'] = 'promote';
            $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
            if (empty($data['promoted_plan'])) {
                redirect(lang_base_url());
            }
            //total amount
            $obj_amount = $this->cart_model->convert_currency_by_payment_gateway($data['promoted_plan']->total_amount, "promote");
            $data['total_amount'] = $obj_amount->total;
            $data['currency'] = $obj_amount->currency;
            $data['transaction_number'] = $this->session->userdata('mds_promote_bank_transaction_number');
            $data['cart_total'] = null;
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/payment', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Payment with Paypal
     */
    public function paypal_payment_post()
    {
        $payment_id = $this->input->post('payment_id', true);
        $this->load->library('paypal');

        //validate the order
        if ($this->paypal->get_order($payment_id)) {
            $data_transaction = array(
                'payment_method' => "PayPal",
                'payment_id' => $payment_id,
                'currency' => $this->input->post('currency', true),
                'payment_amount' => $this->input->post('payment_amount', true),
                'payment_status' => $this->input->post('payment_status', true),
            );
            $mds_payment_type = $this->input->post('mds_payment_type', true);

            //add order
            $response = $this->execute_payment($data_transaction, $mds_payment_type, lang_base_url());
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                echo json_encode([
                    'result' => 1,
                    'redirect_url' => $response->redirect_url
                ]);
            } else {
                $this->session->set_flashdata('error', $response->message);
                echo json_encode([
                    'result' => 0
                ]);
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            echo json_encode([
                'result' => 0
            ]);
        }
    }

    /**
     * Payment with Stripe
     */
    public function stripe_payment_post()
    {
        $stripe = get_payment_gateway('stripe');
        if (empty($stripe)) {
            $this->session->set_flashdata('error', "Payment method not found!");
            echo json_encode([
                'result' => 0
            ]);
            exit();
        }
        $payment_session = $this->session->userdata('mds_payment_cart_data');
        if (empty($payment_session)) {
            $this->session->set_flashdata('error', trans("invalid_attempt"));
            echo json_encode([
                'result' => 0
            ]);
            exit();
        }

        $paymentObject = $this->input->post('paymentObject', true);
        if (!empty($paymentObject)) {
            $paymentObject = json_decode($paymentObject);
        }
        $clientSecret = $this->session->userdata('mds_stripe_client_secret');

        if (!empty($paymentObject) && $paymentObject->client_secret == $clientSecret) {
            $data_transaction = array(
                'payment_method' => $stripe->name,
                'payment_id' => $paymentObject->id,
                'currency' => strtoupper($paymentObject->currency),
                'payment_amount' => get_price($paymentObject->amount, 'decimal'),
                'payment_status' => "Succeeded"
            );
            //add order
            $response = $this->execute_payment($data_transaction, $payment_session->payment_type, lang_base_url());
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                echo json_encode([
                    'result' => 1,
                    'redirect_url' => $response->redirect_url
                ]);
            } else {
                $this->session->set_flashdata('error', $response->message);
                echo json_encode([
                    'result' => 0
                ]);
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            echo json_encode([
                'result' => 0
            ]);
        }
        @$this->session->unset_userdata('mds_stripe_client_secret');
    }

    /**
     * Payment with PayStack
     */
    public function paystack_payment_post()
    {
        $this->load->library('paystack');

        $data_transaction = array(
            'payment_method' => "PayStack",
            'payment_id' => $this->input->post('payment_id', true),
            'currency' => $this->input->post('currency', true),
            'payment_amount' => get_price($this->input->post('payment_amount', true), 'decimal'),
            'payment_status' => $this->input->post('payment_status', true),
        );

        if (empty($this->paystack->verify_transaction($data_transaction['payment_id']))) {
            $this->session->set_flashdata('error', 'Invalid transaction code!');
            echo json_encode([
                'result' => 0
            ]);
        } else {
            $mds_payment_type = $this->input->post('mds_payment_type', true);

            //add order
            $response = $this->execute_payment($data_transaction, $mds_payment_type, lang_base_url());
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                echo json_encode([
                    'result' => 1,
                    'redirect_url' => $response->redirect_url
                ]);
            } else {
                $this->session->set_flashdata('error', $response->message);
                echo json_encode([
                    'result' => 0
                ]);
            }
        }
    }

    /**
     * Payment with Razorpay
     */
    public function razorpay_payment_post()
    {
        $this->load->library('razorpay');

        $data_transaction = array(
            'payment_method' => "Razorpay",
            'payment_id' => $this->input->post('payment_id', true),
            'razorpay_order_id' => $this->input->post('razorpay_order_id', true),
            'razorpay_signature' => $this->input->post('razorpay_signature', true),
            'currency' => $this->input->post('currency', true),
            'payment_amount' => get_price($this->input->post('payment_amount', true), 'decimal'),
            'payment_status' => 'Succeeded',
        );

        if (empty($this->razorpay->verify_payment_signature($data_transaction))) {
            $this->session->set_flashdata('error', 'Invalid signature passed!');
            echo json_encode([
                'result' => 0
            ]);
        } else {
            $mds_payment_type = $this->input->post('mds_payment_type', true);
            //add order
            $response = $this->execute_payment($data_transaction, $mds_payment_type, lang_base_url());
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                echo json_encode([
                    'result' => 1,
                    'redirect_url' => $response->redirect_url
                ]);
            } else {
                $this->session->set_flashdata('error', $response->message);
                echo json_encode([
                    'result' => 0
                ]);
            }
        }
    }

    /**
     * Payment with Flutterwave
     */
    public function flutterwave_payment_post()
    {
        $flutterwave = get_payment_gateway('flutterwave');
        if (empty($flutterwave)) {
            $this->session->set_flashdata('error', "Payment method not found!");
            redirect($response->redirect_url);
            exit();
        }
        $payment_session = $this->session->userdata('mds_payment_cart_data');
        if (empty($payment_session)) {
            $this->session->set_flashdata('error', trans("invalid_attempt"));
            redirect($response->redirect_url);
            exit();
        }
        $transaction_id = input_get('transaction_id');
        $tx_ref = input_get('tx_ref');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/" . $transaction_id . "/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $flutterwave->secret_key
            ),
        ));
        $curlResponse = curl_exec($curl);
        curl_close($curl);
        $responseObj = json_decode($curlResponse);
        if (!empty($responseObj) && isset($responseObj->status) && $responseObj->status == 'success' && $payment_session->mds_payment_token == $tx_ref) {
            $data_transaction = array(
                'payment_method' => $flutterwave->name,
                'payment_id' => $transaction_id,
                'currency' => isset($responseObj->data->currency) ? $responseObj->data->currency : 'unset',
                'payment_amount' => isset($responseObj->data->amount) ? $responseObj->data->amount : 0,
                'payment_status' => "Succeeded"
            );
            //add order
            $response = $this->execute_payment($data_transaction, $payment_session->payment_type, lang_base_url());
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                redirect($response->redirect_url);
            } else {
                $this->session->set_flashdata('error', $response->message);
                redirect($response->redirect_url);
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($lang_base_url . get_route("cart", true) . get_route("payment"));
        }
    }

    /**
     * Payment with Iyzico
     */
    public function iyzico_payment_post()
    {
        $iyzico = get_payment_gateway('iyzico');
        if (empty($iyzico)) {
            $this->session->set_flashdata('error', "Payment method not found!");
            redirect($response->redirect_url);
            exit();
        }
        require_once(APPPATH . 'third_party/iyzipay/vendor/autoload.php');
        require_once(APPPATH . 'third_party/iyzipay/vendor/iyzico/iyzipay-php/IyzipayBootstrap.php');

        $token = $this->input->post('token', true);
        $conversation_id = $this->input->get('conversation_id', true);
        $lang = $this->input->get('lang', true);
        $payment_type = $this->input->get('payment_type', true);

        $lang_base_url = lang_base_url();
        if ($lang != $this->selected_lang->short_form) {
            $lang_base_url = base_url() . $lang . "/";
        }

        IyzipayBootstrap::init();
        $options = new \Iyzipay\Options();
        $options->setApiKey($iyzico->public_key);
        $options->setSecretKey($iyzico->secret_key);
        if ($iyzico->environment == "sandbox") {
            $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        } else {
            $options->setBaseUrl("https://api.iyzipay.com");
        }

        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($conversation_id);
        $request->setToken($token);

        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);
        if ($checkoutForm->getPaymentStatus() == "SUCCESS") {
            $data_transaction = array(
                'payment_method' => "Iyzico",
                'payment_id' => $checkoutForm->getPaymentId(),
                'currency' => $checkoutForm->getCurrency(),
                'payment_amount' => $checkoutForm->getPrice(),
                'payment_status' => "Succeeded"
            );
            //add order
            $response = $this->execute_payment($data_transaction, $payment_type, $lang_base_url);
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                redirect($response->redirect_url);
            } else {
                $this->session->set_flashdata('error', $response->message);
                redirect($response->redirect_url);
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($lang_base_url . get_route("cart", true) . get_route("payment"));
        }
    }

    /**
     * Payment with Midtrans
     */
    public function midtrans_payment_post()
    {
        $midtrans = get_payment_gateway('midtrans');
        if (empty($midtrans)) {
            $this->session->set_flashdata('error', "Payment method not found!");
            echo json_encode([
                'result' => 0
            ]);
            exit();
        }
        $payment_session = $this->session->userdata('mds_payment_cart_data');
        if (empty($payment_session)) {
            $this->session->set_flashdata('error', trans("invalid_attempt"));
            echo json_encode([
                'result' => 0
            ]);
            exit();
        }
        $transaction_id = $this->input->post('transaction_id', true);
        $curl = curl_init();
        $curlURL = "https://api.sandbox.midtrans.com/v2/" . $transaction_id . "/status";
        if ($midtrans->environment == "production") {
            $curlURL = "https://api.midtrans.com/v2/" . $transaction_id . "/status";
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $curlURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode($midtrans->secret_key)
            ],
        ));
        $curlResponse = curl_exec($curl);
        curl_close($curl);
        $responseObj = json_decode($curlResponse);
        if (!empty($responseObj) && $responseObj->status_code == 200 && $responseObj->order_id == $payment_session->mds_payment_token) {
            $data_transaction = array(
                'payment_method' => $midtrans->name,
                'payment_id' => $transaction_id,
                'currency' => "IDR",
                'payment_amount' => isset($responseObj->gross_amount) ? $responseObj->gross_amount : 0,
                'payment_status' => "Succeeded"
            );
            //add order
            $response = $this->execute_payment($data_transaction, $payment_session->payment_type, lang_base_url());
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                echo json_encode([
                    'result' => 1,
                    'redirect_url' => $response->redirect_url
                ]);
            } else {
                $this->session->set_flashdata('error', $response->message);
                echo json_encode([
                    'result' => 0
                ]);
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            echo json_encode([
                'result' => 0
            ]);
        }
    }

    /**
     * Execute Sale Payment
     */
    public function execute_payment($data_transaction, $payment_type, $base_url)
    {
        //response object
        $response = new stdClass();
        $response->result = 0;
        $response->message = "";
        $response->redirect_url = "";
        $data_transaction["payment_status"] = "payment_received";
        if ($payment_type == 'sale') {
            //add order
            $order_id = $this->order_model->add_order($data_transaction);
            $order = $this->order_model->get_order($order_id);
            if (!empty($order)) {
                //decrease product quantity after sale
                $this->order_model->decrease_product_stock_after_sale($order->id);
                //send email
                if ($this->general_settings->send_email_buyer_purchase == 1) {
                    $email_data = array(
                        'email_type' => 'new_order',
                        'order_id' => $order_id
                    );
                    $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                }
                //set response and redirect URLs
                $response->result = 1;
                $response->redirect_url = $base_url . get_route("order_details", true) . $order->order_number;
                if ($order->buyer_id == 0) {
                    $this->session->set_userdata('mds_show_order_completed_page', 1);
                    $response->redirect_url = $base_url . get_route("order_completed", true) . $order->order_number;
                } else {
                    $response->message = trans("msg_order_completed");
                }
            } else {
                //could not added to the database
                $response->message = trans("msg_payment_database_error");
                $response->result = 0;
                $response->redirect_url = $base_url . get_route("cart", true) . get_route("payment");
            }
        } elseif ($payment_type == 'membership') {
            $plan_id = $this->session->userdata('modesy_selected_membership_plan_id');
            $plan = null;
            if (!empty($plan_id)) {
                $plan = $this->membership_model->get_plan($plan_id);
            }
            if (!empty($plan)) {
                //add user membership plan
                $this->membership_model->add_user_plan($data_transaction, $plan, $this->auth_user->id);
                //add transaction
                $this->membership_model->add_membership_transaction($data_transaction, $plan);
                //set response and redirect URLs
                $response->result = 1;
                $response->redirect_url = $base_url . get_route("membership_payment_completed") . "?method=gtw";
            } else {
                //could not added to the database
                $response->message = trans("msg_payment_database_error");
                $response->result = 0;
                $response->redirect_url = $base_url . get_route("cart", true) . get_route("payment") . "?payment_type=membership";
            }
        } elseif ($payment_type == 'promote') {
            $promoted_plan = $this->session->userdata('modesy_selected_promoted_plan');
            if (!empty($promoted_plan)) {
                //add to promoted products
                $this->promote_model->add_to_promoted_products($promoted_plan);
                //add transaction
                $this->promote_model->add_promote_transaction($data_transaction);
                //reset cache
                reset_cache_data_on_change();
                reset_user_cache_data($this->auth_user->id);
                //set response and redirect URLs
                $response->result = 1;
                $response->redirect_url = $base_url . get_route("promote_payment_completed") . "?method=gtw&product_id=" . $promoted_plan->product_id;
            } else {
                //could not added to the database
                $response->message = trans("msg_payment_database_error");
                $response->result = 0;
                $response->redirect_url = $base_url . get_route("cart", true) . get_route("payment") . "?payment_type=promote";
            }
        }
        //reset session for the payment
        @$this->session->unset_userdata('mds_payment_cart_data');
        //return response
        return $response;
    }

    /**
     * Payment with Bank Transfer
     */
    public function bank_transfer_payment_post()
    {
        $mds_payment_type = $this->input->post('mds_payment_type', true);

        if ($mds_payment_type == 'membership') {
            $plan_id = $this->session->userdata('modesy_selected_membership_plan_id');
            $plan = null;
            if (!empty($plan_id)) {
                $plan = $this->membership_model->get_plan($plan_id);
            }
            if (!empty($plan)) {
                $data_transaction = array(
                    'payment_method' => 'Bank Transfer',
                    'payment_status' => 'awaiting_payment',
                    'payment_id' => $this->session->userdata('mds_membership_bank_transaction_number')
                );
                //add user membership plan
                $this->membership_model->add_user_plan($data_transaction, $plan, $this->auth_user->id);
                //add transaction
                $this->membership_model->add_membership_transaction_bank($data_transaction, $plan);
                redirect(generate_url("membership_payment_completed") . "?method=bank_transfer&transaction_number=" . $data_transaction['payment_id']);
            }
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(generate_url("cart", "payment") . "?payment_type=membership");
        } elseif ($mds_payment_type == 'promote') {
            $promoted_plan = $this->session->userdata('modesy_selected_promoted_plan');
            if (!empty($promoted_plan)) {
                $transaction_number = $this->session->userdata('mds_promote_bank_transaction_number');
                //add transaction
                $this->promote_model->add_promote_transaction_bank($promoted_plan, $transaction_number);

                $type = $this->session->userdata('mds_promote_product_type');

                if (empty($type)) {
                    $type = "new";
                }
                redirect(generate_url("promote_payment_completed") . "?method=bank_transfer&transaction_number=" . $transaction_number . "&product_id=" . $promoted_plan->product_id);
            }
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(generate_url("cart", "payment") . "?payment_type=promote");
        } else {
            //add order
            $order_id = $this->order_model->add_order_offline_payment("Bank Transfer");
            $order = $this->order_model->get_order($order_id);
            if (!empty($order)) {
                //decrease product quantity after sale
                $this->order_model->decrease_product_stock_after_sale($order->id);
                //send email
                if ($this->general_settings->send_email_buyer_purchase == 1) {
                    $email_data = array(
                        'email_type' => 'new_order',
                        'order_id' => $order_id
                    );
                    $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                }

                if ($order->buyer_id == 0) {
                    $this->session->set_userdata('mds_show_order_completed_page', 1);
                    redirect(generate_url("order_completed") . "/" . $order->order_number);
                } else {
                    $this->session->set_flashdata('success', trans("msg_order_completed"));
                    redirect(generate_url("order_details") . "/" . $order->order_number);
                }
            }

            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(generate_url("cart", "payment"));
        }
    }

    /**
     * Cash on Delivery
     */
    public function cash_on_delivery_payment_post()
    {
        //add order
        $order_id = $this->order_model->add_order_offline_payment("Cash On Delivery");
        $order = $this->order_model->get_order($order_id);
        if (!empty($order)) {
            //decrease product quantity after sale
            $this->order_model->decrease_product_stock_after_sale($order->id);
            //send email
            if ($this->general_settings->send_email_buyer_purchase == 1) {
                $email_data = array(
                    'email_type' => 'new_order',
                    'order_id' => $order_id
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }

            if ($order->buyer_id == 0) {
                $this->session->set_userdata('mds_show_order_completed_page', 1);
                redirect(generate_url("order_completed") . "/" . $order->order_number);
            } else {
                $this->session->set_flashdata('success', trans("msg_order_completed"));
                redirect(generate_url("order_details") . "/" . $order->order_number);
            }
        }

        $this->session->set_flashdata('error', trans("msg_error"));
        redirect(generate_url("cart", "payment"));
    }

    /**
     * Order Completed
     */
    public function order_completed($order_number)
    {
        $data['title'] = trans("msg_order_completed");
        $data['description'] = trans("msg_order_completed") . " - " . $this->app_name;
        $data['keywords'] = trans("msg_order_completed") . "," . $this->app_name;

        $data['order'] = $this->order_model->get_order_by_order_number($order_number);

        if (empty($data['order'])) {
            redirect(lang_base_url());
        }

        if (empty($this->session->userdata('mds_show_order_completed_page'))) {
            redirect(lang_base_url());
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/order_completed', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Membership Payment Completed
     */
    public function membership_payment_completed()
    {
        $data['title'] = trans("msg_payment_completed");
        $data['description'] = trans("msg_payment_completed") . " - " . $this->app_name;
        $data['keywords'] = trans("payment") . "," . $this->app_name;
        $transaction_insert_id = $this->session->userdata('mds_membership_transaction_insert_id');
        if (empty($transaction_insert_id)) {
            redirect(lang_base_url());
        }
        $data["transaction"] = $this->membership_model->get_membership_transaction($transaction_insert_id);
        if (empty($data["transaction"])) {
            redirect(lang_base_url());
            exit();
        }

        $data["method"] = $this->input->get('method');
        $data["transaction_number"] = $this->input->get('transaction_number');


        $this->load->view('partials/_header', $data);
        $this->load->view('cart/membership_payment_completed', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Promote Payment Completed
     */
    public function promote_payment_completed()
    {
        $data['title'] = trans("msg_payment_completed");
        $data['description'] = trans("msg_payment_completed") . " - " . $this->app_name;
        $data['keywords'] = trans("payment") . "," . $this->app_name;
        $transaction_insert_id = $this->session->userdata('mds_promoted_transaction_insert_id');
        if (empty($transaction_insert_id)) {
            redirect(lang_base_url());
        }
        $data["transaction"] = $this->promote_model->get_promotion_transaction($transaction_insert_id);
        if (empty($data["transaction"])) {
            redirect(lang_base_url());
            exit();
        }
        $data["method"] = $this->input->get('method');
        $data["transaction_number"] = $this->input->get('transaction_number');

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/promote_payment_completed', $data);
        $this->load->view('partials/_footer');
    }

    //get shipping method by location
    public function get_shipping_methods_by_location()
    {
        $data = array(
            'result' => 0,
            'html_content' => ""
        );
        $state_id = $this->input->post('state_id', true);
        $cart_items = $this->session_cart_items;
        if (!empty($state_id)) {
            $vars = array(
                "shipping_methods" => $this->shipping_model->get_seller_shipping_methods_array($cart_items, $state_id)
            );
            $html_content = $this->load->view('cart/_shipping_methods', $vars, true);
            $data['result'] = 1;
            $data['html_content'] = $html_content;
        }
        echo json_encode($data);
    }
}
