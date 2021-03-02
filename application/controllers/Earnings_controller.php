<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Earnings_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }

    /**
     * Earnings
     */
    public function earnings()
    {
        $data['title'] = trans("earnings");
        $data['form_action'] = admin_url() . "earnings";

        //get paginated earnings
        $pagination = $this->paginate(admin_url() . 'earnings', $this->earnings_admin_model->get_earnings_count());
        $data['earnings'] = $this->earnings_admin_model->get_paginated_earnings($pagination['per_page'], $pagination['offset']);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/earnings/earnings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Earnings Post
     */
    public function delete_earning_post()
    {
        $id = $this->input->post('id', true);
        if ($this->earnings_admin_model->delete_earning($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Seller Balances
     */
    public function seller_balances()
    {
        $data['title'] = trans("seller_balances");
        $data['form_action'] = admin_url() . "seller-balances";
        //get paginated earnings
        $pagination = $this->paginate(admin_url() . 'seller-balances', $this->earnings_admin_model->get_users_count());
        $data['balances'] = $this->earnings_admin_model->get_paginated_users($pagination['per_page'], $pagination['offset']);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/earnings/seller_balances', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update Seller Balance
     */
    public function update_seller_balance($id)
    {
        $data['title'] = trans("update_seller_balance");
        $data['seller'] = $this->auth_model->get_user($id);

        if (empty($data['seller'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/earnings/update_seller_balance', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update Seller Balance Post
     */
    public function update_seller_balance_post()
    {
        if ($this->earnings_admin_model->update_seller_balance()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Completed Payouts
     */
    public function completed_payouts()
    {
        $data['title'] = trans("completed_payouts");
        $data['form_action'] = admin_url() . "completed-payouts";
        //get paginated earnings
        $pagination = $this->paginate(admin_url() . 'completed-payouts', $this->earnings_admin_model->get_completed_payouts_count());
        $data['payouts'] = $this->earnings_admin_model->get_paginated_completed_payouts($pagination['per_page'], $pagination['offset']);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/earnings/completed_payouts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Payout Requests
     */
    public function payout_requests()
    {
        $data['title'] = trans("payout_requests");
        $data['form_action'] = admin_url() . "payout-requests";
        //get paginated earnings
        $pagination = $this->paginate(admin_url() . 'payout-requests', $this->earnings_admin_model->get_payout_requests_count());
        $data['payout_requests'] = $this->earnings_admin_model->get_paginated_payout_requests($pagination['per_page'], $pagination['offset']);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/earnings/payout_requests', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Payout
     */
    public function add_payout()
    {
        $data['title'] = trans("add_payout");
        $data['form_action'] = admin_url() . "add_payout";
        $data['users'] = $this->auth_model->get_users();
        $data['currencies'] = $this->currency_model->get_currencies();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/earnings/add_payout', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Payout Post
     */
    public function add_payout_post()
    {
        $user_id = $this->input->post('user_id', true);
        $amount = $this->input->post('amount', true);
        $amount = get_price($amount, 'database');

        //check user balance
        if (!$this->earnings_admin_model->check_user_balance($user_id, $amount)) {
            $this->session->set_flashdata('error', trans("msg_insufficient_balance"));
            redirect($this->agent->referrer());
        } else {
            if ($this->earnings_admin_model->add_payout($user_id, $amount)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Payout Settings
     */
    public function payout_settings()
    {
        $data['title'] = trans("payout_settings");
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/earnings/payout_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Payout Paypal Settings Post
     */
    public function payout_paypal_settings_post()
    {
        if ($this->earnings_admin_model->update_paypal_payout_settings()) {
            $this->session->set_flashdata('msg_paypal', 1);
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_paypal', 1);
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Payout Iban Settings Post
     */
    public function payout_iban_settings_post()
    {
        if ($this->earnings_admin_model->update_iban_payout_settings()) {
            $this->session->set_flashdata('msg_iban', 1);
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_iban', 1);
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Payout Swift Settings Post
     */
    public function payout_swift_settings_post()
    {
        if ($this->earnings_admin_model->update_swift_payout_settings()) {
            $this->session->set_flashdata('msg_swift', 1);
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_swift', 1);
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Complete Payout Request Post
     */
    public function complete_payout_request_post()
    {
        $payout_id = $this->input->post('payout_id', true);
        $user_id = $this->input->post('user_id', true);
        $amount = $this->input->post('amount', true);

        //check user balance
        if (!$this->earnings_admin_model->check_user_balance($user_id, $amount)) {
            $this->session->set_flashdata('error', trans("msg_insufficient_balance"));
            redirect($this->agent->referrer());
        } else {
            if ($this->earnings_admin_model->complete_payout($payout_id, $user_id, $amount)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Delete Payout Post
     */
    public function delete_payout_post()
    {
        $id = $this->input->post('id', true);
        if ($this->earnings_admin_model->delete_payout($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

}