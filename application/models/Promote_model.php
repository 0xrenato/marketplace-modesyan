<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promote_model extends CI_Model
{
    //add promote transaction
    public function add_promote_transaction($data_transaction)
    {
        $promoted_plan = $this->session->userdata('modesy_selected_promoted_plan');
        $data = array(
            'payment_method' => $data_transaction["payment_method"],
            'payment_id' => $data_transaction["payment_id"],
            'user_id' => $this->auth_user->id,
            'product_id' => $promoted_plan->product_id,
            'currency' => $data_transaction["currency"],
            'payment_amount' => $data_transaction["payment_amount"],
            'payment_status' => $data_transaction["payment_status"],
            'purchased_plan' => $promoted_plan->purchased_plan,
            'day_count' => $promoted_plan->day_count,
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        $this->db->insert('promoted_transactions', $data);
        $this->session->set_userdata('mds_promoted_transaction_insert_id', $this->db->insert_id());
    }

    //add promote transaction bank
    public function add_promote_transaction_bank($promoted_plan, $transaction_number)
    {
        $data = array(
            'payment_method' => "Bank Transfer",
            'payment_id' => $transaction_number,
            'user_id' => $this->auth_user->id,
            'product_id' => $promoted_plan->product_id,
            'currency' => $this->payment_settings->default_currency,
            'payment_amount' => get_price($promoted_plan->total_amount, 'decimal'),
            'payment_status' => "awaiting_payment",
            'purchased_plan' => $promoted_plan->purchased_plan,
            'day_count' => $promoted_plan->day_count,
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        $this->db->insert('promoted_transactions', $data);
        $this->session->set_userdata('mds_promoted_transaction_insert_id', $this->db->insert_id());
    }

    //add to promoted products
    public function add_to_promoted_products($promoted_plan)
    {
        $product = $this->product_model->get_product_by_id($promoted_plan->product_id);
        if (!empty($product)) {
            //set dates
            $date = date('Y-m-d H:i:s');
            $end_date = date('Y-m-d H:i:s', strtotime($date . ' + ' . $promoted_plan->day_count . ' days'));
            $data = array(
                'promote_plan' => $promoted_plan->purchased_plan,
                'promote_day' => $promoted_plan->day_count,
                'is_promoted' => 1,
                'promote_start_date' => $date,
                'promote_end_date' => $end_date
            );
            $this->db->where('id', $promoted_plan->product_id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    //get paginated promoted transactions
    public function get_paginated_promoted_transactions($user_id, $per_page, $offset)
    {
        if (!empty($user_id)) {
            $this->db->where('user_id', clean_number($user_id));
        }
        $this->filter_promoted_transactions();
        $this->db->order_by('promoted_transactions.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('promoted_transactions');
        return $query->result();
    }

    //get promoted transactions count
    public function get_promoted_transactions_count($user_id)
    {
        if (!empty($user_id)) {
            $this->db->where('user_id', clean_number($user_id));
        }
        $this->filter_promoted_transactions();
        $query = $this->db->get('promoted_transactions');
        return $query->num_rows();
    }

    //filter promoted transactions
    public function filter_promoted_transactions()
    {
        $data = array(
            'q' => $this->input->get('q', true)
        );
        $data['q'] = trim($data['q']);
        if (!empty($data['q'])) {
            $this->db->where('promoted_transactions.payment_id', $data['q']);
        }
    }

    //get promotion transaction
    public function get_promotion_transaction($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->get('promoted_transactions')->row();
    }

}
