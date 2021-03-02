<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_model extends CI_Model
{

    //filter transactions
    public function filter_transactions()
    {
        $data = array(
            'q' => $this->input->get('q', true)
        );
        $data['q'] = trim($data['q']);
        if (!empty($data['q'])) {
            $order = $this->order_model->get_order_by_order_number($data['q']);
            if (!empty($order)) {
                $this->db->where('transactions.order_id', $order->id);
            } else {
                $this->db->where('transactions.order_id', 0);
            }
        }
    }

    //get transactions count
    public function get_transactions_count()
    {
        $this->filter_transactions();
        $query = $this->db->get('transactions');
        return $query->num_rows();
    }

    //get paginated transactions
    public function get_paginated_transactions($per_page, $offset)
    {
        $this->filter_transactions();
        $this->db->order_by('transactions.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('transactions');
        return $query->result();
    }

    //get transactions limited
    public function get_transactions_limited($limit)
    {
        $limit = clean_number($limit);
        $this->db->order_by('transactions.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('transactions');
        return $query->result();
    }

    //get transaction
    public function get_transaction($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('transactions');
        return $query->row();
    }

    //get transaction by order id
    public function get_transaction_by_order_id($order_id)
    {
        return $this->db->where('order_id', clean_number($order_id))->get('transactions')->row();
    }

    //delete transaction
    public function delete_transaction($id)
    {
        $id = clean_number($id);
        $transaction = $this->get_transaction($id);
        if (!empty($transaction)) {
            $this->db->where('id', $id);
            return $this->db->delete('transactions');
        }
        return false;
    }

    //get latest promoted transactions
    public function get_latest_promoted_transactions($limit)
    {
        $limit = clean_number($limit);
        $this->db->order_by('promoted_transactions.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('promoted_transactions');
        return $query->result();
    }

    //get promoted transactions limited
    public function get_promoted_transactions_limited($limit)
    {
        $limit = clean_number($limit);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('promoted_transactions');
        return $query->result();
    }

    //get promoted transaction
    public function get_promoted_transaction($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('promoted_transactions');
        return $query->row();
    }

    //delete promoted transaction
    public function delete_promoted_transaction($id)
    {
        $id = clean_number($id);
        $transaction = $this->get_promoted_transaction($id);
        if (!empty($transaction)) {
            $this->db->where('id', $id);
            return $this->db->delete('promoted_transactions');
        }
        return false;
    }
}