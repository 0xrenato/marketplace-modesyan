<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common_controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Admin Login
     */
    public function admin_login()
    {
        if ($this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("login");
        $data['description'] = trans("login") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("login") . ', ' . $this->general_settings->application_name;
        $this->load->view('admin/login', $data);
    }

    /**
     * Admin Login Post
     */
    public function admin_login_post()
    {
        //validate inputs
        $this->form_validation->set_rules('email', trans("form_email"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("form_password"), 'required|xss_clean|max_length[30]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->auth_model->login()) {
                redirect(admin_url());
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("login_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $this->auth_model->logout();
        redirect($this->agent->referrer());
    }

    /**
     * Invoice
     */
    public function invoice($order_number)
    {
        $data['title'] = trans("invoice");
        $data['description'] = trans("invoice") . " - " . $this->app_name;
        $data['keywords'] = trans("invoice") . "," . $this->app_name;

        $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        if (empty($data["order"])) {
            redirect(lang_base_url());
        }
        $data["invoice"] = $this->order_model->get_invoice_by_order_number($order_number);
        if (empty($data["invoice"])) {
            $this->order_model->add_invoice($data["order"]->id);
        }
        if (empty($data["invoice"])) {
            redirect(lang_base_url());
        }

        $data["invoice_items"] = unserialize_data($data["invoice"]->invoice_items);
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);

        //check permission
        if ($this->auth_user->role != "admin") {
            $is_seller = false;
            if (!empty($data["order_products"])) {
                foreach ($data["order_products"] as $item) {
                    if ($item->seller_id == $this->auth_user->id) {
                        $is_seller = true;
                    }
                }
            }
            if ($this->auth_user->id != $data["order"]->buyer_id && $is_seller == false) {
                redirect(lang_base_url());
                exit();
            }
        }

        $this->load->view('invoice/invoice', $data);
    }

    /**
     * Invoice Membership
     */
    public function invoice_membership($id)
    {
        $data['title'] = trans("invoice");
        $data['description'] = trans("invoice") . " - " . $this->app_name;
        $data['keywords'] = trans("invoice") . "," . $this->app_name;

        if (!$this->auth_check) {
            redirect(lang_base_url());
            exit();
        }
        $data["transaction"] = $this->membership_model->get_membership_transaction($id);
        if (empty($data["transaction"])) {
            redirect(lang_base_url());
            exit();
        }
        if ($this->auth_user->role != "admin") {
            if ($this->auth_user->id != $data["transaction"]->user_id) {
                redirect(lang_base_url());
                exit();
            }
        }
        $data["user"] = get_user($data["transaction"]->user_id);
        if (empty($data["user"])) {
            redirect(lang_base_url());
            exit();
        }

        $this->load->view('invoice/invoice_membership', $data);
    }

    /**
     * Invoice Promotion
     */
    public function invoice_promotion($id)
    {
        $data['title'] = trans("invoice");
        $data['description'] = trans("invoice") . " - " . $this->app_name;
        $data['keywords'] = trans("invoice") . "," . $this->app_name;

        if (!$this->auth_check) {
            redirect(lang_base_url());
            exit();
        }
        $data["transaction"] = $this->promote_model->get_promotion_transaction($id);
        if (empty($data["transaction"])) {
            redirect(lang_base_url());
            exit();
        }
        if ($this->auth_user->role != "admin") {
            if ($this->auth_user->id != $data["transaction"]->user_id) {
                redirect(lang_base_url());
                exit();
            }
        }
        $data["user"] = get_user($data["transaction"]->user_id);
        if (empty($data["user"])) {
            redirect(lang_base_url());
            exit();
        }

        $this->load->view('invoice/invoice_promotion', $data);
    }
}
