<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->cart_product_ids = array();
    }

    //add to cart
    public function add_to_cart($product)
    {
        $cart = $this->session_cart_items;
        $quantity = $this->input->post('product_quantity', true);
        if ($quantity < 1) {
            $quantity = 1;
        }
        if ($product->product_type == "digital") {
            $quantity = 1;
        }
        $appended_variations = $this->get_selected_variations($product->id)->str;
        $options_array = $this->get_selected_variations($product->id)->options_array;

        $product_id = $product->id;
        $product_title = get_product_title($product) . " " . $appended_variations;
        //check if item exists
        $cart = $this->session_cart_items;
        $update_quantity = 0;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                if ($item->product_id == $product_id && $item->product_title == $product_title) {
                    $item->quantity += 1;
                    $update_quantity = 1;
                }
            }
        }
        if ($update_quantity == 1) {
            $this->session->set_userdata('mds_shopping_cart', $cart);
        } else {
            $item = new stdClass();
            $item->cart_item_id = generate_unique_id();
            $item->product_id = $product->id;
            $item->product_type = $product->product_type;
            $item->product_title = get_product_title($product) . " " . $appended_variations;
            $item->options_array = $options_array;
            $item->quantity = $quantity;
            $item->unit_price = null;
            $item->total_price = null;
            $item->discount_rate = 0;
            $item->currency = $this->selected_currency->code;
            $item->product_vat = 0;
            $item->is_stock_available = null;
            $item->purchase_type = 'product';
            $item->quote_request_id = 0;
            array_push($cart, $item);
            $this->session->set_userdata('mds_shopping_cart', $cart);
        }
    }

    //add to cart quote
    public function add_to_cart_quote($quote_request_id)
    {
        $this->load->model('bidding_model');
        $quote_request = $this->bidding_model->get_quote_request($quote_request_id);

        if (!empty($quote_request)) {
            $product = $this->product_model->get_active_product($quote_request->product_id);
            if (!empty($product)) {
                $cart = $this->session_cart_items;
                $item = new stdClass();
                $item->cart_item_id = generate_unique_id();
                $item->product_id = $product->id;
                $item->product_type = $product->product_type;
                $item->product_title = $quote_request->product_title;
                $item->options_array = array();
                $item->quantity = $quote_request->product_quantity;
                $item->unit_price = null;
                $item->total_price = null;
                $item->currency = $this->selected_currency->code;
                $item->product_vat = 0;
                $item->is_stock_available = 1;
                $item->purchase_type = 'bidding';
                $item->quote_request_id = $quote_request->id;
                array_push($cart, $item);

                $this->session->set_userdata('mds_shopping_cart', $cart);
                return true;
            }
        }
        return false;
    }

    //remove from cart
    public function remove_from_cart($cart_item_id)
    {
        $cart = $this->session_cart_items;
        if (!empty($cart)) {
            $new_cart = array();
            foreach ($cart as $item) {
                if ($item->cart_item_id != $cart_item_id) {
                    array_push($new_cart, $item);
                }
            }
            $this->session->set_userdata('mds_shopping_cart', $new_cart);
        }
    }

    //get selected variations
    public function get_selected_variations($product_id)
    {
        $object = new stdClass();
        $object->str = "";
        $object->options_array = array();

        $variations = $this->variation_model->get_product_variations($product_id);
        $str = "";
        if (!empty($variations)) {
            foreach ($variations as $variation) {
                $append_text = "";
                if (!empty($variation) && $variation->is_visible == 1) {
                    $variation_val = $this->input->post('variation' . $variation->id, true);
                    if (!empty($variation_val)) {

                        if ($variation->variation_type == "text" || $variation->variation_type == "number") {
                            $append_text = $variation_val;
                        } else {
                            //check multiselect
                            if (is_array($variation_val)) {
                                $i = 0;
                                foreach ($variation_val as $item) {
                                    $option = $this->variation_model->get_variation_option($item);
                                    if (!empty($option)) {
                                        if ($i == 0) {
                                            $append_text .= get_variation_option_name($option->option_names, $this->selected_lang->id);
                                        } else {
                                            $append_text .= " - " . get_variation_option_name($option->option_names, $this->selected_lang->id);
                                        }
                                        $i++;
                                        array_push($object->options_array, $option->id);
                                    }
                                }
                            } else {
                                $option = $this->variation_model->get_variation_option($variation_val);
                                if (!empty($option)) {
                                    $append_text .= get_variation_option_name($option->option_names, $this->selected_lang->id);
                                    array_push($object->options_array, $option->id);
                                }
                            }
                        }

                        if (empty($str)) {
                            $str .= "(" . get_variation_label($variation->label_names, $this->selected_lang->id) . ": " . $append_text;
                        } else {
                            $str .= ", " . get_variation_label($variation->label_names, $this->selected_lang->id) . ": " . $append_text;
                        }
                    }
                }
            }
            if (!empty($str)) {
                $str = $str . ")";
            }
        }
        $object->str = $str;

        return $object;
    }

    //get product price and stock
    public function get_product_price_and_stock($product, $cart_product_title, $options_array)
    {
        $object = new stdClass();
        $object->price = 0;
        $object->discount_rate = 0;
        $object->price_calculated = 0;
        $object->is_stock_available = 0;

        if (!empty($product)) {
            //quantity in cart
            $quantity_in_cart = 0;
            if (!empty($this->session->userdata('mds_shopping_cart'))) {
                foreach ($this->session->userdata('mds_shopping_cart') as $item) {
                    if (($item->product_id == $product->id && $item->product_title == $cart_product_title) || ($item->product_id == $product->id && empty($item->options_array))) {
                        $quantity_in_cart += $item->quantity;
                    }
                }
            }

            $stock = $product->stock;
            $price = get_price($product->price, 'decimal');
            $discount_rate = $product->discount_rate;
            if (!empty($options_array)) {
                foreach ($options_array as $option_id) {
                    $option = $this->variation_model->get_variation_option($option_id);
                    if (!empty($option)) {
                        $variation = $this->variation_model->get_variation($option->variation_id);
                        if ($variation->use_different_price == 1) {
                            if (!empty($option->price)) {
                                $price = get_price($option->price, 'decimal');
                            }
                            if (!empty($option->discount_rate)) {
                                $discount_rate = $option->discount_rate;
                            }
                        }
                        if ($option->is_default != 1) {
                            $stock = $option->stock;
                        }
                    }
                }
            }

            if (empty($price)) {
                $object->price = $price;
                $discount_rate = $product->discount_rate;
            }
            $price = $price - (($price * $discount_rate) / 100);
            $object->price_calculated = number_format($price, 2, ".", "");
            if ($stock >= $quantity_in_cart) {
                $object->is_stock_available = 1;
            }
            if ($product->product_type == 'digital') {
                $object->is_stock_available = 1;
            }
        }
        return $object;
    }

    //update cart product quantity
    public function update_cart_product_quantity($product_id, $cart_item_id, $quantity)
    {
        if ($quantity < 1) {
            $quantity = 1;
        }
        $cart = $this->session_cart_items;
        if (!empty($cart)) {
            foreach ($cart as $item) {
                if ($item->cart_item_id == $cart_item_id) {
                    $item->quantity = $quantity;
                }
            }
        }
        $this->session->set_userdata('mds_shopping_cart', $cart);
    }

    //get cart items session
    public function get_sess_cart_items()
    {
        $cart = array();
        $new_cart = array();
        $this->cart_product_ids = array();
        if (!empty($this->session->userdata('mds_shopping_cart'))) {
            $cart = $this->session->userdata('mds_shopping_cart');
        }
        if (!empty($cart)) {
            foreach ($cart as $cart_item) {
                $product = $this->product_model->get_active_product($cart_item->product_id);
                if (!empty($product)) {
                    //if purchase type is bidding
                    if ($cart_item->purchase_type == 'bidding') {
                        $this->load->model('bidding_model');
                        $quote_request = $this->bidding_model->get_quote_request($cart_item->quote_request_id);
                        if (!empty($quote_request) && $quote_request->status == 'pending_payment') {
                            $price_offered = get_price($quote_request->price_offered, 'decimal');
                            //convert currency
                            $base_currency = $this->selected_currency;
                            if ($this->payment_settings->currency_converter == 1) {
                                $base_currency = $this->selected_currency;
                                if (!empty($base_currency)) {
                                    $price_offered = convert_currency_by_exchange_rate($price_offered, $base_currency->exchange_rate);
                                }
                            }
                            $item = new stdClass();
                            $item->cart_item_id = $cart_item->cart_item_id;
                            $item->product_id = $product->id;
                            $item->product_type = $cart_item->product_type;
                            $item->product_title = $cart_item->product_title;
                            $item->options_array = $cart_item->options_array;
                            $item->quantity = $cart_item->quantity;
                            $item->unit_price = $price_offered / $quote_request->product_quantity;
                            $item->total_price = $price_offered;
                            $item->discount_rate = 0;
                            $item->currency = $base_currency->code;
                            $item->product_vat = 0;
                            $item->purchase_type = $cart_item->purchase_type;
                            $item->quote_request_id = $cart_item->quote_request_id;
                            $item->seller_id = $product->user_id;
                            $item->shipping_class_id = $product->shipping_class_id;
                            $item->is_stock_available = 1;
                            array_push($new_cart, $item);
                        }
                    } else {
                        $object = $this->get_product_price_and_stock($product, $cart_item->product_title, $cart_item->options_array);
                        //convert currency
                        $base_currency = $this->selected_currency;
                        if ($this->payment_settings->currency_converter == 1) {
                            $base_currency = $this->selected_currency;
                            if (!empty($base_currency)) {
                                $object->price_calculated = convert_currency_by_exchange_rate($object->price_calculated, $base_currency->exchange_rate);
                            }
                        }
                        $item = new stdClass();
                        $item->cart_item_id = $cart_item->cart_item_id;
                        $item->product_id = $product->id;
                        $item->product_type = $cart_item->product_type;
                        $item->product_title = $cart_item->product_title;
                        $item->options_array = $cart_item->options_array;
                        $item->quantity = $cart_item->quantity;
                        $item->unit_price = $object->price_calculated;
                        $item->total_price = $object->price_calculated * $cart_item->quantity;
                        $item->discount_rate = $object->discount_rate;
                        $item->currency = $product->currency;
                        $item->product_vat = $this->calculate_total_vat($object->price_calculated, $product->vat_rate, $cart_item->quantity);
                        $item->purchase_type = $cart_item->purchase_type;
                        $item->quote_request_id = $cart_item->quote_request_id;
                        $item->seller_id = $product->user_id;
                        $item->shipping_class_id = $product->shipping_class_id;
                        $item->is_stock_available = $object->is_stock_available;
                        array_push($new_cart, $item);
                    }
                }
            }
        }

        //convert currency
        if ($this->payment_settings->currency_converter == 1 && !empty($base_currency)) {
            if (!empty($new_cart)) {
                foreach ($new_cart as $item) {
                    $item->currency = $base_currency->code;
                }
            }
        }

        $this->session->set_userdata('mds_shopping_cart', $new_cart);
        return $new_cart;
    }

    //calculate cart total
    public function calculate_cart_total($cart_items, $currency_code = null, $set_session = true)
    {
        if (empty($currency_code)) {
            $currency_code = $this->selected_currency->code;
        }
        $cart_total = new stdClass();
        $cart_total->subtotal = 0;
        $cart_total->vat = 0;
        $cart_total->shipping_cost = 0;
        $cart_total->total_before_shipping = 0;
        $cart_total->total = 0;
        $cart_total->is_stock_available = 1;
        $cart_total->currency = $currency_code;
        $seller_total = array();
        $seller_num_items = array();
        $seller_ids = array();
        if (!empty($cart_items)) {
            foreach ($cart_items as $item) {
                if ($item->purchase_type == 'bidding') {
                    $cart_total->subtotal += $item->total_price;
                } else {
                    $cart_total->subtotal += $item->total_price;
                    $cart_total->vat += $item->product_vat;
                }
                if ($item->is_stock_available != 1) {
                    $cart_total->is_stock_available = 0;
                }
            }
        }
        //set shipping cost
        if (!empty($this->session->userdata('mds_cart_shipping'))) {
            $shipping_cost = $this->session->userdata('mds_cart_shipping')->total_cost;
            $currency = get_currency_by_code($currency_code);
            if (!empty($currency)) {
                $shipping_cost = convert_currency_by_exchange_rate($shipping_cost, $currency->exchange_rate);
            }
            $cart_total->shipping_cost = $shipping_cost;
        }
        $cart_total->total_before_shipping = $cart_total->subtotal + $cart_total->vat;
        $cart_total->total = $cart_total->subtotal + $cart_total->vat + $cart_total->shipping_cost;
        if ($set_session == true) {
            $this->session->set_userdata('mds_shopping_cart_total', $cart_total);
        } else {
            return $cart_total;
        }
    }

    //calculate total vat
    public function calculate_total_vat($price, $vat_rate, $quantity)
    {
        $vat = 0;
        if (!empty($price)) {
            $vat = (($price * $vat_rate) / 100) * $quantity;
            if (filter_var($vat, FILTER_VALIDATE_INT) === false) {
                $vat = number_format($vat, 2, ".", "");
            }
        }
        return $vat;
    }

    //check cart has physical products
    public function check_cart_has_physical_product()
    {
        $cart_items = $this->session_cart_items;
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                if ($cart_item->product_type == 'physical') {
                    return true;
                }
            }
        }
        return false;
    }

    //check cart has digital products
    public function check_cart_has_digital_product()
    {
        $cart_items = $this->session_cart_items;
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                if ($cart_item->product_type == 'digital') {
                    return true;
                }
            }
        }
        return false;
    }

    //validate cart
    public function validate_cart()
    {
        $cart_total = $this->cart_model->get_sess_cart_total();
        if (!empty($cart_total)) {
            if ($cart_total->total <= 0 || $cart_total->is_stock_available != 1) {
                redirect(generate_url("cart"));
                exit();
            }
        }
    }

    //get cart total session
    public function get_sess_cart_total()
    {
        $cart_total = new stdClass();
        if (!empty($this->session->userdata('mds_shopping_cart_total'))) {
            $cart_total = $this->session->userdata('mds_shopping_cart_total');
        }
        return $cart_total;
    }

    //set cart payment method option session
    public function set_sess_cart_payment_method()
    {
        $std = new stdClass();
        $std->payment_option = $this->input->post('payment_option', true);
        $std->terms_conditions = $this->input->post('terms_conditions', true);
        $this->session->set_userdata('mds_cart_payment_method', $std);
    }

    //get cart payment method option session
    public function get_sess_cart_payment_method()
    {
        if (!empty($this->session->userdata('mds_cart_payment_method'))) {
            return $this->session->userdata('mds_cart_payment_method');
        }
    }

    //unset cart items session
    public function unset_sess_cart_items()
    {
        if (!empty($this->session->userdata('mds_shopping_cart'))) {
            $this->session->unset_userdata('mds_shopping_cart');
        }
    }

    //unset cart total
    public function unset_sess_cart_total()
    {
        if (!empty($this->session->userdata('mds_shopping_cart_total'))) {
            $this->session->unset_userdata('mds_shopping_cart_total');
        }
    }

    //unset cart payment method option session
    public function unset_sess_cart_payment_method()
    {
        if (!empty($this->session->userdata('mds_cart_payment_method'))) {
            $this->session->unset_userdata('mds_cart_payment_method');
        }
    }

    //clear cart
    public function clear_cart()
    {
        $this->unset_sess_cart_items();
        $this->unset_sess_cart_total();
        $this->unset_sess_cart_payment_method();
        if (!empty($this->session->userdata('mds_shopping_cart_final'))) {
            $this->session->unset_userdata('mds_shopping_cart_final');
        }
        if (!empty($this->session->userdata('mds_shopping_cart_total_final'))) {
            $this->session->unset_userdata('mds_shopping_cart_total_final');
        }
        if (!empty($this->session->userdata('mds_cart_shipping'))) {
            $this->session->unset_userdata('mds_cart_shipping');
        }
    }

    //get cart total by currency
    public function get_cart_total_by_currency($currency)
    {
        $cart = array();
        $new_cart = array();
        $this->cart_product_ids = array();
        if (!empty($this->session->userdata('mds_shopping_cart'))) {
            $cart = $this->session->userdata('mds_shopping_cart');
        }
        foreach ($cart as $cart_item) {
            $product = $this->product_model->get_active_product($cart_item->product_id);
            if (!empty($product)) {
                //if purchase type is bidding
                if ($cart_item->purchase_type == 'bidding') {
                    $this->load->model('bidding_model');
                    $quote_request = $this->bidding_model->get_quote_request($cart_item->quote_request_id);
                    if (!empty($quote_request) && $quote_request->status == 'pending_payment') {
                        $price_offered = get_price($quote_request->price_offered, 'decimal');
                        //convert currency
                        if (!empty($currency)) {
                            $price_offered = convert_currency_by_exchange_rate($price_offered, $currency->exchange_rate);
                        }
                        $item = new stdClass();
                        $item->purchase_type = $cart_item->purchase_type;
                        $item->quantity = $cart_item->quantity;
                        $item->unit_price = $price_offered / $quote_request->product_quantity;
                        $item->total_price = $price_offered;
                        $item->discount_rate = 0;
                        $item->product_vat = 0;
                        $item->is_stock_available = $cart_item->is_stock_available;
                        array_push($new_cart, $item);
                    }
                } else {
                    $object = $this->get_product_price_and_stock($product, $cart_item->product_title, $cart_item->options_array);
                    //convert currency
                    if (!empty($currency)) {
                        $object->price_calculated = convert_currency_by_exchange_rate($object->price_calculated, $currency->exchange_rate);
                    }
                    $item = new stdClass();
                    $item->purchase_type = $cart_item->purchase_type;
                    $item->quantity = $cart_item->quantity;
                    $item->unit_price = $object->price_calculated;
                    $item->total_price = $object->price_calculated * $cart_item->quantity;
                    $item->discount_rate = $object->discount_rate;
                    $item->product_vat = $this->calculate_total_vat($object->price_calculated, $product->vat_rate, $cart_item->quantity);
                    $item->is_stock_available = $cart_item->is_stock_available;
                    array_push($new_cart, $item);
                }
            }
        }

        return $this->calculate_cart_total($new_cart, $currency->code, false);
    }

    //convert currency by payment gateway
    public function convert_currency_by_payment_gateway($total, $payment_type)
    {
        $data = new stdClass();
        $data->total = $total;
        $data->currency = $this->selected_currency->code;
        $payment_method = $this->get_sess_cart_payment_method();
        if ($this->payment_settings->currency_converter != 1) {
            return $data;
        }
        if (empty($payment_method)) {
            return $data;
        }
        if (empty($payment_method->payment_option) || $payment_method->payment_option == "bank_transfer" || $payment_method->payment_option == "cash_on_delivery") {
            return $data;
        }
        $payment_gateway = get_payment_gateway($payment_method->payment_option);
        if (!empty($payment_gateway)) {
            if (empty($payment_gateway->base_currency) || $payment_gateway->base_currency == "all") {
                $new_currency = $this->selected_currency;
            } else {
                $new_currency = get_currency_by_code($payment_gateway->base_currency);
            }
            if ($payment_type == "sale") {
                if ($payment_gateway->base_currency != $this->selected_currency->code && $payment_gateway->base_currency != "all") {
                    if (!empty($new_currency)) {
                        $new_total = $this->get_cart_total_by_currency($new_currency);
                        if (!empty($new_total)) {
                            $data->total = $new_total->total;
                            $data->currency = $new_currency->code;
                        }
                    }
                }
            } elseif ($payment_type == "membership") {
                $total = get_price($total, 'decimal');
                $new_total = convert_currency_by_exchange_rate($total, $new_currency->exchange_rate);
                if (!empty($new_total)) {
                    $data->total = $new_total;
                    $data->currency = $new_currency->code;
                }
            } elseif ($payment_type == "promote") {
                $new_total = convert_currency_by_exchange_rate($total, $new_currency->exchange_rate);
                if (!empty($new_total)) {
                    $data->total = $new_total;
                    $data->currency = $new_currency->code;
                }
            }
        }
        return $data;
    }

    //set guest shipping address
    public function set_guest_shipping_address()
    {
        return array(
            'first_name' => $this->input->post('shipping_first_name', true),
            'last_name' => $this->input->post('shipping_last_name', true),
            'email' => $this->input->post('shipping_email', true),
            'phone_number' => $this->input->post('shipping_phone_number', true),
            'address' => $this->input->post('shipping_address', true),
            'country_id' => $this->input->post('shipping_country_id', true),
            'state_id' => $this->input->post('shipping_state_id', true),
            'city' => $this->input->post('shipping_city', true),
            'zip_code' => $this->input->post('shipping_zip_code', true)
        );
    }

    //set guest billing address
    public function set_guest_billing_address()
    {
        return array(
            'first_name' => $this->input->post('billing_first_name', true),
            'last_name' => $this->input->post('billing_last_name', true),
            'email' => $this->input->post('billing_email', true),
            'phone_number' => $this->input->post('billing_phone_number', true),
            'address' => $this->input->post('billing_address', true),
            'country_id' => $this->input->post('billing_country_id', true),
            'state_id' => $this->input->post('billing_state_id', true),
            'city' => $this->input->post('billing_city', true),
            'zip_code' => $this->input->post('billing_zip_code', true)
        );
    }
}
