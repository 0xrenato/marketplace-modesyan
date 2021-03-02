<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Membership_model extends CI_Model
{
    //add membership transaction
    public function add_membership_transaction($data_transaction, $plan)
    {
        $data = array(
            'payment_method' => $data_transaction["payment_method"],
            'payment_id' => $data_transaction["payment_id"],
            'user_id' => $this->auth_user->id,
            'plan_id' => $plan->id,
            'plan_title' => $this->get_membership_plan_title($plan),
            'payment_amount' => $data_transaction["payment_amount"],
            'currency' => $data_transaction["currency"],
            'payment_status' => $data_transaction["payment_status"],
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->db->insert('membership_transactions', $data)) {
            $this->session->set_userdata('mds_membership_transaction_insert_id', $this->db->insert_id());
            if (!is_user_vendor()) {
                $data_user = array(
                    'is_active_shop_request' => 1
                );
                $this->db->where('id', $this->auth_user->id);
                $this->db->update('users', $data_user);
                //send email
                $this->send_shop_opening_email();
            }
        }
    }

    //add membership transaction bank
    public function add_membership_transaction_bank($data_transaction, $plan)
    {
        $data = array(
            'payment_method' => $data_transaction["payment_method"],
            'payment_id' => $data_transaction["payment_id"],
            'user_id' => $this->auth_user->id,
            'plan_id' => $plan->id,
            'plan_title' => $this->get_membership_plan_title($plan),
            'payment_amount' => get_price($plan->price, 'decimal'),
            'currency' => $this->payment_settings->default_currency,
            'payment_status' => $data_transaction["payment_status"],
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->db->insert('membership_transactions', $data)) {
            $this->session->set_userdata('mds_membership_transaction_insert_id', $this->db->insert_id());
            if (!is_user_vendor()) {
                $data_user = array(
                    'is_active_shop_request' => 1
                );
                $this->db->where('id', $this->auth_user->id);
                $this->db->update('users', $data_user);
            }
            //send email
            $this->send_shop_opening_email();
        }
    }

    //send shop opening email
    public function send_shop_opening_email()
    {
        if ($this->general_settings->send_email_shop_opening_request == 1) {
            $email_data = array(
                'email_type' => 'email_general',
                'to' => $this->general_settings->mail_options_account,
                'subject' => trans("shop_opening_request"),
                'email_content' => trans("there_is_shop_opening_request") . "<br>" . trans("user") . ": " . "<strong>" . $this->auth_user->username . "</strong>",
                'email_link' => admin_url() . "shop-opening-requests",
                'email_button_text' => trans("view_details")
            );
            $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
        }
    }

    //get membership transaction
    public function get_membership_transaction($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->get('membership_transactions')->row();
    }

    //get membership plan title
    public function get_membership_plan_title($plan)
    {
        $title = trans("membership_plan");
        if (!empty($plan)) {
            $title = get_membership_plan_name($plan->title_array, $this->selected_lang->id);
            $title .= " (";
            if ($plan->is_unlimited_number_of_ads == 1) {
                $title .= trans("number_of_ads") . ": " . trans("unlimited");
            } else {
                $title .= trans("number_of_ads") . ": " . $plan->number_of_ads;
            }
            if ($plan->is_unlimited_time == 1) {
                $title .= ", " . trans("number_of_days") . ": " . trans("unlimited");
            } else {
                $title .= ", " . trans("number_of_days") . ": " . $plan->number_of_days;
            }
            $title .= ")";
        }
        return $title;
    }

    //add user plan
    public function add_user_plan($data_transaction, $plan, $user_id)
    {
        $data = array(
            'plan_id' => $plan->id,
            'plan_title' => $this->get_membership_plan_title($plan),
            'number_of_ads' => $plan->number_of_ads,
            'number_of_days' => $plan->number_of_days,
            'price' => $plan->price,
            'currency' => $this->payment_settings->default_currency,
            'is_free' => $plan->is_free,
            'is_unlimited_number_of_ads' => $plan->is_unlimited_number_of_ads,
            'is_unlimited_time' => $plan->is_unlimited_time,
            'payment_method' => $data_transaction["payment_method"],
            'payment_status' => $data_transaction["payment_status"],
            'plan_status' => 1,
            'plan_start_date' => date('Y-m-d H:i:s')
        );
        if ($plan->is_unlimited_time == 1) {
            $data['plan_end_date'] = "";
        } else {
            $data['plan_end_date'] = strtotime($data['plan_start_date'] . "+ " . $plan->number_of_days . " days");
            $data['plan_end_date'] = date('Y-m-d H:i:s', $data['plan_end_date']);
        }

        if ($data_transaction["payment_status"] == "awaiting_payment") {
            $data['plan_status'] = 0;
        }

        $user_plan = $this->get_user_plan_by_user_id($user_id);
        if (!empty($user_plan)) {
            //update plan
            $this->db->where('id', $user_plan->id);
            $this->db->update('users_membership_plans', $data);
        } else {
            //add plan
            $data['user_id'] = clean_number($user_id);
            $this->db->insert('users_membership_plans', $data);
        }
        //update user plan status
        $this->db->where('id', clean_number($user_id));
        $this->db->update('users', ['is_membership_plan_expired' => 0]);
    }

    //add user free plan
    public function add_user_free_plan($plan, $user_id)
    {
        $data = array(
            'plan_id' => $plan->id,
            'plan_title' => $this->get_membership_plan_title($plan),
            'number_of_ads' => $plan->number_of_ads,
            'number_of_days' => $plan->number_of_days,
            'price' => 0,
            'currency' => $this->payment_settings->default_currency,
            'is_free' => $plan->is_free,
            'is_unlimited_number_of_ads' => $plan->is_unlimited_number_of_ads,
            'is_unlimited_time' => $plan->is_unlimited_time,
            'payment_method' => "",
            'payment_status' => "",
            'plan_status' => 1,
            'plan_start_date' => date('Y-m-d H:i:s')
        );
        if ($plan->is_unlimited_time == 1) {
            $data['plan_end_date'] = "";
        } else {
            $data['plan_end_date'] = strtotime($data['plan_start_date'] . "+ " . $plan->number_of_days . " days");
            $data['plan_end_date'] = date('Y-m-d H:i:s', $data['plan_end_date']);
        }
        $user_plan = $this->get_user_plan_by_user_id($user_id);
        if (!empty($user_plan)) {
            //update plan
            $this->db->where('id', $user_plan->id);
            $this->db->update('users_membership_plans', $data);
        } else {
            //add plan
            $data['user_id'] = clean_number($user_id);
            $this->db->insert('users_membership_plans', $data);
        }
        //update user plan status
        $this->db->where('id', clean_number($user_id));
        $this->db->update('users', ['is_membership_plan_expired' => 0, 'is_used_free_plan' => 1]);
    }

    //get user plan
    public function get_user_plan($id)
    {
        return $this->db->where('id', clean_number($id))->get('users_membership_plans')->row();
    }

    //get user plan by user id
    public function get_user_plan_by_user_id($user_id)
    {
        return $this->db->where('plan_status', 1)->where('user_id', clean_number($user_id))->get('users_membership_plans')->row();
    }

    //get user plan days remaining
    public function get_user_plan_remaining_days_count($plan)
    {
        $days_left = 0;
        if (!empty($plan)) {
            if (!empty($plan->plan_end_date)) {
                $days_left = date_difference($plan->plan_end_date, date('Y-m-d H:i:s'));
            }
        }
        return $days_left;
    }

    //get user ads count
    public function get_user_ads_count($user_id)
    {
        return $this->db->where('products.is_deleted', 0)->where('products.is_draft', 0)->where('products.status', 1)->where('products.user_id', clean_number($user_id))->count_all_results('products');
    }

    //get user plan ads remaining
    public function get_user_plan_remaining_ads_count($plan)
    {
        $ads_left = 0;
        if (!empty($plan)) {
            $products_count = $this->get_user_ads_count($plan->user_id);
            $ads_left = @($plan->number_of_ads - $products_count);
            if (empty($ads_left) || $ads_left < 0) {
                $ads_left = 0;
            }
        }
        return $ads_left;
    }

    //is allowed adding product
    public function is_allowed_adding_product()
    {
        if ($this->auth_user->role == "admin") {
            return true;
        }
        if ($this->general_settings->membership_plans_system == 1) {
            if ($this->auth_user->is_membership_plan_expired == 1) {
                return false;
            }
            $user_plan = $this->get_user_plan_by_user_id($this->auth_user->id);
            if (!empty($user_plan)) {
                if ($user_plan->is_unlimited_number_of_ads == 1) {
                    return true;
                }
                if ($this->get_user_plan_remaining_ads_count($user_plan) > 0) {
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    //check membership plans expired
    public function check_membership_plans_expired()
    {
        $this->db->join('users', 'users_membership_plans.user_id = users.id AND users.is_membership_plan_expired = 0');
        $this->db->select('users_membership_plans.*');
        $plans = $this->db->get('users_membership_plans')->result();
        if (!empty($plans)) {
            foreach ($plans as $plan) {
                if ($plan->is_unlimited_time != 1) {
                    if ($this->get_user_plan_remaining_days_count($plan) <= -3) {
                        //update user plan status
                        $this->db->where('id', $plan->user_id);
                        $this->db->update('users', ['is_membership_plan_expired' => 1]);
                    }
                }
            }
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * BACK-END
    *-------------------------------------------------------------------------------------------------
    */

    //prepare data
    public function prepare_data()
    {
        $data = array(
            'number_of_ads' => $this->input->post('number_of_ads', true),
            'number_of_days' => $this->input->post('number_of_days', true),
            'price' => $this->input->post('price', true),
            'is_free' => $this->input->post('is_free', true),
            'is_unlimited_number_of_ads' => $this->input->post('is_unlimited_number_of_ads', true),
            'is_unlimited_time' => $this->input->post('is_unlimited_time', true),
            'plan_order' => $this->input->post('plan_order', true),
            'is_popular' => $this->input->post('is_popular', true)
        );
        $array_title = array();
        $array_features = array();
        foreach ($this->languages as $language) {
            //add titles
            $item = array(
                'lang_id' => $language->id,
                'title' => $this->input->post('title_' . $language->id, true)
            );
            array_push($array_title, $item);

            //add features
            $features = $this->input->post('feature_' . $language->id, true);
            $array = array();
            if (!empty($features)) {
                foreach ($features as $feature) {
                    $feature = trim($feature);
                    if (!empty($feature)) {
                        array_push($array, $feature);
                    }
                }
            }
            $item_feature = array(
                'lang_id' => $language->id,
                'features' => $array
            );
            array_push($array_features, $item_feature);
        }
        $data["price"] = get_price($data["price"], 'database');
        if (empty($data["price"])) {
            $data["price"] = 0;
        }
        $data['title_array'] = serialize($array_title);
        $data['features_array'] = serialize($array_features);
        if (empty($data["number_of_ads"])) {
            $data["number_of_ads"] = 0;
        }
        if (empty($data["number_of_days"])) {
            $data["number_of_days"] = 0;
        }

        if (!empty($data["is_unlimited_number_of_ads"])) {
            $data["number_of_ads"] = 0;
        } else {
            $data["is_unlimited_number_of_ads"] = 0;
        }

        if (!empty($data["is_unlimited_time"])) {
            $data["number_of_days"] = 0;
        } else {
            $data["is_unlimited_time"] = 0;
        }

        if (!empty($data["is_free"])) {
            $data["price"] = 0;
        } else {
            $data["is_free"] = 0;
        }
        //update other plans
        if (!empty($data["is_popular"])) {
            $this->db->update('membership_plans', ['is_popular' => 0]);
        } else {
            $data["is_popular"] = 0;
        }
        return $data;
    }

    //add plan
    public function add_plan()
    {
        $data = $this->prepare_data();
        return $this->db->insert('membership_plans', $data);
    }

    //edit plan
    public function edit_plan($id)
    {
        $plan = $this->get_plan($id);
        if (!empty($plan)) {
            $data = $this->prepare_data();
            $this->db->where('id', $plan->id);
            return $this->db->update('membership_plans', $data);
        }
        return false;
    }

    //get plan
    public function get_plan($id)
    {
        return $this->db->where('id', clean_number($id))->get('membership_plans')->row();
    }

    //get plans
    public function get_plans()
    {
        $this->db->order_by('plan_order');
        return $this->db->get('membership_plans')->result();
    }

    //update settings
    public function update_settings()
    {
        $data = array(
            'membership_plans_system' => $this->input->post('membership_plans_system', true)
        );
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //get paginated membership transactions
    public function get_paginated_membership_transactions($user_id, $per_page, $offset)
    {
        $this->db->join('users', 'users.id = membership_transactions.user_id');
        $this->db->select('membership_transactions.*');
        if (!empty($user_id)) {
            $this->db->where('user_id', clean_number($user_id));
        }
        $this->filter_transactions();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        return $this->db->get('membership_transactions')->result();
    }

    //get membership transactions count
    public function get_membership_transactions_count($user_id)
    {
        $this->db->join('users', 'users.id = membership_transactions.user_id');
        $this->db->select('membership_transactions.*');
        if (!empty($user_id)) {
            $this->db->where('user_id', clean_number($user_id));
        }
        $this->filter_transactions();
        return $this->db->count_all_results('membership_transactions');
    }

    //filter membership transactions
    public function filter_transactions()
    {
        $q = input_get('q');
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('users.username', $q);
            $this->db->or_like('membership_transactions.plan_title', $q);
            $this->db->or_like('membership_transactions.payment_method', $q);
            $this->db->or_like('membership_transactions.payment_id', $q);
            $this->db->or_like('membership_transactions.payment_amount', $q);
            $this->db->or_like('membership_transactions.currency', $q);
            $this->db->or_like('membership_transactions.payment_status', $q);
            $this->db->or_like('membership_transactions.ip_address', $q);
            $this->db->group_end();
        }
    }

    //approve payment
    public function approve_transaction_payment($id)
    {
        $transaction = $this->get_membership_transaction($id);
        if (!empty($transaction)) {
            $data = array(
                'payment_status' => 'payment_received'
            );
            $this->db->where('id', $transaction->id);
            $this->db->update('membership_transactions', $data);
            //update user plan
            $user_plan = $this->db->where('user_id', $transaction->user_id)->get('users_membership_plans')->row();
            if (!empty($user_plan)) {
                $data = array(
                    'payment_status' => 'payment_received',
                    'plan_status' => 1,
                    'plan_start_date' => date('Y-m-d H:i:s')
                );
                if ($user_plan->is_unlimited_time == 1) {
                    $data['plan_end_date'] = "";
                } else {
                    $data['plan_end_date'] = strtotime($data['plan_start_date'] . "+ " . $user_plan->number_of_days . " days");
                    $data['plan_end_date'] = date('Y-m-d H:i:s', $data['plan_end_date']);
                }
                $this->db->where('id', $user_plan->id);
                $this->db->update('users_membership_plans', $data);
            }
            return true;
        }
        return false;
    }

    //delete transaction
    public function delete_transaction($id)
    {
        $transaction = $this->get_membership_transaction($id);
        if (!empty($transaction)) {
            $this->db->where('id', $transaction->id);
            return $this->db->delete('membership_transactions');
        }
        return false;
    }

    //delete plan
    public function delete_plan($id)
    {
        $plan = $this->get_plan($id);
        if (!empty($plan)) {
            $this->db->where('id', $plan->id);
            return $this->db->delete('membership_plans');
        }
        return false;
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * SHOP OPENING REQUESTS
    *-------------------------------------------------------------------------------------------------
    */

    //get paginated users
    public function get_paginated_shop_opening_requests($per_page, $offset)
    {
        $this->db->where('is_active_shop_request', 1);
        $this->db->order_by('created_at', 'DESC')->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('users')->result();
    }

    //get users count by role
    public function get_shop_opening_requests_count()
    {
        return $this->db->where('is_active_shop_request', 1)->count_all_results('users');
    }

    //add shop opening requests
    public function add_shop_opening_requests($data)
    {
        if (empty($data['country_id'])) {
            $data['country_id'] = 0;
        }
        if (empty($data['state_id'])) {
            $data['state_id'] = 0;
        }
        if (empty($data['city_id'])) {
            $data['city_id'] = 0;
        }
        $this->db->where('id', $this->auth_user->id);
        return $this->db->update('users', $data);
    }

    //approve shop opening request
    public function approve_shop_opening_request($user_id)
    {
        $user_id = clean_number($user_id);
        //approve request
        if ($this->input->post('submit', true) == 1) {
            $data_shop = array(
                'role' => 'vendor',
                'is_active_shop_request' => 0,
            );
            //update user plan
            $user_plan = $this->get_user_plan_by_user_id($user_id);
            if (!empty($user_plan)) {
                $data = array(
                    'payment_status' => 'payment_received',
                    'plan_status' => 1,
                    'plan_start_date' => date('Y-m-d H:i:s')
                );
                if ($user_plan->is_unlimited_time == 1) {
                    $data['plan_end_date'] = "";
                } else {
                    $data['plan_end_date'] = strtotime($data['plan_start_date'] . "+ " . $user_plan->number_of_days . " days");
                    $data['plan_end_date'] = date('Y-m-d H:i:s', $data['plan_end_date']);
                }
                $this->db->where('id', $user_plan->id);
                $this->db->update('users_membership_plans', $data);
            }
        } else {
            //decline request
            $data_shop = array(
                'is_active_shop_request' => 2,
            );
        }

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data_shop);
    }

    //open close user shop
    public function open_close_user_shop($id)
    {
        $id = clean_number($id);
        $user = get_user($id);
        if (!empty($user)) {
            $data = array();
            if ($user->role == 'member') {
                $data['role'] = 'vendor';
            } else {
                $data['role'] = 'member';
            }
            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }
        return false;
    }
}
