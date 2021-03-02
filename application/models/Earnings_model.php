<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Earnings_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //get paginated earnings
    public function get_paginated_earnings($user_id, $per_page, $offset)
    {
        $this->db->where('user_id', clean_number($user_id));
        $this->filter_earnings();
        $this->db->order_by('earnings.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('earnings');
        return $query->result();
    }

    //get earnings count
    public function get_earnings_count($user_id)
    {
        $this->db->where('user_id', clean_number($user_id));
        $this->filter_earnings();
        return $this->db->count_all_results('earnings');
    }

    //filter earnings
    public function filter_earnings()
    {
        $q = input_get('q');
        if (!empty($q)) {
            $this->db->like('earnings.order_number', $q);
        }
    }

    //add seller earnings
    public function add_seller_earnings($order_product)
    {
        if (!empty($order_product)) {
            $order = $this->order_model->get_order($order_product->order_id);
            if (!empty($order)) {
                //check if earning already added
                $this->db->where('order_number', $order->order_number);
                $this->db->where('order_product_id', $order_product->id);
                $this->db->where('user_id', $order_product->seller_id);
                $query = $this->db->get('earnings');
                $num_rows = $query->num_rows();
                if ($num_rows < 1) {
                    $earned_amount = $this->calculate_earned_amount($order_product);
                    $shipping_cost = $this->get_single_product_shipping_cost($order_product->order_id, $order_product->seller_id);
                    //add earning
                    $data = array(
                        'order_number' => $order->order_number,
                        'order_product_id' => $order_product->id,
                        'user_id' => $order_product->seller_id,
                        'price' => $order_product->product_total_price,
                        'commission_rate' => $order_product->commission_rate,
                        'shipping_cost' => $shipping_cost,
                        'earned_amount' => $earned_amount + $shipping_cost,
                        'currency' => $order_product->product_currency,
                        'exchange_rate' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    );

                    $total_earned = $data['earned_amount'];
                    $product_currency = $this->currency_model->get_currency_by_code($order_product->product_currency);
                    if (!empty($product_currency) && $this->payment_settings->currency_converter == 1 && $product_currency->exchange_rate > 0) {
                        $data['exchange_rate'] = $product_currency->exchange_rate;
                        $total_earned = get_price($total_earned, 'decimal');
                        $total_earned = $total_earned / $data['exchange_rate'];
                        $total_earned = number_format($total_earned, 2, ".", "");
                        $total_earned = get_price($total_earned, 'database');
                    }
                    $this->db->insert('earnings', $data);
                    //update seller balance and number of sales
                    $user = get_user($order_product->seller_id);
                    if (!empty($user)) {
                        $new_balance = $user->balance;
                        if ($order->payment_method != "Cash On Delivery") {
                            $new_balance = $user->balance + $total_earned;
                        }
                        $sales = $user->number_of_sales;
                        $sales = $sales + 1;
                        $data = array(
                            'balance' => $new_balance,
                            'number_of_sales' => $sales
                        );
                        $this->db->where('id', $user->id);
                        $this->db->update('users', $data);
                    }
                }
            }
        }
    }

    //remove seller earnings
    public function remove_seller_earnings($order_product)
    {
        if (!empty($order_product)) {
            $earned_amount = $this->calculate_earned_amount($order_product);
            $this->db->where('order_product_id', $order_product->id);
            $this->db->where('user_id', $order_product->seller_id);
            $this->db->delete('earnings');

            //update seller balance and number of sales
            $user = get_user($order_product->seller_id);
            if (!empty($user)) {
                $balance = $user->balance;
                $new_balance = $balance - $earned_amount;
                $sales = $user->number_of_sales;
                $sales = $sales - 1;
                $data = array(
                    'balance' => $new_balance,
                    'number_of_sales' => $sales
                );
                $this->db->where('id', $user->id);
                $this->db->update('users', $data);
            }
        }
    }

    //calculate earned amount
    public function calculate_earned_amount($order_product)
    {
        if (!empty($order_product)) {
            $price = $order_product->product_total_price;
            $earned = $price - (($price * $order_product->commission_rate) / 100);
            return $earned;
        }
        return 0;
    }

    //get single product shipping cost
    public function get_single_product_shipping_cost($order_id, $seller_id)
    {
        $num_products = 0;
        $seller_shipping_cost = 0;
        $order_products = $this->order_model->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $product) {
                if ($product->seller_id == $seller_id) {
                    $num_products += 1;
                    $seller_shipping_cost = $product->seller_shipping_cost;
                }
            }
        }
        if (!empty($num_products)) {
            $cost = $seller_shipping_cost / $num_products;
            return number_format($cost, 2, ".", "");
        }
        return 0;
    }

    //get order earning by user id
    public function get_earning_by_user_id($user_id, $order_number)
    {
        $this->db->where('order_number', $order_number);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('earnings');
        return $query->row();
    }

    //get user payout account
    public function get_user_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('users_payout_accounts');
        $row = $query->row();

        if (!empty($row)) {
            return $row;
        } else {
            $data = array(
                'user_id' => $user_id,
                'payout_paypal_email' => "",
                'iban_full_name' => "",
                'iban_country_id' => "",
                'iban_bank_name' => "",
                'iban_number' => "",
                'swift_full_name' => "",
                'swift_address' => "",
                'swift_state' => "",
                'swift_city' => "",
                'swift_postcode' => "",
                'swift_country_id' => "",
                'swift_bank_account_holder_name' => "",
                'swift_iban' => "",
                'swift_code' => "",
                'swift_bank_name' => "",
                'swift_bank_branch_city' => "",
                'swift_bank_branch_country_id' => ""
            );
            $this->db->insert('users_payout_accounts', $data);

            $this->db->where('user_id', $user_id);
            $query = $this->db->get('users_payout_accounts');
            return $query->row();
        }
    }

    //set paypal payout account
    public function set_paypal_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $data = array(
            'payout_paypal_email' => $this->input->post('payout_paypal_email', true)
        );
        $this->db->where('user_id', $user_id);
        return $this->db->update('users_payout_accounts', $data);
    }

    //set iban payout account
    public function set_iban_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $data = array(
            'iban_full_name' => $this->input->post('iban_full_name', true),
            'iban_country_id' => $this->input->post('iban_country_id', true),
            'iban_bank_name' => $this->input->post('iban_bank_name', true),
            'iban_number' => $this->input->post('iban_number', true),
        );
        $this->db->where('user_id', $user_id);
        return $this->db->update('users_payout_accounts', $data);
    }

    //set swift payout account
    public function set_swift_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $data = array(
            'swift_full_name' => $this->input->post('swift_full_name', true),
            'swift_address' => $this->input->post('swift_address', true),
            'swift_state' => $this->input->post('swift_state', true),
            'swift_city' => $this->input->post('swift_city', true),
            'swift_postcode' => $this->input->post('swift_postcode', true),
            'swift_country_id' => $this->input->post('swift_country_id', true),
            'swift_bank_account_holder_name' => $this->input->post('swift_bank_account_holder_name', true),
            'swift_iban' => $this->input->post('swift_iban', true),
            'swift_code' => $this->input->post('swift_code', true),
            'swift_bank_name' => $this->input->post('swift_bank_name', true),
            'swift_bank_branch_city' => $this->input->post('swift_bank_branch_city', true),
            'swift_bank_branch_country_id' => $this->input->post('swift_bank_branch_country_id', true)
        );
        $this->db->where('user_id', $user_id);
        return $this->db->update('users_payout_accounts', $data);
    }

    //get paginated payouts
    public function get_paginated_payouts($user_id, $per_page, $offset)
    {
        $this->db->where('user_id', clean_number($user_id));
        $this->db->order_by('payouts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('payouts');
        return $query->result();
    }

    //get payouts count
    public function get_payouts_count($user_id)
    {
        $this->db->where('user_id', clean_number($user_id));
        return $this->db->count_all_results('payouts');
    }

    //get active payouts
    public function get_active_payouts($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 0);
        $this->db->order_by('payouts.created_at', 'DESC');
        $query = $this->db->get('payouts');
        return $query->result();
    }

    //withdraw money
    public function withdraw_money($data)
    {
        return $this->db->insert('payouts', $data);
    }
}
