<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * PAYMENT SETTINGS
    *-------------------------------------------------------------------------------------------------
    */

    /*
    * Payment Settings
    */
    public function payment_settings()
    {
        $data['title'] = trans("payment_settings");
        $data['general_settings'] = $this->settings_model->get_general_settings();
        $data['currencies'] = $this->currency_model->get_currencies();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/payment_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Payment Settings Post
     */
    public function payment_settings_post()
    {
        if ($this->settings_model->update_payment_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_pay", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_pay", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Payment Gateway Settings Post
     */
    public function payment_gateway_settings_post()
    {
        $name_key = $this->input->post('name_key');
        if ($this->settings_model->update_payment_gateway($name_key)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata("mes_" . $name_key, 1);
        redirect($this->agent->referrer());
    }

    /**
     * Bank Transfer Settings Post
     */
    public function bank_transfer_settings_post()
    {
        if ($this->settings_model->update_bank_transfer_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_bank_transfer", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_bank_transfer", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Cash on Delivery Settings Post
     */
    public function cash_on_delivery_settings_post()
    {
        if ($this->settings_model->update_cash_on_delivery_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_cash_on_delivery", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_cash_on_delivery", 1);
            redirect($this->agent->referrer());
        }
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * PRODUCT SETTINGS
    *-------------------------------------------------------------------------------------------------
    */

    /*
    * Product Settings
    */
    public function product_settings()
    {
        $data['title'] = trans("product_settings");
        $data['product_settings'] = $this->settings_model->get_product_settings();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/product_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /*
    * Product Settings Post
    */
    public function product_settings_post()
    {
        $this->settings_model->update_product_settings();
        $this->session->set_flashdata('success', trans("msg_updated"));
        redirect($this->agent->referrer());
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * FONT SETTINGS
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Font Settings
     */
    public function font_settings()
    {
        $data["selected_lang"] = $this->input->get("lang", true);
        if (empty($data["selected_lang"])) {
            $data["selected_lang"] = $this->general_settings->site_lang;
            redirect(admin_url() . "font-settings?lang=" . $data["selected_lang"]);
        }

        $data['title'] = trans("font_settings");
        $data['fonts'] = $this->settings_model->get_fonts();
        $data['settings'] = $this->settings_model->get_settings($data["selected_lang"]);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/font/fonts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Font Post
     */
    public function add_font_post()
    {
        if ($this->settings_model->add_font()) {
            $this->session->set_flashdata('success', trans("msg_added"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('mes_add_font', 1);
        redirect($this->agent->referrer());
    }

    /**
     * Set Site Font Post
     */
    public function set_site_font_post()
    {
        if ($this->settings_model->set_site_font()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('mes_set_font', 1);
        redirect($this->agent->referrer());
    }

    /**
     * Update Font
     */
    public function update_font($id)
    {
        $data['title'] = trans("update_font");
        $data['font'] = $this->settings_model->get_font($id);
        if (empty($data['font'])) {
            redirect(admin_url() . "font-settings");
        }
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/font/update', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update Font Post
     */
    public function update_font_post()
    {
        $id = $this->input->post('id', true);
        if ($this->settings_model->update_font($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('mes_table', 1);
        redirect(admin_url() . "font-settings?lang=" . $this->general_settings->site_lang);
    }

    /**
     * Delete Font Post
     */
    public function delete_font_post()
    {
        $id = $this->input->post('id', true);
        if ($this->settings_model->delete_font($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('mes_table', 1);
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * ROUTE SETTINGS
    *-------------------------------------------------------------------------------------------------
    */

    /*
    * Route Settings
    */
    public function route_settings()
    {
        $data['title'] = trans("route_settings");

        $data['routes'] = $this->settings_model->get_routes();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/route_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Route Settings Post
     */
    public function route_settings_post()
    {
        if ($this->settings_model->update_route_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $route_admin = $this->db->where('route_key', 'admin')->get('routes')->row();
            if (!empty($route_admin)) {
                redirect(base_url() . $route_admin->route . "/route-settings");
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

}
