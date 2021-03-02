<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (!$this->is_sale_active) {
            redirect(lang_base_url());
        }
        $this->order_per_page = 15;
        $this->earnings_per_page = 15;
        $this->user_id = $this->auth_user->id;
    }

    /**
     * Orders
     */
    public function orders()
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "active_orders";
        $pagination = $this->paginate(generate_url("orders"), $this->order_model->get_orders_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_orders($this->user_id, $pagination['per_page'], $pagination['offset']);
        
        $this->load->view('partials/_header', $data);
        $this->load->view('order/orders', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Completed Orders
     */
    public function completed_orders()
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "completed_orders";
        $pagination = $this->paginate(generate_url("orders", "completed_orders"), $this->order_model->get_completed_orders_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_completed_orders($this->user_id, $pagination['per_page'], $pagination['offset']);
        
        $this->load->view('partials/_header', $data);
        $this->load->view('order/orders', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Order
     */
    public function order($order_number)
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "";

        $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        if (empty($data["order"])) {
            redirect(lang_base_url());
        }
        if ($data["order"]->buyer_id != $this->user_id) {
            redirect(lang_base_url());
        }
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $data["last_bank_transfer"] = $this->order_admin_model->get_bank_transfer_by_order_number($data["order"]->order_number);
        
        $this->load->view('partials/_header', $data);
        $this->load->view('order/order', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Bank Transfer Payment Report Post
     */
    public function bank_transfer_payment_report_post()
    {
        $this->order_model->add_bank_transfer_payment_report();
        redirect($this->agent->referrer());
    }


    /**
     * Approve Order Product
     */
    public function approve_order_product_post()
    {
        $order_id = $this->input->post('order_product_id', true);
        $order_product_id = $this->input->post('order_product_id', true);
        if ($this->order_model->approve_order_product($order_product_id)) {
            //order product
            $order_product = $this->order_model->get_order_product($order_product_id);
            //add seller earnings
            $this->earnings_model->add_seller_earnings($order_product);
            //update order status
            $this->order_admin_model->update_order_status_if_completed($order_product->order_id);
        }
    }
}
