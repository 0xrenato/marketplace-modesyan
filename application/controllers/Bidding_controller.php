<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bidding_controller extends Home_Core_Controller
{
    /**
     * Bidding Status
     *
     * 1. new_quote_request
     * 2. pending_quote
     * 3. pending_payment
     * 4. rejected_quote
     * 5. closed
     * 6. completed
     */

    public function __construct()
    {
        parent::__construct();
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (!is_bidding_system_active()) {
            redirect(lang_base_url());
        }
        $this->load->model('bidding_model');
        $this->rows_per_page = 15;
    }

    /**
     * Request Quote
     */
    public function request_quote()
    {
        $product_id = $this->input->post('product_id', true);
        $product = $this->product_model->get_active_product($product_id);
        if (!empty($product)) {
            if ($product->user_id == $this->auth_user->id) {
                $this->session->set_flashdata('product_details_error', trans("msg_quote_request_error"));
                redirect($this->agent->referrer());
                exit();
            }

            $this->db->where('product_id', clean_number($product_id))->where('buyer_id', $this->auth_user->id)->where('status', 'new_quote_request');
            $request = $this->db->get('quote_requests')->row();
            if (!empty($request)) {
                $this->session->set_flashdata('product_details_error', trans("already_have_active_request"));
                redirect($this->agent->referrer());
                exit();
            }
            
            $quote_id = $this->bidding_model->request_quote($product);
            if ($quote_id) {
                //send email
                $seller = get_user($product->user_id);
                if (!empty($seller) && $this->general_settings->send_email_bidding_system == 1) {
                    $email_data = array(
                        'email_type' => 'email_general',
                        'to' => $seller->email,
                        'subject' => trans("quote_request"),
                        'email_content' => trans("you_have_new_quote_request") . "<br>" . trans("quote") . ": " . "<strong>#" . $quote_id . "</strong>",
                        'email_link' => generate_dash_url("quote_requests"),
                        'email_button_text' => trans("view_details")
                    );
                    $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                }
            }
            $this->session->set_flashdata('product_details_success', trans("msg_quote_request_sent"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Accept Quote
     */
    public function accept_quote()
    {
        $id = $this->input->post('id', true);
        $quote_request = $this->bidding_model->get_quote_request($id);
        if ($this->bidding_model->accept_quote($quote_request)) {
            //send email
            $seller = get_user($quote_request->seller_id);
            if (!empty($seller) && $this->general_settings->send_email_bidding_system == 1) {
                $email_data = array(
                    'email_type' => 'email_general',
                    'to' => $seller->email,
                    'subject' => trans("quote_request"),
                    'email_content' => trans("your_quote_accepted") . "<br>" . trans("quote") . ": " . "<strong>#" . $quote_request->id . "</strong>",
                    'email_link' => generate_dash_url("quote_requests"),
                    'email_button_text' => trans("view_details")
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Reject Quote
     */
    public function reject_quote()
    {
        $id = $this->input->post('id', true);
        $quote_request = $this->bidding_model->get_quote_request($id);
        if ($this->bidding_model->reject_quote($quote_request)) {
            //send email
            $seller = get_user($quote_request->seller_id);
            if (!empty($seller) && $this->general_settings->send_email_bidding_system == 1) {
                $email_data = array(
                    'email_type' => 'email_general',
                    'to' => $seller->email,
                    'subject' => trans("quote_request"),
                    'email_content' => trans("your_quote_rejected") . "<br>" . trans("quote") . ": " . "<strong>#" . $quote_request->id . "</strong>",
                    'email_link' => generate_dash_url("quote_requests"),
                    'email_button_text' => trans("view_details")
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Quote Requests
     */
    public function quote_requests()
    {
        $data["user"] = $this->auth_user;
        $data['title'] = trans("quote_requests");
        $data['description'] = trans("quote_requests") . " - " . $this->app_name;
        $data['keywords'] = trans("quote_requests") . "," . $this->app_name;
        
        $data['num_rows'] = $this->bidding_model->get_quote_requests_count($this->auth_user->id);
        $pagination = $this->paginate(generate_url("quote_requests"), $data['num_rows'], $this->rows_per_page);
        $data['quote_requests'] = $this->bidding_model->get_paginated_quote_requests($this->auth_user->id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('bidding/quote_requests', $data);
        $this->load->view('partials/_footer');

    }


    /**
     * Delete Quote Request
     */
    public function delete_quote_request()
    {
        $id = $this->input->post('id', true);
        $this->bidding_model->delete_quote_request($id);
        $this->bidding_model->delete_quote_request_if_both_deleted($id);
    }
}
