<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->comment_limit = 6;
        $this->blog_paginate_per_page = 12;
        $this->promoted_products_limit = $this->general_settings->index_promoted_products_count;
    }

    /**
     * Index
     */
    public function index()
    {
        get_method();
        $data['title'] = $this->settings->homepage_title;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        //products
        $data["latest_products"] = $this->product_model->get_products_limited($this->general_settings->index_latest_products_count);
        $data["promoted_products"] = $this->product_model->get_promoted_products_limited($this->promoted_products_limit, 0);
        $data["promoted_products_count"] = $this->product_model->get_promoted_products_count();
        $data["slider_items"] = $this->slider_model->get_slider_items();
        $data['featured_categories'] = $this->category_model->get_featured_categories();
        
        $data["index_categories"] = $this->category_model->get_index_categories();
        $data["index_banners_array"] = $this->ad_model->get_index_banners_array();
        $data["special_offers"] = $this->product_model->get_special_offers();
        $data["blog_slider_posts"] = $this->blog_model->get_latest_posts(10);

        $this->load->view('partials/_header', $data);
        $this->load->view('index', $data);
        $this->load->view('partials/_footer');
    }

    public function static_page()
    {
        $data['title'] = "This is a static page";
        $data['description'] = "This is a static page";
        $data['keywords'] = "static,page";

        $this->load->view('partials/_header', $data);
        $this->load->view('static_page', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Contact
     */
    public function contact()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('contact', $this->selected_lang->id);
        if (empty($page)) {
            redirect(lang_base_url());
            exit();
        }
        if ($page->visibility == 0) {
            $this->error_404();
        } else {
            $data['title'] = $page->title;
            $data['description'] = $page->description . " - " . $this->app_name;
            $data['keywords'] = $page->keywords . " - " . $this->app_name;
            $data['page'] = $page;
            $this->load->view('partials/_header', $data);
            $this->load->view('contact', $data);
            $this->load->view('partials/_footer');
        }
    }

    /**
     * Contact Page Post
     */
    public function contact_post()
    {
        post_method();
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('email', trans("email_address"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('message', trans("message"), 'required|xss_clean|max_length[5000]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->contact_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if (!$this->recaptcha_verify_request()) {
                $this->session->set_flashdata('form_data', $this->contact_model->input_values());
                $this->session->set_flashdata('error', trans("msg_recaptcha"));
                redirect($this->agent->referrer());
            } else {
                if ($this->contact_model->add_contact_message()) {
                    $this->session->set_flashdata('success', trans("msg_contact_success"));
                    redirect($this->agent->referrer());
                } else {
                    $this->session->set_flashdata('form_data', $this->contact_model->input_values());
                    $this->session->set_flashdata('error', trans("msg_contact_error"));
                    redirect($this->agent->referrer());
                }
            }

        }
    }

    /**
     * Dynamic Page by Name Slug
     */
    public function any($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        //index page
        if (empty($slug)) {
            redirect(lang_base_url());
        }
        
        $page = $this->page_model->get_page($slug);
        //if exists
        if (!empty($page)) {
            $this->page($page);
        } else {
            //check category
            $category = $this->category_model->get_parent_category_by_slug($slug);
            if (!empty($category)) {
                $this->category($category);
            } else {
                $this->product($slug);
            }
        }
    }

    /**
     * Page
     */
    private function page($page)
    {
        if (empty($page)) {
            redirect(lang_base_url());
        }
        if ($page->visibility == 0 || !empty($page->page_default_name)) {
            $this->error_404();
        } else {
            $data['title'] = $page->title;
            $data['description'] = $page->description;
            $data['keywords'] = $page->keywords;
            $data['page'] = $page;
            $this->load->view('partials/_header', $data);
            $this->load->view('page', $data);
            $this->load->view('partials/_footer');
        }
    }

    /**
     * Products
     */
    public function products()
    {
        get_method();
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;

        $product_categories = $this->category_model->get_product_categories(null, null, false);
        $data["categories"] = !empty($product_categories['categories']) ? $product_categories['categories'] : array();
        $data["category_ids"] = !empty($product_categories['category_ids']) ? $product_categories['category_ids'] : array();
        $data["subcategory_ids"] = !empty($product_categories['subcategory_ids']) ? $product_categories['subcategory_ids'] : array();
        
        $data['custom_filters'] = array();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);

        //get paginated posts
        $pagination = $this->paginate(generate_url("products"), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], null, $data['custom_filters']), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], null, $data['custom_filters'], $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Category
     */
    private function category($category)
    {
        if (empty($category)) {
            redirect($this->agent->referrer());
            exit();
        }

        $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : category_name($category);
        $data['description'] = $category->description;
        $data['keywords'] = $category->keywords;

        //og tags
        $data['show_og_tags'] = true;
        $data['og_title'] = category_name($category);
        $data['og_description'] = $data['description'];
        $data['og_type'] = "article";
        $data['og_url'] = generate_category_url($category);
        $data['og_image'] = get_category_image_url($category);
        $data['og_width'] = "420";
        $data['og_height'] = "420";
        $data['og_creator'] = $this->general_settings->application_name;

        $data["category"] = $category;
        $data["parent_category"] = null;
        if ($category->parent_id != 0) {
            $data["parent_category"] = $this->category_model->get_category($category->parent_id);
        }

        $product_categories = $this->category_model->get_product_categories($category, null, false);
        $data["categories"] = !empty($product_categories['categories']) ? $product_categories['categories'] : array();
        $data["category_ids"] = !empty($product_categories['category_ids']) ? $product_categories['category_ids'] : array();
        $data["subcategory_ids"] = !empty($product_categories['subcategory_ids']) ? $product_categories['subcategory_ids'] : array();
        $data["parent_categories"] = $this->category_model->get_parent_categories_tree($category);
        $data['custom_filters'] = $this->field_model->get_custom_filters($category->id, $data["parent_categories"]);
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);

        //get paginated posts
        $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $data["subcategory_ids"], $data['custom_filters']), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $data["subcategory_ids"], $data['custom_filters'], $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * SubCategory
     */
    public function subcategory($parent_slug, $slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $category = $this->category_model->get_category_by_slug($slug);
        if (!empty($category)) {
            $this->category($category);
        } else {
            $this->error_404();
        }
    }

    /**
     * Product
     */
    public function product($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $this->comment_limit = 5;

        $data["product"] = $this->product_model->get_product_by_slug($slug);
        if (empty($data['product'])) {
            $this->error_404();
        } else {
            if ($data['product']->status == 0 || $data['product']->visibility == 0) {
                if (!$this->auth_check) {
                    redirect(lang_base_url());
                }
                if ($data['product']->user_id != $this->auth_user->id && $this->auth_user->role != "admin") {
                    redirect(lang_base_url());
                }
            }
            $data['product_details'] = $this->product_model->get_product_details($data["product"]->id, $this->selected_lang->id, true);
            if (empty($data['product_details'])) {
                $data['product_details'] = array();
            }
            $data["parent_categories_tree"] = array();
            $category = get_category_by_id($data["product"]->category_id);
            if (!empty($category)) {
                $data["parent_categories_tree"] = $this->category_model->get_parent_categories_tree($category);
            }
            //images
            $data["product_images"] = get_product_images($this, $data["product"]->id);

            //related products
            $data["related_products"] = $this->product_model->get_related_products($data["product"]->id, $data["product"]->category_id);

            $data["user"] = $this->auth_model->get_user($data["product"]->user_id);

            //user products
            $data["user_products"] = $this->product_model->get_more_products_by_user($data["user"]->id, $data["product"]->id);

            $data['reviews'] = $this->review_model->get_reviews($data["product"]->id);
            $data['review_count'] = item_count($data['reviews']);

            $data['comment_count'] = $this->comment_model->get_product_comment_count($data["product"]->id);
            $data['comments'] = $this->comment_model->get_comments($data["product"]->id, $this->comment_limit);
            $data['comment_limit'] = $this->comment_limit;
            $data["custom_fields"] = $this->field_model->get_custom_fields_by_category($data["product"]->category_id);
            $data["half_width_product_variations"] = $this->variation_model->get_half_width_product_variations($data["product"]->id);
            $data["full_width_product_variations"] = $this->variation_model->get_full_width_product_variations($data["product"]->id);

            $data["video"] = $this->file_model->get_product_video($data["product"]->id);
            $data["audio"] = $this->file_model->get_product_audio($data["product"]->id);

            $data["digital_sale"] = null;
            if ($data["product"]->product_type == 'digital' && $this->auth_check) {
                $data["digital_sale"] = get_digital_sale_by_buyer_id($this->auth_user->id, $data["product"]->id);
            }

            //shipping
            $data['shipping_status'] = $this->product_settings->marketplace_shipping;
            $data['product_location_status'] = $this->product_settings->marketplace_product_location;
            if ($data["product"]->listing_type == 'ordinary_listing' || $data["product"]->product_type != 'physical') {
                $data['shipping_status'] = 0;
            }
            if ($data["product"]->product_type == 'digital') {
                $data['product_location_status'] = 0;
            }

            $data["delivery_time"] = $this->shipping_model->get_shipping_delivery_time($data["product"]->shipping_delivery_time_id);

            $data['title'] = !empty($data['product_details']) ? $data['product_details']->title : '';
            $data['description'] = !empty($data['product_details']->seo_description) ? $data['product_details']->seo_description : $data['title'];
            $data['keywords'] = !empty($data['product_details']->seo_keywords) ? $data['product_details']->seo_keywords : '';

            //og tags
            $data['show_og_tags'] = true;
            $data['og_title'] = !empty($data['product_details']->seo_title) ? $data['product_details']->seo_title : $data['title'];
            $data['og_description'] = $data['description'];
            $data['og_type'] = "article";
            $data['og_url'] = generate_product_url($data['product']);
            $data['og_image'] = get_product_image($data['product']->id, 'image_default');
            $data['og_width'] = "750";
            $data['og_height'] = "500";
            if (!empty($data['user'])) {
                $data['og_creator'] = $data['user']->username;
                $data['og_author'] = $data['user']->username;
            } else {
                $data['og_creator'] = "";
                $data['og_author'] = "";
            }
            $data['og_published_time'] = $data['product']->created_at;
            $data['og_modified_time'] = $data['product']->created_at;

            $this->load->view('partials/_header', $data);
            $this->load->view('product/details/product', $data);
            $this->load->view('partials/_footer');
            //increase pageviews
            $this->product_model->increase_product_pageviews($data["product"]);
        }
    }

    /**
     * Load More Promoted Products
     */
    public function load_more_promoted_products()
    {
        post_method();
        $offset = clean_number($this->input->post('offset', true));
        $promoted_products = $this->product_model->get_promoted_products_limited($this->promoted_products_limit, $offset);

        $data_json = array(
            'result' => 0,
            'html_content' => "",
            'offset' => $offset + $this->promoted_products_limit,
            'hide_button' => 0,
        );
        $html_content = "";
        if (!empty($promoted_products)) {
            foreach ($promoted_products as $product) {
                $vars = array('product' => $product, 'promoted_badge' => false);
                $html_content .= '<div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">' . $this->load->view("product/_product_item", $vars, true) . '</div>';
            }
            $data_json['result'] = 1;
            $data_json['html_content'] = $html_content;
            if ($offset + $this->promoted_products_limit >= $this->product_model->get_promoted_products_count()) {
                $data_json['hide_button'] = 1;
            }
        }
        echo json_encode($data_json);
    }

    /**
     * Search
     */
    public function search()
    {
        get_method();
        $search = trim($this->input->get('search', TRUE));
        $search_type = $this->input->get('search_type', TRUE);
        $search = remove_special_characters($search);

        if (empty($search)) {
            redirect(lang_base_url());
        }
        
        if ($search_type == 'product') {
            redirect(generate_url("products") . '?search=' . $search);
        } else {
            redirect(generate_url("members") . '?search=' . $search);
        }
    }

    /**
     * Members
     */
    public function members()
    {
        get_method();
        $search = trim($this->input->get('search', TRUE));
        $search = remove_special_characters($search);

        if (empty($search)) {
            redirect(lang_base_url());
        }

        $data["members"] = $this->profile_model->search_members($search);

        $data['title'] = $search . " - " . trans("members");
        $data['description'] = $search . " - " . trans("members") . " - " . $this->app_name;
        $data['keywords'] = $search . ", " . trans("members") . "," . $this->app_name;
        
        $data['filter_search'] = $this->input->get("search");
        $data['search_type'] = "member";

        $this->load->view('partials/_header', $data);
        $this->load->view('members', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Select Membership Plan
     */
    public function select_membership_plan()
    {
        get_method();
        if ($this->general_settings->membership_plans_system != 1) {
            redirect(lang_base_url());
            exit();
        }
        //check auth
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if ($this->general_settings->email_verification == 1 && $this->auth_user->email_status != 1) {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(generate_url("settings", "update_profile"));
        }
        if ($this->auth_user->is_active_shop_request == 1) {
            redirect(generate_url("start_selling"));
        }
        $data['title'] = trans("select_your_plan");
        $data['description'] = trans("select_your_plan") . " - " . $this->app_name;
        $data['keywords'] = trans("select_your_plan") . "," . $this->app_name;
        $data['request_type'] = "new";
        $data["membership_plans"] = $this->membership_model->get_plans();
        $data['user_current_plan'] = $this->membership_model->get_user_plan_by_user_id($this->auth_user->id);
        $data['user_ads_count'] = $this->membership_model->get_user_ads_count($this->auth_user->id);

        $this->load->view('partials/_header', $data);
        $this->load->view('product/select_membership_plan', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Start Selling
     */
    public function start_selling()
    {
        get_method();
        //check auth
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (is_user_vendor()) {
            redirect(lang_base_url());
        }
        if ($this->general_settings->email_verification == 1 && $this->auth_user->email_status != 1) {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(generate_url("settings", "update_profile"));
        }

        $data['title'] = trans("start_selling");
        $data['description'] = trans("start_selling") . " - " . $this->app_name;
        $data['keywords'] = trans("start_selling") . "," . $this->app_name;
        if ($this->general_settings->membership_plans_system == 1) {
            if ($this->auth_user->is_active_shop_request != 1) {
                $plan_id = clean_number(input_get('plan'));
                if (empty($plan_id)) {
                    redirect(generate_url("select_membership_plan"));
                    exit();
                }
                $data['plan'] = $this->membership_model->get_plan($plan_id);
                if (empty($data['plan'])) {
                    redirect(generate_url("select_membership_plan"));
                    exit();
                }
            }
        }
        
        $data["states"] = $this->location_model->get_states_by_country($this->auth_user->country_id);
        $data["cities"] = $this->location_model->get_cities_by_state($this->auth_user->state_id);

        $this->load->view('partials/_header', $data);
        $this->load->view('product/start_selling', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Start Selling Post
     */
    public function start_selling_post()
    {
        post_method();
        //check auth
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data = array(
            'shop_name' => remove_special_characters($this->input->post('shop_name', true)),
            'first_name' => $this->input->post('first_name', true),
            'last_name' => $this->input->post('last_name', true),
            'phone_number' => $this->input->post('phone_number', true),
            'country_id' => $this->input->post('country_id', true),
            'state_id' => $this->input->post('state_id', true),
            'city_id' => $this->input->post('city_id', true),
            'about_me' => $this->input->post('about_me', true),
            'is_active_shop_request' => 1
        );

        //is shop name unique
        if (!$this->auth_model->is_unique_shop_name($data['shop_name'], $this->auth_user->id)) {
            $this->session->set_flashdata('form_data', $data);
            $this->session->set_flashdata('error', trans("msg_shop_name_unique_error"));
            redirect($this->agent->referrer());
        }

        if ($this->general_settings->membership_plans_system == 1) {
            $plan_id = clean_number($this->input->post('plan_id', true));
            if (empty($plan_id)) {
                redirect(generate_url("select_membership_plan"));
                exit();
            }
            $plan = $this->membership_model->get_plan($plan_id);
            if (empty($plan)) {
                redirect(generate_url("select_membership_plan"));
                exit();
            }
            if ($plan->is_free == 1) {
                if ($this->membership_model->add_shop_opening_requests($data)) {
                    $this->membership_model->add_user_free_plan($plan, $this->auth_user->id);
                    redirect(generate_url("start_selling"));
                    exit();
                } else {
                    $this->session->set_flashdata('error', trans("msg_error"));
                    redirect($this->agent->referrer());
                }
            } else {
                $data['is_active_shop_request'] = 0;
                if ($this->membership_model->add_shop_opening_requests($data)) {
                    //go to checkout
                    $this->session->set_userdata('modesy_selected_membership_plan_id', $plan->id);
                    $this->session->set_userdata('modesy_membership_request_type', "new");
                    redirect(generate_url("cart", "payment_method") . "?payment_type=membership");
                } else {
                    $this->session->set_flashdata('error', trans("msg_error"));
                    redirect($this->agent->referrer());
                }
            }

        } else {
            if ($this->membership_model->add_shop_opening_requests($data)) {
                //send email
                $this->membership_model->send_shop_opening_email();
                $this->session->set_flashdata('success', trans("msg_start_selling"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Renew Membership Plan
     */
    public function renew_membership_plan()
    {
        get_method();
        if ($this->general_settings->membership_plans_system != 1) {
            redirect(lang_base_url());
            exit();
        }
        if (!is_user_vendor()) {
            redirect(lang_base_url());
        }
        if ($this->general_settings->email_verification == 1 && $this->auth_user->email_status != 1) {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(generate_url("settings", "update_profile"));
        }
        $data['title'] = trans("select_your_plan");
        $data['description'] = trans("select_your_plan") . " - " . $this->app_name;
        $data['keywords'] = trans("select_your_plan") . "," . $this->app_name;
        $data['request_type'] = "renew";
        
        $data["membership_plans"] = $this->membership_model->get_plans();
        $data['user_current_plan'] = $this->membership_model->get_user_plan_by_user_id($this->auth_user->id);
        $data['user_ads_count'] = $this->membership_model->get_user_ads_count($this->auth_user->id);

        $this->load->view('partials/_header', $data);
        $this->load->view('product/select_membership_plan', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Renew Membership Plan Post
     */
    public function renew_membership_plan_post()
    {
        post_method();
        if (!is_user_vendor()) {
            redirect(lang_base_url());
        }
        if ($this->general_settings->email_verification == 1 && $this->auth_user->email_status != 1) {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(generate_url("settings", "update_profile"));
        }
        $plan_id = $this->input->post('plan_id');
        if (empty($plan_id)) {
            redirect($this->agent->referrer());
            exit();
        }
        $plan = $this->membership_model->get_plan($plan_id);
        if (empty($plan)) {
            redirect($this->agent->referrer());
            exit();
        }

        if ($plan->is_free == 1) {
            $this->membership_model->add_user_free_plan($plan, $this->auth_user->id);
            redirect(generate_dash_url("shop_settings"));
            exit();
        }

        $this->session->set_userdata('modesy_selected_membership_plan_id', $plan->id);
        $this->session->set_userdata('modesy_membership_request_type', "renew");
        redirect(generate_url("cart", "payment_method") . "?payment_type=membership");
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * BLOG PAGES
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Blog
     */
    public function blog()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('blog', $this->selected_lang->id);
        if (empty($page)) {
            redirect(lang_base_url());
            exit();
        }
        if ($page->visibility == 0) {
            $this->error_404();
        } else {
            $data['title'] = $page->title;
            $data['description'] = $page->description;
            $data['keywords'] = $page->keywords;
            $data["active_category"] = "all";
            
            //set pagination
            $blog_posts_count = $this->blog_model->get_posts_count();
            $pagination = $this->paginate(generate_url("blog"), $blog_posts_count, $this->blog_paginate_per_page);
            $data['posts'] = $this->blog_model->get_paginated_posts($pagination['offset'], $pagination['per_page'], $pagination['current_page']);

            $this->load->view('partials/_header', $data);
            $this->load->view('blog/index', $data);
            $this->load->view('partials/_footer');
        }
    }

    /**
     * Blog Category
     */
    public function blog_category($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $data["category"] = $this->blog_category_model->get_category_by_slug($slug);

        if (empty($data["category"])) {
            redirect(generate_url("blog"));
        }

        $data['title'] = $data["category"]->name;
        $data['description'] = $data["category"]->description;
        $data['keywords'] = $data["category"]->keywords;
        $data["active_category"] = $data["category"]->slug;
        
        //set pagination
        $blog_posts_count = $this->blog_model->get_posts_count_by_category($data["category"]->id);
        $pagination = $this->paginate(generate_url("blog") . '/' . $data["category"]->slug, $blog_posts_count, $this->blog_paginate_per_page);
        $data['posts'] = $this->blog_model->get_paginated_category_posts($pagination['offset'], $pagination['per_page'], $data["category"]->id, $pagination['current_page']);

        $this->load->view('partials/_header', $data);
        $this->load->view('blog/index', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Tag
     */
    public function tag($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $data['tag'] = $this->tag_model->get_post_tag($slug);

        if (empty($data['tag'])) {
            redirect(generate_url("blog"));
        }

        $data['title'] = $data['tag']->tag;
        $data['description'] = trans("tag") . ": " . $data['tag']->tag . " - " . $this->app_name;
        $data['keywords'] = trans("tag") . "," . $data['tag']->tag . "," . $this->app_name;
        //get paginated posts
        $pagination = $this->paginate(generate_url("blog", "tag") . "/" . $data['tag']->tag_slug, $this->blog_model->get_paginated_tag_posts_count($data['tag']->tag_slug), $this->blog_paginate_per_page);
        $data['posts'] = $this->blog_model->get_paginated_tag_posts($pagination['offset'], $pagination['per_page'], $data['tag']->tag_slug);
        
        $this->load->view('partials/_header', $data);
        $this->load->view('blog/tag', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Post
     */
    public function post($category_slug, $slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $data["post"] = $this->blog_model->get_post_by_slug($slug);

        if (empty($data["post"])) {
            redirect(generate_url("blog"));
        }

        $data['title'] = $data["post"]->title;
        $data['description'] = $data["post"]->summary;
        $data['keywords'] = $data["post"]->keywords;

        $data['related_posts'] = $this->blog_model->get_related_posts($data['post']->category_id, $data["post"]->id);
        $data['latest_posts'] = $this->blog_model->get_latest_posts(3);
        $data['random_tags'] = $this->tag_model->get_random_post_tags();
        $data['post_tags'] = $this->tag_model->get_post_tags($data["post"]->id);
        $data['comments'] = $this->comment_model->get_blog_comments($data["post"]->id, $this->comment_limit);
        $data['comments_count'] = $this->comment_model->get_blog_comment_count($data["post"]->id);
        $data['comment_limit'] = $this->comment_limit;
        $data['post_user'] = $this->auth_model->get_user($data['post']->user_id);
        $data["category"] = $this->blog_category_model->get_category($data['post']->category_id);
        
        //og tags
        $data['show_og_tags'] = true;
        $data['og_title'] = $data['post']->title;
        $data['og_description'] = $data['post']->summary;
        $data['og_type'] = "article";
        $data['og_url'] = generate_url("blog") . "/" . $data['post']->category_slug . "/" . $data['post']->slug;
        $data['og_image'] = get_blog_image_url($data['post'], 'image_default');
        $data['og_width'] = "750";
        $data['og_height'] = "500";
        if (!empty($data['post_user'])) {
            $data['og_creator'] = $data['post_user']->username;
            $data['og_author'] = $data['post_user']->username;
        } else {
            $data['og_creator'] = "";
            $data['og_author'] = "";
        }
        $data['og_published_time'] = $data['post']->created_at;
        $data['og_modified_time'] = $data['post']->created_at;
        $data['og_tags'] = $data['post_tags'];

        $this->load->view('partials/_header', $data);
        $this->load->view('blog/post', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Terms & Conditions
     */
    public function terms_conditions()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('terms_conditions', $this->selected_lang->id);
        if (empty($page)) {
            redirect(lang_base_url());
            exit();
        }
        if ($page->visibility == 0) {
            $this->error_404();
        } else {
            $data['title'] = $page->title;
            $data['description'] = $page->description . " - " . $this->app_name;
            $data['keywords'] = $page->keywords . " - " . $this->app_name;
            $data['page'] = $page;

            $this->load->view('partials/_header', $data);
            $this->load->view('page', $data);
            $this->load->view('partials/_footer');
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * REVIEWS
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Add Review
     */
    public function add_review_post()
    {
        if ($this->auth_check && $this->general_settings->reviews == 1) {
            $rating = $this->input->post('rating', true);
            $product_id = $this->input->post('product_id', true);
            $review_text = $this->input->post('review', true);
            $product = $this->product_model->get_product_by_id($product_id);
            if ($product->user_id != $this->auth_user->id) {
                $review = $this->review_model->get_review($product_id, $this->auth_user->id);
                if (!empty($review)) {
                    $this->review_model->update_review($review->id, $rating, $product_id, $review_text);
                } else {
                    $this->review_model->add_review($rating, $product_id, $review_text);
                }
            }
        }
        redirect($this->agent->referrer());
    }

    /**
     * Delete Review
     */
    public function delete_review()
    {
        $id = $this->input->post('id', true);
        $product_id = $this->input->post('product_id', true);
        $user_id = $this->input->post('user_id', true);
        $limit = $this->input->post('limit', true);

        $review = $this->review_model->get_review($product_id, $user_id);
        if ($this->auth_check && !empty($review)) {
            if ($this->auth_user->role == "admin" || $this->auth_user->id == $review->user_id) {
                $this->review_model->delete_review($id, $product_id);
            }
        }

        $data["product"] = $this->product_model->get_product_by_id($product_id);
        $data["reviews"] = $this->review_model->get_limited_reviews($product_id, $limit);

        $this->load->view('product/details/_make_review', $data);
    }

    /**
     * Guest Wishlist
     */
    public function guest_wishlist()
    {
        $data['title'] = trans("wishlist");
        $data['description'] = trans("wishlist") . " - " . $this->app_name;
        $data['keywords'] = trans("wishlist") . "," . $this->app_name;
        
        //set pagination
        $pagination = $this->paginate(generate_url("wishlist"), $this->product_model->get_guest_wishlist_products_count(), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_guest_wishlist_products($pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('guest_wishlist', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Unsubscribe
     */
    public function unsubscribe()
    {
        $data['title'] = trans("unsubscribe");
        $data['description'] = trans("unsubscribe");
        $data['keywords'] = trans("unsubscribe");

        $token = $this->input->get("token");
        $token = remove_special_characters($token);
        $subscriber = $this->newsletter_model->get_subscriber_by_token($token);

        if (empty($subscriber)) {
            redirect(lang_base_url());
        }
        $this->newsletter_model->unsubscribe_email($subscriber->email);

        $this->load->view('partials/_header', $data);
        $this->load->view('unsubscribe');
        $this->load->view('partials/_footer');
    }

    /**
     * Add to Subscribers
     */
    public function add_to_subscribers()
    {
        //input values
        $email = $this->input->post('email', true);

        if ($email) {
            //check if email exists
            if (empty($this->newsletter_model->get_subscriber($email))) {
                //addd
                if ($this->newsletter_model->add_to_subscribers($email)) {
                    $this->session->set_flashdata('news_success', trans("msg_newsletter_success"));
                }
            } else {
                $this->session->set_flashdata('news_error', trans("msg_newsletter_error"));
            }
        }
        redirect($this->agent->referrer() . "#newsletter");
    }

    public function cookies_warning()
    {
        setcookie('modesy_cookies_warning', '1', time() + (86400 * 10), "/"); //10 days
    }

    public function set_default_location()
    {
        $this->location_model->set_default_location();
        redirect($this->agent->referrer());
    }

    public function set_selected_currency()
    {
        $this->currency_model->set_selected_currency();
        redirect($this->agent->referrer());
    }

    public function error_404()
    {
        get_method();
        header("HTTP/1.0 404 Not Found");
        $data['title'] = "Error 404";
        $data['description'] = "Error 404";
        $data['keywords'] = "error,404";

        $this->load->view('partials/_header', $data);
        $this->load->view('errors/error_404');
        $this->load->view('partials/_footer');
    }
}
