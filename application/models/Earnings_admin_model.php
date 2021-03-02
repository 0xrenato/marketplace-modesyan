<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Earnings_admin_model extends CI_Model
{
    //filter earnings
    public function filter_earnings()
    {
        $data = array(
            'q' => $this->input->get('q', true)
        );
        $data['q'] = trim($data['q']);
        if (!empty($data['q'])) {
            $data['q'] = str_replace("#", "", $data['q']);
            $this->db->where('earnings.order_number', $data['q']);
        }
    }

    //get earnings count
    public function get_earnings_count()
    {
        $this->filter_earnings();
        $query = $this->db->get('earnings');
        return $query->num_rows();
    }

    //get paginated earnings
    public function get_paginated_earnings($per_page, $offset)
    {
        $this->filter_earnings();
        $this->db->order_by('earnings.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('earnings');
        return $query->result();
    }

    //filter seller balances
    public function filter_seller_balances()
    {
        $data = array(
            'q' => $this->input->get('q', true)
        );
        $data['q'] = trim($data['q']);
        if (!empty($data['q'])) {
            $this->db->where('users.username', $data['q']);
        }
    }

    //get users count
    public function get_users_count()
    {
        $this->filter_seller_balances();
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    //get paginated users
    public function get_paginated_users($per_page, $offset)
    {
        $this->filter_seller_balances();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('users');
        return $query->result();
    }

    //delete earning
    public function delete_earning($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('earnings');
        $row = $query->row();

        if (!empty($row)) {
            $this->db->where('id', $id);
            return $this->db->delete('earnings');
        } else {
            return false;
        }
    }

    //filter payouts
    public function filter_payouts()
    {
        $data = array(
            'q' => $this->input->get('q', true)
        );
        $data['q'] = trim($data['q']);
        if (!empty($data['q'])) {
            $this->db->where('payouts.user_id', $data['q']);
        }
    }

    //get completed payouts count
    public function get_completed_payouts_count()
    {
        $this->filter_payouts();
        $this->db->where('payouts.status', 1);
        $query = $this->db->get('payouts');
        return $query->num_rows();
    }

    //get paginated completed payouts
    public function get_paginated_completed_payouts($per_page, $offset)
    {
        $this->filter_payouts();
        $this->db->where('payouts.status', 1);
        $this->db->order_by('payouts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('payouts');
        return $query->result();
    }

    //get payout requests count
    public function get_payout_requests_count()
    {
        $this->filter_payouts();
        $this->db->where('payouts.status', 0);
        $query = $this->db->get('payouts');
        return $query->num_rows();
    }

    //get paginated payout requests
    public function get_paginated_payout_requests($per_page, $offset)
    {
        $this->filter_payouts();
        $this->db->where('payouts.status', 0);
        $this->db->order_by('payouts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('payouts');
        return $query->result();
    }

    //add payout
    public function add_payout($user_id, $amount)
    {
        $user_id = clean_number($user_id);
        $data = array(
            'user_id' => $user_id,
            'payout_method' => $this->input->post('payout_method', true),
            'amount' => $amount,
            'currency' => $this->payment_settings->default_currency,
            'status' => $this->input->post('status', true),
            'created_at' => date('Y-m-d H:i:s')
        );

        if ($data['status'] == 1) {
            if ($this->db->insert('payouts', $data)) {
                return $this->reduce_user_balance($user_id, $amount);
            }
        } else {
            return $this->db->insert('payouts', $data);

        }
        return false;
    }

    //complete payout
    public function complete_payout($payout_id, $user_id, $amount)
    {
        $payout_id = clean_number($payout_id);
        $user_id = clean_number($user_id);
        $data = array(
            'status' => 1
        );

        $this->db->where('id', $payout_id);
        $update = $this->db->update('payouts', $data);
        if ($update) {
            return $this->reduce_user_balance($user_id, $amount);
        }

        return false;
    }

    //check user balance
    public function check_user_balance($user_id, $amount)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            if ($user->balance >= $amount) {
                return true;
            }
        }
        return false;
    }

    //reduce user balance
    public function reduce_user_balance($user_id, $amount)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            $balance = $user->balance - $amount;
            $data = array(
                'balance' => $balance
            );
            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
        return false;
    }

    //update user balance
    public function update_seller_balance()
    {
        $user_id = $this->input->post('user_id', true);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            $data = array(
                'number_of_sales' => $this->input->post('number_of_sales', true),
                'balance' => $this->input->post('balance', true)
            );

            $data["balance"] = get_price($data["balance"], 'database');

            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
        return false;
    }

    //update paypal payout settings
    public function update_paypal_payout_settings()
    {
        $data = array(
            'payout_paypal_enabled' => $this->input->post('payout_paypal_enabled', true),
            'min_payout_paypal' => $this->input->post('min_payout_paypal', true)
        );
        $data["min_payout_paypal"] = get_price($data["min_payout_paypal"], 'database');
        $this->db->where('id', 1);
        return $this->db->update('payment_settings', $data);
    }

    //update iban payout settings
    public function update_iban_payout_settings()
    {
        $data = array(
            'payout_iban_enabled' => $this->input->post('payout_iban_enabled', true),
            'min_payout_iban' => $this->input->post('min_payout_iban', true)
        );
        $data["min_payout_iban"] = get_price($data["min_payout_iban"], 'database');
        $this->db->where('id', 1);
        return $this->db->update('payment_settings', $data);
    }

    //update swift payout settings
    public function update_swift_payout_settings()
    {
        $data = array(
            'payout_swift_enabled' => $this->input->post('payout_swift_enabled', true),
            'min_payout_swift' => $this->input->post('min_payout_swift', true)
        );
        $data["min_payout_swift"] = get_price($data["min_payout_swift"], 'database');
        $this->db->where('id', 1);
        return $this->db->update('payment_settings', $data);
    }

    //delete payout
    public function delete_payout($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('payouts');
        $row = $query->row();

        if (!empty($row)) {
            $this->db->where('id', $id);
            return $this->db->delete('payouts');
        } else {
            return false;
        }
    }
}