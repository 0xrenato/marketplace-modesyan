<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Membership_controller extends Admin_Core_Controller
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
     * Members
     */
    public function members()
    {
        $data['title'] = trans("members");
        $data['page_url'] = admin_url() . "members";

        $pagination = $this->paginate($data['page_url'], $this->auth_model->get_users_count_by_role('member'));
        $data['users'] = $this->auth_model->get_paginated_filtered_users('member', $pagination['per_page'], $pagination['offset']);
        

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/members');
        $this->load->view('admin/includes/_footer');

    }

    /**
     * Vendors
     */
    public function vendors()
    {
        $data['title'] = trans("vendors");
        $data['page_url'] = admin_url() . "vendors";

        $pagination = $this->paginate($data['page_url'], $this->auth_model->get_users_count_by_role('vendor'));
        $data['users'] = $this->auth_model->get_paginated_filtered_users('vendor', $pagination['per_page'], $pagination['offset']);
        $data["membership_plans"] = $this->membership_model->get_plans();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/vendors');
        $this->load->view('admin/includes/_footer');

    }

    /**
     * Administrators
     */
    public function administrators()
    {
        $data['title'] = trans("administrators");
        $data['page_url'] = admin_url() . "administrators";

        $pagination = $this->paginate($data['page_url'], $this->auth_model->get_users_count_by_role('admin'));
        $data['users'] = $this->auth_model->get_paginated_filtered_users('admin', $pagination['per_page'], $pagination['offset']);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/administrators');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Administrator
     */
    public function add_administrator()
    {
        $data['title'] = trans("add_administrator");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/add_administrator');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Administrator
     */
    public function add_administrator_post()
    {
        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', trans("email_address"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|min_length[4]|max_length[50]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $email = $this->input->post('email', true);
            $username = $this->input->post('username', true);
            //is username unique
            if (!$this->auth_model->is_unique_username($username)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
            }
            //is email unique
            if (!$this->auth_model->is_unique_email($email)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_email_unique_error"));
                redirect($this->agent->referrer());
            }

            //add user
            if ($this->auth_model->add_administrator()) {
                $this->session->set_flashdata('success', trans("msg_administrator_added"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }

            redirect($this->agent->referrer());
        }
    }

    /**
     * Edit User
     */
    public function edit_user($id)
    {
        $data['title'] = trans("edit_user");
        $data['user'] = $this->auth_model->get_user($id);
        if (empty($data['user'])) {
            redirect(admin_url() . "members");
        }
        $data["countries"] = $this->location_model->get_countries();
        $data["states"] = $this->location_model->get_states_by_country($data['user']->country_id);
        $data["cities"] = $this->location_model->get_cities_by_state($data['user']->state_id);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/edit_user');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Edit User Post
     */
    public function edit_user_post()
    {
        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', trans("email"), 'required|xss_clean');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            $data = array(
                'id' => $this->input->post('id', true),
                'username' => $this->input->post('username', true),
                'slug' => $this->input->post('slug', true),
                'email' => $this->input->post('email', true)
            );
            //is email unique
            if (!$this->auth_model->is_unique_email($data["email"], $data["id"])) {
                $this->session->set_flashdata('error', trans("msg_email_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            //is username unique
            if (!$this->auth_model->is_unique_username($data["username"], $data["id"])) {
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            //is slug unique
            if ($this->auth_model->check_is_slug_unique($data["slug"], $data["id"])) {
                $this->session->set_flashdata('error', trans("msg_slug_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }

            if ($this->profile_model->edit_user($data["id"])) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Shop Opening Requests
     */
    public function shop_opening_requests()
    {
        $data['title'] = trans("shop_opening_requests");

        $pagination = $this->paginate(admin_url() . "shop-opening-requests", $this->membership_model->get_shop_opening_requests_count());
        $data['users'] = $this->membership_model->get_paginated_shop_opening_requests($pagination['per_page'], $pagination['offset']);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/shop_opening_requests');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Approve Shop Opening Request
     */
    public function approve_shop_opening_request()
    {
        $user_id = $this->input->post('id', true);
        if ($this->membership_model->approve_shop_opening_request($user_id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));

            $submit = $this->input->post('submit', true);
            $email_content = trans("your_shop_opening_request_approved");
            $email_button_text = trans("start_selling");
            if ($submit == 0) {
                $email_content = trans("msg_shop_request_declined");
                $email_button_text = trans("view_site");
            }
            //send email
            $user = get_user($user_id);
            if (!empty($user) && $this->general_settings->send_email_shop_opening_request == 1) {
                $email_data = array(
                    'email_type' => 'email_general',
                    'to' => $user->email,
                    'subject' => trans("shop_opening_request"),
                    'email_content' => $email_content,
                    'email_link' => base_url(),
                    'email_button_text' => $email_button_text
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Assign Membership Plan
     */
    public function assign_membership_plan_post()
    {
        $user_id = $this->input->post('user_id', true);
        $plan_id = $this->input->post('plan_id', true);
        $user = get_user($user_id);
        $plan = $this->membership_model->get_plan($plan_id);
        if (!empty($plan) && !empty($user)) {
            $data_transaction = array(
                'payment_method' => "",
                'payment_status' => ""
            );
            if ($plan->is_free == 1) {
                $this->membership_model->add_user_free_plan($plan, $user->id);
            } else {
                $this->membership_model->add_user_plan($data_transaction, $plan, $user->id);
            }
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Confirm User Email
     */
    public function confirm_user_email()
    {
        $id = $this->input->post('id', true);
        $user = $this->auth_model->get_user($id);
        if ($this->auth_model->verify_email($user)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Ban or Remove User Ban
     */
    public function ban_remove_ban_user()
    {
        $id = $this->input->post('id', true);
        if ($this->auth_model->ban_remove_ban_user($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Open or Close User Shop
     */
    public function open_close_user_shop()
    {
        $id = $this->input->post('id', true);
        if ($this->membership_model->open_close_user_shop($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete User
     */
    public function delete_user_post()
    {
        $id = $this->input->post('id', true);
        if ($this->auth_model->delete_user($id)) {
            $this->session->set_flashdata('success', trans("msg_user_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * MEMBERSHIP PLANS
    *------------------------------------------------------------------------------------------
    */

    /**
     * Membership Plans
     */
    public function membership_plans()
    {
        $data['title'] = trans("membership_plans");
        $data["membership_plans"] = $this->membership_model->get_plans();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/membership_plans');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Plan Post
     */
    public function add_plan_post()
    {
        if ($this->membership_model->add_plan()) {
            $this->session->set_flashdata('success', trans("msg_added"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Edit Plan
     */
    public function edit_plan($id)
    {
        $data['title'] = trans("edit_plan");
        $data['plan'] = $this->membership_model->get_plan($id);
        if (empty($data['plan'])) {
            redirect($this->agent->referrer());
            exit();
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/edit_plan');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Edit Plan Post
     */
    public function edit_plan_post()
    {
        $id = $this->input->post('id', true);
        if ($this->membership_model->edit_plan($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Settings Post
     */
    public function settings_post()
    {
        if ($this->membership_model->update_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('msg_settings', 1);
        redirect($this->agent->referrer());
    }

    /**
     * Delete Plan Post
     */
    public function delete_plan_post()
    {
        $id = $this->input->post('id', true);
        $this->membership_model->delete_plan($id);
        redirect($this->agent->referrer());
    }

    /**
     * Membership Transactions
     */
    public function transactions_membership()
    {
        $data['title'] = trans("membership_transactions");
        $data['description'] = trans("membership_transactions") . " - " . $this->app_name;
        $data['keywords'] = trans("membership_transactions") . "," . $this->app_name;

        $data['num_rows'] = $this->membership_model->get_membership_transactions_count(null);
        $pagination = $this->paginate(admin_url() . "membership-transactions", $data['num_rows']);
        $data['transactions'] = $this->membership_model->get_paginated_membership_transactions(null, $pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/transactions');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Approve Payment Post
     */
    public function approve_payment_post()
    {
        $id = $this->input->post('id', true);
        $this->membership_model->approve_transaction_payment($id);
        $this->session->set_flashdata('success', trans("msg_updated"));
        redirect($this->agent->referrer());
    }

    /**
     * Delete Transactions Post
     */
    public function delete_transaction_post()
    {
        $id = $this->input->post('id', true);
        $this->membership_model->delete_transaction($id);
    }
}
