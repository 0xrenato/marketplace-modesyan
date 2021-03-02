<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bidding_model extends CI_Model
{
    //request quote
    public function request_quote($product)
    {
        $quantity = $this->input->post('product_quantity', true);
        if (empty($quantity)) {
            $quantity = 1;
        }
        $appended_variations = $this->cart_model->get_selected_variations($product->id)->str;
        $data = array(
            'product_id' => $product->id,
            'product_title' => get_product_title($product) . " " . $appended_variations,
            'product_quantity' => $quantity,
            'seller_id' => $product->user_id,
            'buyer_id' => $this->auth_user->id,
            'status' => 'new_quote_request',
            'price_offered' => 0,
            'price_currency' => '',
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        );
        if ($this->db->insert('quote_requests', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    //submit quote
    public function submit_quote($quote_request)
    {
        if (!empty($quote_request) && $this->auth_user->id == $quote_request->seller_id) {
            $data = array(
                'price_offered' => $this->input->post('price', true),
                'price_currency' => $this->input->post('currency', true),
                'status' => "pending_quote",
                'updated_at' => date('Y-m-d H:i:s')
            );
            $data["price_offered"] = get_price($data["price_offered"], 'database');
            if (empty($data["price_offered"])) {
                $data["price_offered"] = 0;
            }
            $this->db->where('id', $quote_request->id);
            return $this->db->update('quote_requests', $data);
        }
        return false;
    }

    //accept quote
    public function accept_quote($quote_request)
    {
        if (!empty($quote_request) && $this->auth_user->id == $quote_request->buyer_id) {
            $data = array(
                'status' => "pending_payment",
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', $quote_request->id);
            return $this->db->update('quote_requests', $data);
        }
    }

    //reject quote
    public function reject_quote($quote_request)
    {
        if (!empty($quote_request) && $this->auth_user->id == $quote_request->buyer_id) {
            $data = array(
                'status' => "rejected_quote",
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', $quote_request->id);
            return $this->db->update('quote_requests', $data);
        }
    }

    //get quote request
    public function get_quote_request($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('quote_requests');
        return $query->row();
    }

    //get paginated quote requests
    public function get_paginated_quote_requests($user_id, $per_page, $offset)
    {
        $this->db->select('quote_requests.*');
        $this->db->join('products', 'quote_requests.product_id = products.id');
        if ($this->general_settings->membership_plans_system == 1) {
            $this->db->join('users', 'quote_requests.seller_id = users.id AND users.banned = 0 AND users.is_membership_plan_expired = 0');
        }
        $this->db->where('products.status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->where("((products.product_type = 'physical' AND products.stock > 0) OR products.product_type = 'digital')");
        $this->db->where('quote_requests.buyer_id', clean_number($user_id))->where('quote_requests.is_buyer_deleted', 0);
        $this->db->order_by('updated_at', 'DESC')->limit($per_page, $offset);
        return $this->db->get('quote_requests')->result();
    }

    //get quote requests count
    public function get_quote_requests_count($user_id)
    {
        $this->db->join('products', 'quote_requests.product_id = products.id');
        if ($this->general_settings->membership_plans_system == 1) {
            $this->db->join('users', 'quote_requests.seller_id = users.id AND users.banned = 0 AND users.is_membership_plan_expired = 0');
        }
        $this->db->where('products.status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->where("((products.product_type = 'physical' AND products.stock > 0) OR products.product_type = 'digital')");
        $this->db->where('quote_requests.buyer_id', clean_number($user_id))->where('quote_requests.is_buyer_deleted', 0);
        return $this->db->count_all_results('quote_requests');
    }

    //get vendor paginated quote requests
    public function get_paginated_vendor_quote_requests($user_id, $per_page, $offset)
    {
        $this->db->select('quote_requests.*');
        $this->db->join('products', 'quote_requests.product_id = products.id');
        $this->db->where('products.status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->where("((products.product_type = 'physical' AND products.stock > 0) OR products.product_type = 'digital')");
        $this->db->where('quote_requests.seller_id', clean_number($user_id))->where('quote_requests.is_seller_deleted', 0);
        $this->filter_quote_requests();
        $this->db->order_by('updated_at', 'DESC')->limit($per_page, $offset);
        return $this->db->get('quote_requests')->result();
    }

    //get vendor quote requests count
    public function get_vendor_quote_requests_count($user_id)
    {
        $this->db->join('products', 'quote_requests.product_id = products.id');
        $this->db->where('products.status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->where("((products.product_type = 'physical' AND products.stock > 0) OR products.product_type = 'digital')");
        $this->db->where('quote_requests.seller_id', clean_number($user_id))->where('quote_requests.is_seller_deleted', 0);
        $this->filter_quote_requests();
        return $this->db->count_all_results('quote_requests');
    }

    //get new quote requests count
    public function get_new_quote_requests_count($user_id)
    {
        $this->db->where('seller_id', clean_number($user_id));
        $this->db->where('is_seller_deleted', 0);
        $this->db->where('status', 'new_quote_request');
        return $this->db->count_all_results('quote_requests');
    }

    //delete quote request
    public function delete_quote_request($id)
    {
        $id = clean_number($id);
        $quote_request = $this->get_quote_request($id);
        if (!empty($quote_request)) {
            if ($this->auth_user->id == $quote_request->seller_id || $this->auth_user->id == $quote_request->buyer_id) {
                if ($this->auth_user->id == $quote_request->buyer_id) {
                    $data = array(
                        'is_buyer_deleted' => 1,
                        'status' => 'closed',
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    if ($quote_request->status == 'completed') {
                        $data['status'] = 'completed';
                    }
                    $this->db->where('id', $id);
                    return $this->db->update('quote_requests', $data);
                } elseif ($this->auth_user->id == $quote_request->seller_id) {
                    $data = array(
                        'is_seller_deleted' => 1,
                        'status' => 'closed',
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    if ($quote_request->status == 'completed') {
                        $data['status'] = 'completed';
                    }
                    $this->db->where('id', $id);
                    return $this->db->update('quote_requests', $data);
                }
            }
        }
        return false;
    }

    //delete quote if both deleted
    public function delete_quote_request_if_both_deleted($id)
    {
        $id = clean_number($id);
        $quote_request = $this->get_quote_request($id);
        if (!empty($quote_request)) {
            if ($this->auth_user->id == $quote_request->seller_id || $this->auth_user->id == $quote_request->buyer_id) {
                if ($quote_request->is_buyer_deleted == 1 && $quote_request->is_seller_deleted == 1) {
                    $this->db->where('id', $id);
                    return $this->db->delete('quote_requests');
                }
            }
        }
        return false;
    }

    //set bidding quotes as completed after purchase
    public function set_bidding_quotes_as_completed_after_purchase()
    {
        $cart_items = $this->cart_model->get_sess_cart_items();
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                if ($cart_item->purchase_type == 'bidding') {
                    $data = array(
                        'status' => 'completed',
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('id', $cart_item->quote_request_id);
                    @$this->db->update('quote_requests', $data);
                }
            }
        }
    }

    //get admin quote requests count
    public function get_admin_quote_requests_count()
    {
        $this->filter_quote_requests();
        $query = $this->db->get('quote_requests');
        return $query->num_rows();
    }

    //get admin quote requests
    public function get_admin_paginated_quote_requests($per_page, $offset)
    {
        $this->filter_quote_requests();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('quote_requests');
        return $query->result();
    }

    //filter quote requests
    public function filter_quote_requests()
    {
        $status = input_get('status');
        $q = input_get('q');

        if ($status == "new_quote_request" || $status == "pending_quote" || $status == "pending_payment" || $status == "rejected_quote" || $status == "closed" || $status == "completed") {
            $this->db->where('quote_requests.status', $status);
        }
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('quote_requests.product_title', $q);
            $this->db->or_like('quote_requests.id', $q);
            $this->db->group_end();
        }
    }

    //delete admin quote request
    public function delete_admin_quote_request($id)
    {
        if (is_admin()) {
            $id = clean_number($id);
            $quote_request = $this->get_quote_request($id);
            if (!empty($quote_request)) {
                $this->db->where('id', $id);
                return $this->db->delete('quote_requests');
            }
        }
    }

}
