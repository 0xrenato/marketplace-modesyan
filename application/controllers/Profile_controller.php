<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_controller extends Home_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Profile
     */
    public function profile($slug)
    {
        $slug = clean_slug($slug);
        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }

        $data['title'] = get_shop_name($data["user"]);
        $data['description'] = $data["user"]->username . " - " . $this->app_name;
        $data['keywords'] = $data["user"]->username . "," . $this->app_name;
        //og tags
        $data['show_og_tags'] = true;
        $data['og_title'] = $data['title'];
        $data['og_description'] = $data['description'];
        $data['og_type'] = "article";
        $data['og_url'] = generate_profile_url($data["user"]->slug);
        $data['og_image'] = get_user_avatar($data["user"]);
        $data['og_width'] = "200";
        $data['og_height'] = "200";
        
        $data['og_creator'] = $data['title'];

        $data["active_tab"] = "products";
        $data["user_rating"] = calculate_user_rating($data["user"]->id);

        $data["query_string_array"] = get_query_string_array(null);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);

        $data["category"] = null;
        $data["parent_category"] = null;
        $category_id = input_get('p_cat');
        if (!empty($category_id)) {
            $data["category"] = get_category_by_id($category_id);
            if (!empty($data["category"]) && $data["category"]->parent_id != 0) {
                $data["parent_category"] = $this->category_model->get_category($data["category"]->parent_id);
            }
        }
        $product_categories = $this->category_model->get_product_categories($data["category"], $data["user"]->id);
        $data["categories"] = !empty($product_categories['categories']) ? $product_categories['categories'] : array();
        $data["category_ids"] = !empty($product_categories['category_ids']) ? $product_categories['category_ids'] : array();
        $data["subcategory_ids"] = !empty($product_categories['subcategory_ids']) ? $product_categories['subcategory_ids'] : array();

        //set pagination
        $data['num_rows'] = $this->product_model->get_profile_products_count($data["user"]->id, $data["subcategory_ids"]);
        $pagination = $this->paginate(generate_profile_url($data["user"]->slug), $data['num_rows'], $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_profile_products($data["user"]->id, $data["subcategory_ids"], $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('profile/profile', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Downloads
     */
    public function downloads()
    {
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (!$this->is_sale_active) {
            redirect(lang_base_url());
        }
        if ($this->general_settings->digital_products_system == 0) {
            redirect(lang_base_url());
        }
        $data["user"] = $this->auth_user;
        $data['title'] = trans("downloads");
        
        $data['description'] = trans("downloads") . " - " . $this->app_name;
        $data['keywords'] = trans("downloads") . "," . $this->app_name;
        $data["active_tab"] = "downloads";
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        //set pagination
        $pagination = $this->paginate(generate_url("downloads"), $this->product_model->get_user_downloads_count($data["user"]->id), $this->product_per_page);
        $data['items'] = $this->product_model->get_paginated_user_downloads($data["user"]->id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('profile/downloads', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Wishlist
     */
    public function wishlist($slug)
    {
        $slug = clean_slug($slug);
        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("wishlist");
        $data['description'] = trans("wishlist") . " - " . $this->app_name;
        $data['keywords'] = trans("wishlist") . "," . $this->app_name;
        $data["active_tab"] = "wishlist";
        
        $data["user_rating"] = calculate_user_rating($data["user"]->id);

        //set pagination
        $pagination = $this->paginate(generate_url("wishlist") . '/' . $data["user"]->slug, $this->product_model->get_user_wishlist_products_count($data["user"]->id), 20);
        $data['products'] = $this->product_model->get_paginated_user_wishlist_products($data["user"]->id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('profile/wishlist', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Followers
     */
    public function followers($slug)
    {
        $slug = clean_slug($slug);
        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("followers");
        $data['description'] = trans("followers") . " - " . $this->app_name;
        $data['keywords'] = trans("followers") . "," . $this->app_name;
        $data["active_tab"] = "followers";
        
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        $data["followers"] = $this->profile_model->get_followers($data["user"]->id);

        $this->load->view('partials/_header', $data);
        $this->load->view('profile/followers', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Following
     */
    public function following($slug)
    {
        $slug = clean_slug($slug);
        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("following");
        $data['description'] = trans("following") . " - " . $this->app_name;
        $data['keywords'] = trans("following") . "," . $this->app_name;
        $data["active_tab"] = "following";
        
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        $data["following_users"] = $this->profile_model->get_following_users($data["user"]->id);

        $this->load->view('partials/_header', $data);
        $this->load->view('profile/following', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Reviews
     */
    public function reviews($slug)
    {
        $slug = clean_slug($slug);
        if ($this->general_settings->reviews != 1) {
            redirect(lang_base_url());
        }

        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        if ($data["user"]->role != 'admin' && $data["user"]->role != 'vendor') {
            redirect(lang_base_url());
        }

        $data['title'] = get_shop_name($data["user"]) . " " . trans("reviews");
        $data['description'] = $data["user"]->username . " " . trans("reviews") . " - " . $this->app_name;
        $data['keywords'] = $data["user"]->username . " " . trans("reviews") . "," . $this->app_name;
        $data["active_tab"] = "reviews";
        
        $data["user_rating"] = calculate_user_rating($data["user"]->id);

        //set pagination
        $pagination = $this->paginate(generate_url("reviews") . "/" . $data["user"]->slug, $this->review_model->get_vendor_reviews_count($data["user"]->id), 10);
        $data['reviews'] = $this->review_model->get_paginated_vendor_reviews($data["user"]->id, $pagination['per_page'], $pagination['offset']);


        $this->load->view('partials/_header', $data);
        $this->load->view('profile/reviews', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Update Profile
     */
    public function update_profile()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("update_profile");
        $data['description'] = trans("update_profile") . " - " . $this->app_name;
        $data['keywords'] = trans("update_profile") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        
        $data["active_tab"] = "update_profile";

        $this->load->view('partials/_header', $data);
        $this->load->view('settings/update_profile', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Update Profile Post
     */
    public function update_profile_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $user_id = $this->auth_user->id;
        $action = $this->input->post('submit', true);

        if ($action == "resend_activation_email") {
            //send activation email
            $this->load->model("email_model");
            $this->email_model->send_email_activation($user_id);
            $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
            redirect($this->agent->referrer());
        }

        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', trans("email"), 'required|xss_clean');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {

            $data = array(
                'username' => $this->input->post('username', true),
                'slug' => str_slug($this->input->post('slug', true)),
                'email' => $this->input->post('email', true),
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                'phone_number' => $this->input->post('phone_number', true),
                'send_email_new_message' => $this->input->post('send_email_new_message', true),
                'show_email' => $this->input->post('show_email', true),
                'show_phone' => $this->input->post('show_phone', true),
                'show_location' => $this->input->post('show_location', true)
            );

            //is email unique
            if (!$this->auth_model->is_unique_email($data["email"], $user_id)) {
                $this->session->set_flashdata('error', trans("msg_email_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            //is username unique
            if (!$this->auth_model->is_unique_username($data["username"], $user_id)) {
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            //is slug unique
            if ($this->auth_model->check_is_slug_unique($data["slug"], $user_id)) {
                $this->session->set_flashdata('error', trans("msg_slug_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }

            if ($this->profile_model->update_profile($data, $user_id)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                //check email changed
                if ($this->profile_model->check_email_updated($user_id)) {
                    $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
                }
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Cover Image
     */
    public function cover_image()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("cover_image");
        $data['description'] = trans("cover_image") . " - " . $this->app_name;
        $data['keywords'] = trans("cover_image") . "," . $this->app_name;
        $data["active_tab"] = "cover_image";

        $this->load->view('partials/_header', $data);
        $this->load->view('settings/cover_image', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Cover Image Post
     */
    public function cover_image_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if ($this->profile_model->update_cover_image()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    /**
     * Shipping Address
     */
    public function shipping_address()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("shipping_address");
        $data['description'] = trans("shipping_address") . " - " . $this->app_name;
        $data['keywords'] = trans("shipping_address") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        
        $data["active_tab"] = "shipping_address";
        $data["shipping_addresses"] = $this->profile_model->get_shipping_addresses($data["user"]->id);

        $data["states"] = $this->location_model->get_states_by_country(1);

        $this->load->view('partials/_header', $data);
        $this->load->view('settings/shipping_address', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Add Shipping Address Post
     */
    public function add_shipping_address_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (!$this->profile_model->add_shipping_address()) {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Edit Shipping Address Post
     */
    public function edit_shipping_address_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (!$this->profile_model->edit_shipping_address()) {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Delete Shipping Address Post
     */
    public function delete_shipping_address_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (!$this->profile_model->delete_shipping_address()) {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Social Media
     */
    public function social_media()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("social_media");
        $data['description'] = trans("social_media") . " - " . $this->app_name;
        $data['keywords'] = trans("social_media") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "social_media";

        $this->load->view('partials/_header', $data);
        $this->load->view('settings/social_media', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Social Media Post
     */
    public function social_media_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        if ($this->profile_model->update_social_media()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Change Password
     */
    public function change_password()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("change_password");
        $data['description'] = trans("change_password") . " - " . $this->app_name;
        $data['keywords'] = trans("change_password") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "change_password";

        $this->load->view('partials/_header', $data);
        $this->load->view('settings/change_password', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Change Password Post
     */
    public function change_password_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $old_password_exists = $this->input->post('old_password_exists', true);

        if ($old_password_exists == 1) {
            $this->form_validation->set_rules('old_password', trans("old_password"), 'required|xss_clean');
        }
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('password_confirm', trans("password_confirm"), 'required|xss_clean|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->profile_model->change_password_input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->profile_model->change_password($old_password_exists)) {
                $this->session->set_flashdata('success', trans("msg_change_password_success"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_change_password_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Follow Unfollow User
     */
    public function follow_unfollow_user()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $this->profile_model->follow_unfollow_user();
        redirect($this->agent->referrer());
    }
}
