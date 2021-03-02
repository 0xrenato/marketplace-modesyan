<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends CI_Model
{
    //add order
    public function add_order($data_transaction)
    {
        $cart_total = $this->session->userdata('mds_shopping_cart_total_final');
        if (!empty($cart_total)) {
            $data = array(
                'order_number' => uniqid(),
                'buyer_id' => 0,
                'buyer_type' => "guest",
                'price_subtotal' => get_price($cart_total->subtotal, "database"),
                'price_vat' => get_price($cart_total->vat, "database"),
                'price_shipping' => get_price($cart_total->shipping_cost, "database"),
                'price_total' => get_price($cart_total->total, "database"),
                'price_currency' => $cart_total->currency,
                'status' => 0,
                'payment_method' => $data_transaction["payment_method"],
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            //if cart does not have physical product
            if ($this->cart_model->check_cart_has_physical_product() != true) {
                $data["status"] = 1;
            }

            if ($this->auth_check) {
                $data["buyer_type"] = "registered";
                $data["buyer_id"] = $this->auth_user->id;
            }
            if ($this->db->insert('orders', $data)) {
                $order_id = $this->db->insert_id();

                //update order number
                $this->update_order_number($order_id);

                //add order shipping
                $this->add_order_shipping($order_id);

                //add order products
                $this->add_order_products($order_id, 'payment_received');

                //add digital sales
                $this->add_digital_sales($order_id);

                //add seller earnings
                $this->add_digital_sales_seller_earnings($order_id);

                //add payment transaction
                $this->add_payment_transaction($data_transaction, $order_id);

                //set bidding quotes as completed
                $this->load->model('bidding_model');
                $this->bidding_model->set_bidding_quotes_as_completed_after_purchase();

                //clear cart
                $this->cart_model->clear_cart();

                return $order_id;
            }
            return false;
        }
        return false;
    }

    //add order offline payment
    public function add_order_offline_payment($payment_method)
    {
        $order_status = "awaiting_payment";
        $payment_status = "awaiting_payment";
        if ($payment_method == 'Cash On Delivery') {
            $order_status = "order_processing";
        }

        $cart_total = $this->session->userdata('mds_shopping_cart_total_final');
        if (!empty($cart_total)) {
            $data = array(
                'order_number' => uniqid(),
                'buyer_id' => 0,
                'buyer_type' => "guest",
                'price_subtotal' => get_price($cart_total->subtotal, "database"),
                'price_vat' => get_price($cart_total->vat, "database"),
                'price_shipping' => get_price($cart_total->shipping_cost, "database"),
                'price_total' => get_price($cart_total->total, "database"),
                'price_currency' => $cart_total->currency,
                'status' => 0,
                'payment_method' => $payment_method,
                'payment_status' => $payment_status,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            if ($this->auth_check) {
                $data["buyer_type"] = "registered";
                $data["buyer_id"] = $this->auth_user->id;
            }
            if ($this->db->insert('orders', $data)) {
                $order_id = $this->db->insert_id();

                //update order number
                $this->update_order_number($order_id);

                //add order shipping
                $this->add_order_shipping($order_id);

                //add order products
                $this->add_order_products($order_id, $order_status);

                //set bidding quotes as completed
                $this->load->model('bidding_model');
                $this->bidding_model->set_bidding_quotes_as_completed_after_purchase();

                //add invoice
                $this->add_invoice($order_id);

                //clear cart
                $this->cart_model->clear_cart();

                return $order_id;
            }
            return false;
        }
        return false;
    }

    //update order number
    public function update_order_number($order_id)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'order_number' => $order_id + 10000
        );
        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);
    }

    //add order shipping
    public function add_order_shipping($order_id)
    {
        $cart_shipping = get_sess_data('mds_cart_shipping');
        if (!empty($cart_shipping)) {
            if ($cart_shipping->is_guest == true) {
                $shipping_address = array();
                $billing_address = array();
                if (!empty($cart_shipping->guest_shipping_address)) {
                    $shipping_address = $cart_shipping->guest_shipping_address;
                }
                if (!empty($cart_shipping->guest_billing_address)) {
                    $billing_address = $cart_shipping->guest_billing_address;
                }
                $country_shipping = !empty($shipping_address['country_id']) ? get_country($shipping_address['country_id']) : '';
                $state_shipping = !empty($shipping_address['state_id']) ? get_state($shipping_address['state_id']) : '';
                $country_billing = !empty($billing_address['country_id']) ? get_country($billing_address['country_id']) : '';
                $state_billing = !empty($billing_address['state_id']) ? get_state($billing_address['state_id']) : '';
                $data = array(
                    'order_id' => $order_id,
                    'shipping_first_name' => !empty($shipping_address['first_name']) ? $shipping_address['first_name'] : '',
                    'shipping_last_name' => !empty($shipping_address['last_name']) ? $shipping_address['last_name'] : '',
                    'shipping_email' => !empty($shipping_address['email']) ? $shipping_address['email'] : '',
                    'shipping_phone_number' => !empty($shipping_address['phone_number']) ? $shipping_address['phone_number'] : '',
                    'shipping_country' => !empty($country_shipping) ? $country_shipping->name : '',
                    'shipping_state' => !empty($state_shipping) ? $state_shipping->name : '',
                    'shipping_address' => !empty($shipping_address['address']) ? $shipping_address['address'] : '',
                    'shipping_city' => !empty($shipping_address['city']) ? $shipping_address['city'] : '',
                    'shipping_zip_code' => !empty($shipping_address['zip_code']) ? $shipping_address['zip_code'] : '',
                    'billing_first_name' => !empty($billing_address['first_name']) ? $billing_address['first_name'] : '',
                    'billing_last_name' => !empty($billing_address['last_name']) ? $billing_address['last_name'] : '',
                    'billing_email' => !empty($billing_address['email']) ? $billing_address['email'] : '',
                    'billing_phone_number' => !empty($billing_address['phone_number']) ? $billing_address['phone_number'] : '',
                    'billing_country' => !empty($country_billing) ? $country_billing->name : '',
                    'billing_state' => !empty($state_billing) ? $state_billing->name : '',
                    'billing_address' => !empty($billing_address['address']) ? $billing_address['address'] : '',
                    'billing_city' => !empty($billing_address['city']) ? $billing_address['city'] : '',
                    'billing_zip_code' => !empty($billing_address['zip_code']) ? $billing_address['zip_code'] : '',
                );
            } else {
                $shipping_address = array();
                $billing_address = array();
                if (!empty($cart_shipping->shipping_address_id)) {
                    $shipping_address = $this->profile_model->get_shipping_address_by_id($cart_shipping->shipping_address_id);
                }
                if (!empty($cart_shipping->billing_address_id)) {
                    $billing_address = $this->profile_model->get_shipping_address_by_id($cart_shipping->billing_address_id);
                }
                $country_shipping = !empty($shipping_address->country_id) ? get_country($shipping_address->country_id) : '';
                $state_shipping = !empty($shipping_address->state_id) ? get_state($shipping_address->state_id) : '';
                $country_billing = !empty($billing_address->country_id) ? get_country($billing_address->country_id) : '';
                $state_billing = !empty($billing_address->state_id) ? get_state($billing_address->state_id) : '';
                $data = array(
                    'order_id' => $order_id,
                    'shipping_first_name' => !empty($shipping_address->first_name) ? $shipping_address->first_name : '',
                    'shipping_last_name' => !empty($shipping_address->last_name) ? $shipping_address->last_name : '',
                    'shipping_email' => !empty($shipping_address->email) ? $shipping_address->email : '',
                    'shipping_phone_number' => !empty($shipping_address->phone_number) ? $shipping_address->phone_number : '',
                    'shipping_country' => !empty($country_shipping) ? $country_shipping->name : '',
                    'shipping_state' => !empty($state_shipping) ? $state_shipping->name : '',
                    'shipping_address' => !empty($shipping_address->address) ? $shipping_address->address : '',
                    'shipping_city' => !empty($shipping_address->city) ? $shipping_address->city : '',
                    'shipping_zip_code' => !empty($shipping_address->zip_code) ? $shipping_address->zip_code : '',
                    'billing_first_name' => !empty($billing_address->first_name) ? $billing_address->first_name : '',
                    'billing_last_name' => !empty($billing_address->last_name) ? $billing_address->last_name : '',
                    'billing_email' => !empty($billing_address->email) ? $billing_address->email : '',
                    'billing_phone_number' => !empty($billing_address->phone_number) ? $billing_address->phone_number : '',
                    'billing_country' => !empty($country_billing) ? $country_billing->name : '',
                    'billing_state' => !empty($state_billing) ? $state_billing->name : '',
                    'billing_address' => !empty($billing_address->address) ? $billing_address->address : '',
                    'billing_city' => !empty($billing_address->city) ? $billing_address->city : '',
                    'billing_zip_code' => !empty($billing_address->zip_code) ? $billing_address->zip_code : '',
                );
            }
        }
        if (!empty($data)) {
            $this->db->insert('order_shipping', $data);
        }
    }

    //add order products
    public function add_order_products($order_id, $order_status)
    {
        $order_id = clean_number($order_id);
        $cart_items = $this->session->userdata('mds_shopping_cart_final');
        $seller_shipping_costs = array();
        if (!empty($this->session->userdata('mds_seller_shipping_costs'))) {
            $seller_shipping_costs = $this->session->userdata('mds_seller_shipping_costs');
        }
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                $product = get_active_product($cart_item->product_id);
                $variation_option_ids = @serialize($cart_item->options_array);
                if (!empty($product)) {
                    $shipping_method = "";
                    $seller_shipping_cost = 0;
                    if (!empty($seller_shipping_costs[$product->user_id])) {
                        if (!empty($seller_shipping_costs[$product->user_id]->shipping_method_id)) {
                            $method = $this->db->where('id', clean_number($seller_shipping_costs[$product->user_id]->shipping_method_id))->get('shipping_zone_methods')->row();
                            if (!empty($method)) {
                                $shipping_method = @parse_serialized_name_array($method->name_array, $this->selected_lang->id);
                            }
                        }
                        if (!empty($seller_shipping_costs[$product->user_id]->cost)) {
                            $seller_shipping_cost = get_price($seller_shipping_costs[$product->user_id]->cost, "database");
                        }
                    }
                    if ($this->payment_settings->currency_converter == 1 && !empty($seller_shipping_cost)) {
                        $seller_shipping_cost = convert_currency_by_exchange_rate($seller_shipping_cost, $this->selected_currency->exchange_rate);
                    }
                    $data = array(
                        'order_id' => $order_id,
                        'seller_id' => $product->user_id,
                        'buyer_id' => 0,
                        'buyer_type' => "guest",
                        'product_id' => $product->id,
                        'product_type' => $product->product_type,
                        'listing_type' => $product->listing_type,
                        'product_title' => $cart_item->product_title,
                        'product_slug' => $product->slug,
                        'product_unit_price' => get_price($cart_item->unit_price, "database"),
                        'product_quantity' => $cart_item->quantity,
                        'product_currency' => $cart_item->currency,
                        'product_vat_rate' => $product->vat_rate,
                        'product_vat' => get_price($cart_item->product_vat, "database"),
                        'product_total_price' => get_price($cart_item->total_price, "database"),
                        'variation_option_ids' => $variation_option_ids,
                        'commission_rate' => $this->general_settings->commission_rate,
                        'order_status' => $order_status,
                        'is_approved' => 0,
                        'shipping_tracking_number' => "",
                        'shipping_tracking_url' => "",
                        'shipping_method' => $shipping_method,
                        'seller_shipping_cost' => $seller_shipping_cost,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    if ($this->auth_check) {
                        $data["buyer_id"] = $this->auth_user->id;
                        $data["buyer_type"] = "registered";
                    }
                    //approve if digital product
                    if ($product->product_type == 'digital') {
                        $data["is_approved"] = 1;
                        if ($order_status == 'payment_received') {
                            $data["order_status"] = 'completed';
                        } else {
                            $data["order_status"] = $order_status;
                        }
                    }
                    $data["product_total_price"] = get_price($cart_item->total_price, "database") + get_price($cart_item->product_vat, "database");

                    //update product if single sale
                    if ($this->db->insert('order_products', $data)) {
                        if ($product->product_type == 'digital' && $product->multiple_sale != 1) {
                            $array = array(
                                'is_sold' => 1
                            );
                            $this->db->where('id', $product->id)->update('products', $array);
                        }
                    }
                }
            }
        }
    }

    //add digital sales
    public function add_digital_sales($order_id)
    {
        $order_id = clean_number($order_id);
        $cart_items = $this->session->userdata('mds_shopping_cart_final');
        $order = $this->get_order($order_id);
        if (!empty($cart_items) && $this->auth_check && !empty($order)) {
            foreach ($cart_items as $cart_item) {
                $product = get_active_product($cart_item->product_id);
                if (!empty($product) && $product->product_type == 'digital') {
                    $data_digital = array(
                        'order_id' => $order_id,
                        'product_id' => $product->id,
                        'product_title' => get_product_title($product),
                        'seller_id' => $product->user_id,
                        'buyer_id' => $order->buyer_id,
                        'license_key' => '',
                        'purchase_code' => generate_purchase_code(),
                        'currency' => $product->currency,
                        'price' => $product->price,
                        'purchase_date' => date('Y-m-d H:i:s')
                    );

                    $license_key = $this->product_model->get_unused_license_key($product->id);
                    if (!empty($license_key)) {
                        $data_digital['license_key'] = $license_key->license_key;
                    }

                    $this->db->insert('digital_sales', $data_digital);

                    //set license key as used
                    if (!empty($license_key)) {
                        $this->product_model->set_license_key_used($license_key->id);
                    }
                }
            }
        }
    }

    //add digital sale
    public function add_digital_sale($product_id, $order_id)
    {
        $product_id = clean_number($product_id);
        $order_id = clean_number($order_id);
        $product = get_active_product($product_id);
        $order = $this->get_order($order_id);
        if (!empty($product) && $product->product_type == 'digital' && !empty($order)) {
            $data_digital = array(
                'order_id' => $order_id,
                'product_id' => $product->id,
                'product_title' => get_product_title($product),
                'seller_id' => $product->user_id,
                'buyer_id' => $order->buyer_id,
                'license_key' => '',
                'purchase_code' => generate_purchase_code(),
                'currency' => $product->currency,
                'price' => $product->price,
                'purchase_date' => date('Y-m-d H:i:s')
            );

            $license_key = $this->product_model->get_unused_license_key($product->id);
            if (!empty($license_key)) {
                $data_digital['license_key'] = $license_key->license_key;
            }

            $this->db->insert('digital_sales', $data_digital);

            //set license key as used
            if (!empty($license_key)) {
                $this->product_model->set_license_key_used($license_key->id);
            }
        }
    }

    //add digital sales seller earnings
    public function add_digital_sales_seller_earnings($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                if ($order_product->product_type == 'digital') {
                    $this->earnings_model->add_seller_earnings($order_product);
                }
            }
        }
    }

    //add payment transaction
    public function add_payment_transaction($data_transaction, $order_id)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'payment_method' => $data_transaction["payment_method"],
            'payment_id' => $data_transaction["payment_id"],
            'order_id' => $order_id,
            'user_id' => 0,
            'user_type' => "guest",
            'currency' => $data_transaction["currency"],
            'payment_amount' => $data_transaction["payment_amount"],
            'payment_status' => $data_transaction["payment_status"],
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        if ($this->auth_check) {
            $data["user_id"] = $this->auth_user->id;
            $data["user_type"] = "registered";
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->db->insert('transactions', $data)) {
            //add invoice
            $this->add_invoice($order_id);
        }
    }

    //update order payment as received
    public function update_order_payment_received($order)
    {
        if (!empty($order)) {
            //update product payment status
            $data_order = array(
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', $order_id);
            if ($this->db->update('orders', $data_order)) {
                //update order products payment status
                $order_products = $this->get_order_products($order_id);
                if (!empty($order_products)) {
                    foreach ($order_products as $order_product) {
                        $data = array(
                            'order_status' => "payment_received",
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        $this->db->where('id', $order_product->id);
                        $this->db->update('order_products', $data);
                    }
                }

                //add invoice
                $this->add_invoice($order_id);
            }
        }
    }

    //get orders count
    public function get_orders_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 0);
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated orders
    public function get_paginated_orders($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 0);
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get completed orders count
    public function get_completed_orders_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 1);
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated completed orders
    public function get_paginated_completed_orders($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 1);
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get order products
    public function get_order_products($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('order_products');
        return $query->result();
    }

    //get seller order products
    public function get_seller_order_products($order_id, $seller_id)
    {
        $this->db->where('order_id', clean_number($order_id));
        $this->db->where('seller_id', clean_number($seller_id));
        $query = $this->db->get('order_products');
        return $query->result();
    }

    //get order product
    public function get_order_product($order_product_id)
    {
        $this->db->where('id', clean_number($order_product_id));
        $query = $this->db->get('order_products');
        return $query->row();
    }

    //get order
    public function get_order($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('orders');
        return $query->row();
    }

    //get order by order number
    public function get_order_by_order_number($order_number)
    {
        $this->db->where('order_number', clean_number($order_number));
        $query = $this->db->get('orders');
        return $query->row();
    }

    //update order product status
    public function update_order_product_status($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            if ($order_product->seller_id == $this->auth_user->id) {
                $data = array(
                    'order_status' => $this->input->post('order_status', true),
                    'is_approved' => 0,
                    'shipping_tracking_number' => $this->input->post('shipping_tracking_number', true),
                    'shipping_tracking_url' => $this->input->post('shipping_tracking_url', true),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                if ($order_product->product_type == 'digital' && $data["order_status"] == 'payment_received') {
                    $data['order_status'] = 'completed';
                }

                if ($data["order_status"] == 'shipped') {
                    //send email
                    if ($this->general_settings->send_email_order_shipped == 1) {
                        $email_data = array(
                            'email_type' => 'order_shipped',
                            'order_product_id' => $order_product->id
                        );
                        $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                    }
                }

                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }
        return false;
    }

    //add bank transfer payment report
    public function add_bank_transfer_payment_report()
    {
        $data = array(
            'order_number' => $this->input->post('order_number', true),
            'payment_note' => $this->input->post('payment_note', true),
            'receipt_path' => "",
            'user_id' => 0,
            'user_type' => "guest",
            'status' => "pending",
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        if ($this->auth_check) {
            $data["user_id"] = $this->auth_user->id;
            $data["user_type"] = "registered";
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }

        $this->load->model('upload_model');
        $file_path = $this->upload_model->receipt_upload('file');
        if (!empty($file_path)) {
            $data["receipt_path"] = $file_path;
        }

        return $this->db->insert('bank_transfers', $data);
    }

    //get sales count
    public function get_sales_count($user_id)
    {
        $this->filter_sales();
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->where('order_products.order_status !=', 'completed');
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated sales
    public function get_paginated_sales($user_id, $per_page, $offset)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status !=', 'completed');
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get completed sales count
    public function get_completed_sales_count($user_id)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'completed');
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated completed sales
    public function get_paginated_completed_sales($user_id, $per_page, $offset)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'completed');
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get limited sales by seller
    public function get_limited_sales_by_seller($user_id, $limit)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //filter sales
    public function filter_sales()
    {
        $payment_status = str_slug($this->input->get('payment_status', true));
        $q = str_slug($this->input->get('q', true));

        if (!empty($payment_status) && ($payment_status == "payment_received" || $payment_status == "awaiting_payment")) {
            $this->db->where('orders.payment_status', $payment_status);
        }
        if (!empty($q)) {
            $this->db->where('orders.order_number', $q);
        }
    }

    //get order shipping
    public function get_order_shipping($order_id)
    {
        $this->db->where('order_id', clean_number($order_id));
        $query = $this->db->get('order_shipping');
        return $query->row();
    }

    //check order seller
    public function check_order_seller($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        $result = false;
        if (!empty($order_products)) {
            foreach ($order_products as $product) {
                if ($product->seller_id == $this->auth_user->id) {
                    $result = true;
                }
            }
        }
        return $result;
    }

    //get seller total price
    public function get_seller_total_price($order_id)
    {
        $order_products = $this->get_order_products($order_id);
        $total = 0;
        $seller_shipping = 0;
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                if ($order_product->seller_id == $this->auth_user->id) {
                    $total += $order_product->product_total_price;
                    $seller_shipping = $order_product->seller_shipping_cost;
                }
            }
        }
        return $total + $seller_shipping;
    }

    //approve order product
    public function approve_order_product($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);

        if (!empty($order_product)) {
            if ($this->auth_user->id == $order_product->buyer_id) {
                $data = array(
                    'is_approved' => 1,
                    'order_status' => "completed",
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }

        return false;
    }

    //decrease product stock after sale
    public function decrease_product_stock_after_sale($order_id)
    {
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                $product = $this->product_model->get_product_by_id($order_product->product_id);
                if (!empty($product) && $product->product_type != "digital") {
                    $option_ids = unserialize_data($order_product->variation_option_ids);
                    if (!empty($option_ids)) {
                        foreach ($option_ids as $option_id) {
                            $option = $this->variation_model->get_variation_option($option_id);
                            if (!empty($option)) {
                                if ($option->is_default == 1) {
                                    $stock = $product->stock - $order_product->product_quantity;
                                    if ($stock < 0) {
                                        $stock = 0;
                                    }
                                    $data = array(
                                        'stock' => $stock
                                    );
                                    $this->db->where('id', $product->id);
                                    $this->db->update('products', $data);
                                } else {
                                    $stock = $option->stock - $order_product->product_quantity;
                                    if ($stock < 0) {
                                        $stock = 0;
                                    }
                                    $data = array(
                                        'stock' => $stock
                                    );
                                    $this->db->where('id', $option->id);
                                    $this->db->update('variation_options', $data);
                                }
                            }
                        }
                    } else {
                        $stock = $product->stock - $order_product->product_quantity;
                        if ($stock < 0) {
                            $stock = 0;
                        }
                        $data = array(
                            'stock' => $stock
                        );
                        $this->db->where('id', $product->id);
                        $this->db->update('products', $data);
                    }
                }
            }
        }
    }

    //add invoice
    public function add_invoice($order_id)
    {
        $order = $this->get_order($order_id);
        if (!empty($order)) {
            $invoice = $this->get_invoice_by_order_number($order->order_number);
            if (empty($invoice)) {
                $invoice_items = array();
                $order_products = $this->order_model->get_order_products($order_id);
                if (!empty($order_products)) {
                    foreach ($order_products as $order_product) {
                        $seller = get_user($order_product->seller_id);
                        $item = array(
                            'id' => $order_product->id,
                            'seller' => !empty($seller) ? get_shop_name($seller) : ""
                        );
                        array_push($invoice_items, $item);
                    }
                }
                $client = get_user($order->buyer_id);
                if (!empty($client)) {
                    $country = get_country($client->country_id);
                    $state = get_state($client->state_id);
                    $city = get_city($client->city_id);
                    $data = array(
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'client_username' => $client->username,
                        'client_first_name' => $client->first_name,
                        'client_last_name' => $client->last_name,
                        'client_email' => $client->email,
                        'client_phone_number' => $client->phone_number,
                        'client_address' => $client->address,
                        'client_country' => !empty($country) ? $country->name : '',
                        'client_state' => !empty($state) ? $state->name : '',
                        'client_city' => !empty($city) ? $city->name : '',
                        'invoice_items' => @serialize($invoice_items),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $order_shipping = $this->get_order_shipping($order->id);
                    if (!empty($order_shipping)) {
                        $data['client_first_name'] = $order_shipping->billing_first_name;
                        $data['client_last_name'] = $order_shipping->billing_last_name;
                        $data['client_email'] = $order_shipping->billing_email;
                        $data['client_phone_number'] = $order_shipping->billing_phone_number;
                        $data['client_address'] = $order_shipping->billing_address;
                        $data['client_country'] = $order_shipping->billing_country;
                        $data['client_state'] = $order_shipping->billing_state;
                        $data['client_city'] = $order_shipping->billing_city;
                    }
                    return $this->db->insert('invoices', $data);
                } else {
                    $order_shipping = $this->get_order_shipping($order->id);
                    if (!empty($order_shipping)) {
                        $data['order_id'] = $order->id;
                        $data['order_number'] = $order->order_number;
                        $data['client_username'] = "guest";
                        $data['client_first_name'] = $order_shipping->billing_first_name;
                        $data['client_last_name'] = $order_shipping->billing_last_name;
                        $data['client_email'] = $order_shipping->billing_email;
                        $data['client_phone_number'] = $order_shipping->billing_phone_number;
                        $data['client_address'] = $order_shipping->billing_address;
                        $data['client_country'] = $order_shipping->billing_country;
                        $data['client_state'] = $order_shipping->billing_state;
                        $data['client_city'] = $order_shipping->billing_city;
                        $data['invoice_items'] = @serialize($invoice_items);
                        $data['created_at'] = date('Y-m-d H:i:s');
                        return $this->db->insert('invoices', $data);
                    }
                }
            }
        }
        return false;
    }

    //get invoice
    public function get_invoice($id)
    {
        $this->db->where('id', clean_number($id));
        $query = $this->db->get('invoices');
        return $query->row();
    }

    //get invoice by order number
    public function get_invoice_by_order_number($order_number)
    {
        $this->db->where('order_number', clean_number($order_number));
        $query = $this->db->get('invoices');
        return $query->row();
    }
}
