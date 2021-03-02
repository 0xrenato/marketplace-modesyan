<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }

    public function index()
    {
        $data['title'] = trans("admin_panel");

        $data['order_count'] = $this->order_admin_model->get_all_orders_count();
        $data['product_count'] = $this->product_admin_model->get_products_count();
        $data['pending_product_count'] = $this->product_admin_model->get_pending_products_count();
        $data['blog_posts_count'] = $this->blog_model->get_all_posts_count();
        $data['members_count'] = $this->auth_model->get_users_count_by_role('member');
        $data['latest_orders'] = $this->order_admin_model->get_orders_limited(15);
        $data['latest_pending_products'] = $this->product_admin_model->get_latest_pending_products(15);
        $data['latest_products'] = $this->product_admin_model->get_latest_products(15);
        

        $data['latest_reviews'] = $this->review_model->get_latest_reviews(15);
        $data['latest_comments'] = $this->comment_model->get_latest_comments(15);
        $data['latest_members'] = $this->auth_model->get_latest_members(6);
        $data['latest_transactions'] = $this->transaction_model->get_transactions_limited(15);
        $data['latest_promoted_transactions'] = $this->transaction_model->get_promoted_transactions_limited(15);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/index');
        $this->load->view('admin/includes/_footer');
    }

    /*
    * Navigation
    */
    public function navigation()
    {
        $data['title'] = trans("navigation");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/navigation', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Navigation Post
     */
    public function navigation_post()
    {
        if ($this->settings_model->update_navigation()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /*
    * Homepage Manager
    */
    public function homepage_manager()
    {
        $data['title'] = trans("homepage_manager");
        $data['parent_categories'] = $this->category_model->get_parent_categories();
        $data['featured_categories'] = $this->category_model->get_featured_categories();
        $data['index_categories'] = $this->category_model->get_index_categories();
        $data['index_banners'] = $this->ad_model->get_index_banners_back_end();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/homepage_manager/homepage_manager', $data);
        $this->load->view('admin/includes/_footer');
    }

    /*
    * Homepage Manager Post
    */
    public function homepage_manager_post()
    {
        $submit = $this->input->post('submit', true);
        if ($this->input->is_ajax_request()) {
            $category_id = $this->input->post('category_id', true);
        } else {
            $category_id = get_dropdown_category_id();
        }
        if ($submit == "featured_categories") {
            $this->category_model->set_unset_featured_category($category_id);
        }
        if ($submit == "products_by_category") {
            $this->category_model->set_unset_index_category($category_id);
        }
        reset_cache_data($this, "st");
        if (!$this->input->is_ajax_request()) {
            redirect($this->agent->referrer());
        }
    }

    /*
    * Homepage Manager Settings Post
    */
    public function homepage_manager_settings_post()
    {
        $this->settings_model->update_homepage_manager_settings();
        $this->session->set_flashdata('success', trans("msg_updated"));
        $this->session->set_flashdata('msg_settings', 1);
        redirect($this->agent->referrer() . "#product_settings");
    }

    /*
    * Add Index Banner Post
    */
    public function add_index_banner_post()
    {
        if ($this->ad_model->add_index_banner()) {
            $this->session->set_flashdata('success', trans("msg_added"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('msg_banner', 1);
        redirect($this->agent->referrer() . "#form_banners");
    }


    /*
    * Edit Index Banner
    */
    public function edit_index_banner($id)
    {
        $data['title'] = trans("edit_banner");
        //get category
        $data['banner'] = $this->ad_model->get_index_banner($id);
        if (empty($data['banner'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/homepage_manager/edit_banner', $data);
        $this->load->view('admin/includes/_footer');
    }


    /*
    * Edit Index Banner Post
    */
    public function edit_index_banner_post()
    {
        $id = $this->input->post('id', true);
        if ($this->ad_model->edit_index_banner($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /*
    * Delete Index Banner Post
    */
    public function delete_index_banner_post()
    {
        $id = $this->input->post('id', true);
        $this->ad_model->delete_index_banner($id);
    }

    /*
    * Slider
    */
    public function slider()
    {
        $data['title'] = trans("slider_items");
        $data['slider_items'] = $this->slider_model->get_slider_items_all();
        $data['lang_search_column'] = 3;
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/slider/slider', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Slider Item Post
     */
    public function add_slider_item_post()
    {
        if ($this->slider_model->add_item()) {
            $this->session->set_flashdata('success_form', trans("msg_slider_added"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error_form', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Update Slider Item
     */
    public function update_slider_item($id)
    {
        $data['title'] = trans("update_slider_item");
        //get item
        $data['item'] = $this->slider_model->get_slider_item($id);

        if (empty($data['item'])) {
            redirect($this->agent->referrer());
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/slider/update_slider', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Slider Item Post
     */
    public function update_slider_item_post()
    {
        //item id
        $id = $this->input->post('id', true);
        if ($this->slider_model->update_item($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect(admin_url() . 'slider');
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Update Slider Settings Post
     */
    public function update_slider_settings_post()
    {
        if ($this->slider_model->update_slider_settings()) {
            $this->session->set_flashdata('success_form', trans("msg_updated"));
            $this->session->set_flashdata('msg_settings', 1);
        } else {
            $this->session->set_flashdata('error_form', trans("msg_error"));
            $this->session->set_flashdata('msg_settings', 1);
        }
        redirect($this->agent->referrer());
    }

    /**
     * Delete Slider Item Post
     */
    public function delete_slider_item_post()
    {
        $id = $this->input->post('id', true);
        if ($this->slider_model->delete_slider_item($id)) {
            $this->session->set_flashdata('success', trans("msg_slider_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * BIDDING SYSTEM
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Quote Requests
     */
    public function quote_requests()
    {
        $this->load->model('bidding_model');
        $data['title'] = trans("quote_requests");
        $data['form_action'] = admin_url() . "quote-requests";
        
        //get paginated requests
        $pagination = $this->paginate(admin_url() . 'quote-requests', $this->bidding_model->get_admin_quote_requests_count());
        $data['quote_requests'] = $this->bidding_model->get_admin_paginated_quote_requests($pagination['per_page'], $pagination['offset']);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/bidding/quote_requests', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Quote Request
     */
    public function delete_quote_request_post()
    {
        $this->load->model('bidding_model');
        $id = $this->input->post('id', true);
        if ($this->bidding_model->delete_admin_quote_request($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * NEWSLETTER
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Send Email to Subscribers
     */
    public function send_email_subscribers()
    {
        $data['title'] = trans("send_email_subscribers");
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter/send_email', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Newsletter Send Email Post
     */
    public function send_email_subscribers_post()
    {
        $this->load->model("email_model");

        $subject = $this->input->post('subject', true);
        $message = $this->input->post('message', false);

        $data['subscribers'] = $this->newsletter_model->get_subscribers();
        $result = false;
        if (!empty($data['subscribers'])) {
            $result = true;
            foreach ($data['subscribers'] as $item) {
                //send email
                if (!$this->email_model->send_email_newsletter($item, $subject, $message)) {
                    $result = false;
                }
            }
        }

        if ($result == true) {
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    /**
     * Subscribers
     */
    public function subscribers()
    {
        $data['title'] = trans("subscribers");
        $data['subscribers'] = $this->newsletter_model->get_subscribers();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter/subscribers', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Subscriber Post
     */
    public function delete_subscriber_post()
    {
        $id = $this->input->post('id', true);

        $data['subscriber'] = $this->newsletter_model->get_subscriber_by_id($id);

        if (empty($data['subscriber'])) {
            redirect($this->agent->referrer());
        }

        if ($this->newsletter_model->delete_from_subscribers($id)) {
            $this->session->set_flashdata('success', trans("msg_subscriber_deleted"));
            $this->session->set_flashdata("mes_subscriber_delete", 1);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_subscriber_delete", 1);
        }
    }


    /**
     * Contact Messages
     */
    public function contact_messages()
    {
        $data['title'] = trans("contact_messages");

        $data['messages'] = $this->contact_model->get_contact_messages();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/contact_messages', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Delete Contact Message Post
     */
    public function delete_contact_message_post()
    {
        $id = $this->input->post('id', true);

        if ($this->contact_model->delete_contact_message($id)) {
            $this->session->set_flashdata('success', trans("msg_message_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Ads
     */
    public function ad_spaces()
    {
        $data['title'] = trans("ad_spaces");

        $data['ad_space'] = $this->input->get('ad_space', true);

        if (empty($data['ad_space'])) {
            redirect(admin_url() . "ad-spaces?ad_space=index_1");
        }

        $data['ad_codes'] = $this->ad_model->get_ad_codes($data['ad_space']);
        if (empty($data['ad_codes'])) {
            redirect(admin_url() . "ad-spaces");
        }
        
        $data["array_ad_spaces"] = array(
            "index_1" => trans("index_ad_space_1"),
            "index_2" => trans("index_ad_space_2"),
            "products" => trans("products_ad_space"),
            "products_sidebar" => trans("products_sidebar_ad_space"),
            "product" => trans("product_ad_space"),
            "product_bottom" => trans("product_bottom_ad_space"),
            "blog_1" => trans("blog_ad_space_1"),
            "blog_2" => trans("blog_ad_space_2"),
            "blog_post_details" => trans("blog_post_details_ad_space"),
            "blog_post_details_sidebar" => trans("blog_post_details_sidebar_ad_space"),
            "profile" => trans("profile_ad_space"),
            "profile_sidebar" => trans("profile_sidebar_ad_space"),
        );

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/ad_spaces', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Ads Post
     */
    public function ad_spaces_post()
    {
        $ad_space = $this->input->post('ad_space', true);

        if ($this->ad_model->update_ad_spaces($ad_space)) {
            reset_cache_data($this, "st");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Google Adsense Code Post
     */
    public function google_adsense_code_post()
    {
        if ($this->ad_model->update_google_adsense_code()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('mes_adsense', 1);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('mes_adsense', 1);
        }
        redirect($this->agent->referrer());
    }

    /*
    * Seo Tools
    */
    public function seo_tools()
    {
        $data['title'] = trans("seo_tools");
        $data["current_lang_id"] = $this->input->get("lang", true);

        if (empty($data["current_lang_id"])) {
            $data["current_lang_id"] = $this->general_settings->site_lang;
            redirect(admin_url() . "seo-tools?lang=" . $data["current_lang_id"]);
        }
        
        $data['settings'] = $this->settings_model->get_settings($data["current_lang_id"]);
        $data['languages'] = $this->language_model->get_languages();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/seo_tools', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Seo Tools Post
     */
    public function seo_tools_post()
    {
        if ($this->settings_model->update_seo_tools()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * CURRENCY SETTINGS
    *-------------------------------------------------------------------------------------------------
    */


    /*
    * Currency Settings
    */
    public function currency_settings()
    {
        $data['title'] = trans("currency_settings");
        $data['currencies'] = $this->currency_model->get_currencies();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/currency/currency_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /*
    * Currency Settings Post
    */
    public function currency_settings_post()
    {
        if ($this->currency_model->update_currency_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('msg_settings', 1);
        redirect($this->agent->referrer());
    }

    /*
    * Currency Converter Post
    */
    public function currency_converter_post()
    {
        if ($this->currency_model->update_currency_converter_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('msg_converter', 1);
        redirect($this->agent->referrer());
    }

    /**
     * Add Currency
     */
    public function add_currency()
    {
        $data['title'] = trans("add_currency");
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/currency/add_currency', $data);
        $this->load->view('admin/includes/_footer');
    }

    /*
    * Add Currency Post
    */
    public function add_currency_post()
    {
        if ($this->currency_model->add_currency()) {
            $this->session->set_flashdata('msg_add', 1);
            $this->session->set_flashdata('success', trans("msg_added"));
        } else {
            $this->session->set_flashdata('msg_add', 1);
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Update Currency
     */
    public function update_currency($id)
    {
        $data['title'] = trans("update_currency");

        $data['currency'] = $this->currency_model->get_currency($id);

        //page not found
        if (empty($data['currency'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/currency/update_currency', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Edit Currency Rate
     */
    public function edit_currency_rate()
    {
        $this->currency_model->edit_currency_rate();
    }

    /**
     * Update Currency Post
     */
    public function update_currency_post()
    {
        $id = $this->input->post('id', true);

        if ($this->currency_model->update_currency($id)) {
            $this->session->set_flashdata('msg_table', 1);
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect(admin_url() . "currency-settings");
        } else {
            $this->session->set_flashdata('msg_table', 1);
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    // Update Currency Rates
    public function update_currency_rates()
    {
        if ($this->currency_model->update_currency_rates()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('msg_table', 1);
        redirect($this->agent->referrer());
    }

    /*
    * Delete Currency Post
    */
    public function delete_currency_post()
    {
        $id = $this->input->post('id', true);
        if ($this->currency_model->delete_currency($id)) {
            $this->session->set_flashdata('msg_table', 1);
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('msg_table', 1);
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * ABUSE REPORTS
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Abuse Reports
     */
    public function abuse_reports()
    {
        $data['title'] = trans("abuse_reports");

        $data['num_rows'] = $this->review_model->get_abuse_reports_count();
        $pagination = $this->paginate(admin_url() . "abuse-reports", $data['num_rows']);
        $data['abuse_reports'] = $this->review_model->get_paginated_abuse_reports($pagination['per_page'], $pagination['offset']);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/abuse_reports', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Abuse Report
     */
    public function delete_abuse_report_post()
    {
        $id = $this->input->post('id', true);
        if ($this->review_model->delete_abuse_report($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * EMAIL SETTINGS
    *-------------------------------------------------------------------------------------------------
    */

    /*
    * Email Settings
    */
    public function email_settings()
    {
        $data['title'] = trans("email_settings");

        $data['general_settings'] = $this->settings_model->get_general_settings();
        
        $data["library"] = $this->input->get('library');
        if (empty($data["library"])) {
            $data["library"] = "swift";
            if (!empty($this->general_settings->mail_library)) {
                $data["library"] = $this->general_settings->mail_library;
            }
            redirect(admin_url() . "email-settings?library=" . $data["library"]);
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/email_settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Email Settings Post
     */
    public function email_settings_post()
    {
        if ($this->settings_model->update_email_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('submit', $this->input->post('submit', true));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('submit', $this->input->post('submit', true));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Email Verification Post
     */
    public function email_verification_post()
    {
        if ($this->settings_model->update_email_verification()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('submit', "verification");
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('submit', "verification");
            redirect($this->agent->referrer());
        }
    }

    /**
     * Email Options Post
     */
    public function email_options_post()
    {
        if ($this->settings_model->update_email_options()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('submit', "options");
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('submit', "options");
            redirect($this->agent->referrer());
        }
    }

    /**
     * Send Test Email Post
     */
    public function send_test_email_post()
    {
        $email = $this->input->post('email', true);
        $subject = "Modesy Test Email";
        $message = "<p>This is a test email.</p>";
        $this->load->model("email_model");
        $this->session->set_flashdata('submit', "send_email");
        if (!empty($email)) {
            if (!$this->email_model->send_test_email($email, $subject, $message)) {
                redirect($this->agent->referrer());
                exit();
            }
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * FORM SETTINGS
    *-------------------------------------------------------------------------------------------------
    */

    /*
    * Visual Settings
    */
    public function visual_settings()
    {
        $data['title'] = trans("visual_settings");
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/visual_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Visual Settings Post
     */
    public function visual_settings_post()
    {
        if ($this->settings_model->update_visual_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Update Watermak Category
     */
    public function update_watermark_settings_post()
    {
        $this->settings_model->update_watermark_settings();
        redirect($this->agent->referrer());
    }

    /**
     * Delete Category Watermak
     */
    public function delete_category_watermark_post()
    {
        $this->settings_model->delete_category_watermark();
        redirect($this->agent->referrer());
    }


    /*
    * System Settings
    */
    public function system_settings()
    {
        $data['title'] = trans("system_settings");
        
        $data['system_settings'] = $this->settings_model->get_system_settings();
        $data['currencies'] = $this->currency_model->get_currencies();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/system_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * System Settings Post
     */
    public function system_settings_post()
    {
        //check product type
        $physical_products_system = $this->input->post('physical_products_system', true);
        $digital_products_system = $this->input->post('digital_products_system', true);
        if ($physical_products_system == 0 && $digital_products_system == 0) {
            $this->session->set_flashdata('error', trans("msg_error_product_type"));
            redirect($this->agent->referrer());
            exit();
        }

        $marketplace_system = $this->input->post('marketplace_system', true);
        $classified_ads_system = $this->input->post('classified_ads_system', true);
        $bidding_system = $this->input->post('bidding_system', true);
        if ($marketplace_system == 0 && $classified_ads_system == 0 && $bidding_system == 0) {
            $this->session->set_flashdata('error', trans("msg_error_selected_system"));
            redirect($this->agent->referrer());
            exit();
        }

        if ($this->settings_model->update_system_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
    * Social Login Settings
    */
    public function social_login_settings()
    {
        $data['title'] = trans("social_login");
        
        $data['general_settings'] = $this->settings_model->get_general_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/social_login', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Facebook Login Post
     */
    public function facebook_login_post()
    {
        if ($this->settings_model->update_facebook_login()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_social_facebook", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_social_facebook", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Google Login Post
     */
    public function google_login_post()
    {
        if ($this->settings_model->update_google_login()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_social_google", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_social_google", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Google Login Post
     */
    public function social_login_vk_post()
    {
        if ($this->settings_model->update_vk_login()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_social_vk", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_social_vk", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Storage
     */
    public function storage()
    {
        $data['title'] = trans("storage");
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/storage', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Storage Post
     */
    public function storage_post()
    {
        if ($this->settings_model->update_storage_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * AWS S3 Post
     */
    public function aws_s3_post()
    {
        if ($this->settings_model->update_aws_s3()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('mes_s3', 1);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Cache System
     */
    public function cache_system()
    {
        $data['title'] = trans("cache_system");
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/cache_system', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Product Cache System Post
     */
    public function product_cache_system_post()
    {
        if ($this->input->post('action', true) == "reset") {
            reset_cache_data($this, "pr", true);
            $this->session->set_flashdata('success', trans("msg_reset_cache"));
        } else {
            if ($this->settings_model->update_product_cache_system()) {
                $this->session->set_flashdata('success', trans("msg_updated"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
        redirect($this->agent->referrer());
    }

    /**
     * Static Content Cache System Post
     */
    public function static_content_cache_system_post()
    {
        if ($this->input->post('action', true) == "reset") {
            reset_cache_data($this, "st", true);
            $this->session->set_flashdata('success', trans("msg_reset_cache"));
        } else {
            if ($this->settings_model->update_static_content_cache_system()) {
                $this->session->set_flashdata('success', trans("msg_updated"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
        $this->session->set_flashdata('msg_category', 1);
        redirect($this->agent->referrer());
    }

    /**
     * Preferences
     */
    public function preferences()
    {
        $data['title'] = trans("preferences");
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/preferences', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Preferences Post
     */
    public function preferences_post()
    {
        $form = $this->input->post('submit', true);
        $this->session->set_flashdata('mes_' . $form, 1);
        if ($this->settings_model->update_preferences($form)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            //reset cache
            redirect(admin_url() . "preferences");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
     * Settings
     */
    public function settings()
    {
        $data['title'] = trans("settings");

        $data["settings_lang"] = $this->input->get("lang", true);
        if (empty($data["settings_lang"])) {
            $data["settings_lang"] = $this->selected_lang->id;
            redirect(admin_url() . "settings?lang=" . $data["settings_lang"]);
        }
        
        $data['settings'] = $this->settings_model->get_settings($data["settings_lang"]);
        $data['general_settings'] = $this->settings_model->get_general_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Settings Post
     */
    public function settings_post()
    {
        if ($this->settings_model->update_settings()) {
            $this->settings_model->update_general_settings();
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_settings", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_settings", 1);
            redirect($this->agent->referrer());
        }
    }


    /**
     * Recaptcha Settings Post
     */
    public function recaptcha_settings_post()
    {
        if ($this->settings_model->update_recaptcha_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_recaptcha", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_recaptcha", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Maintenance Mode Post
     */
    public function maintenance_mode_post()
    {
        if ($this->settings_model->update_maintenance_mode_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_maintenance", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_maintenance", 1);
            redirect($this->agent->referrer());
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * LOCATION
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Countries
     */
    public function countries()
    {
        $data['title'] = trans("countries");
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'countries', $this->location_model->get_paginated_countries_count());
        $data['countries'] = $this->location_model->get_paginated_countries($pagination['per_page'], $pagination['offset']);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/countries', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Country
     */
    public function add_country()
    {
        $data['title'] = trans("add_country");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/add_country', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Country Post
     */
    public function add_country_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            if ($this->location_model->add_country()) {
                reset_cache_data($this, "st");
                $this->session->set_flashdata('success', trans("msg_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update Country
     */
    public function update_country($id)
    {
        $data['title'] = trans("update_country");

        //get country
        $data['country'] = $this->location_model->get_country($id);
        if (empty($data['country'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/update_country', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Country Post
     */
    public function update_country_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            //country id
            $id = $this->input->post('id', true);
            if ($this->location_model->update_country($id)) {
                reset_cache_data($this, "st");
                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect(admin_url() . 'countries');
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Delete Country Post
     */
    public function delete_country_post()
    {
        $id = $this->input->post('id', true);
        if ($this->location_model->delete_country($id)) {
            reset_cache_data($this, "st");
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * States
     */
    public function states()
    {
        $data['title'] = trans("states");
        $data['countries'] = $this->location_model->get_countries();
        //get paginated states
        $pagination = $this->paginate(admin_url() . 'states', $this->location_model->get_paginated_states_count());
        $data['states'] = $this->location_model->get_paginated_states($pagination['per_page'], $pagination['offset']);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/states', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add State
     */
    public function add_state()
    {
        $data['title'] = trans("add_state");
        $data['countries'] = $this->location_model->get_countries();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/add_state', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add State Post
     */
    public function add_state_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            if ($this->location_model->add_state()) {
                reset_cache_data($this, "st");
                $this->session->set_flashdata('success', trans("msg_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update State
     */
    public function update_state($id)
    {
        $data['title'] = trans("update_state");

        //get state
        $data['state'] = $this->location_model->get_state($id);
        if (empty($data['state'])) {
            redirect($this->agent->referrer());
        }
        $data['countries'] = $this->location_model->get_countries();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/update_state', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update State Post
     */
    public function update_state_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            //country id
            $id = $this->input->post('id', true);
            if ($this->location_model->update_state($id)) {
                reset_cache_data($this, "st");
                $this->session->set_flashdata('success', trans("msg_updated"));
                $redirect_url = $this->input->post('redirect_url', true);
                if (!empty($redirect_url)) {
                    redirect($redirect_url);
                } else {
                    redirect(admin_url() . 'states');
                }
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete State Post
     */
    public function delete_state_post()
    {
        $id = $this->input->post('id', true);
        if ($this->location_model->delete_state($id)) {
            reset_cache_data($this, "st");
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Cities
     */
    public function cities()
    {
        $data['title'] = trans("cities");
        $data['countries'] = $this->location_model->get_countries();
        $data['states'] = $this->location_model->get_states();
        //get paginated cities
        $pagination = $this->paginate(admin_url() . 'cities', $this->location_model->get_paginated_cities_count());
        $data['cities'] = $this->location_model->get_paginated_cities($pagination['per_page'], $pagination['offset']);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/cities', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Cities
     */
    public function add_city()
    {
        $data['title'] = trans("add_city");
        $data['countries'] = $this->location_model->get_countries();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/add_city', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add City Post
     */
    public function add_city_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            if ($this->location_model->add_city()) {
                reset_cache_data($this, "st");
                $this->session->set_flashdata('success', trans("msg_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update City
     */
    public function update_city($id)
    {
        $data['title'] = trans("update_city");

        //get city
        $data['city'] = $this->location_model->get_city($id);
        if (empty($data['city'])) {
            redirect($this->agent->referrer());
        }
        $data['countries'] = $this->location_model->get_countries();
        $data['states'] = $this->location_model->get_states_by_country($data['city']->country_id);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/update_city', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update City Post
     */
    public function update_city_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            //country id
            $id = $this->input->post('id', true);
            if ($this->location_model->update_city($id)) {
                reset_cache_data($this, "st");
                $this->session->set_flashdata('success', trans("msg_updated"));
                $redirect_url = $this->input->post('redirect_url', true);
                if (!empty($redirect_url)) {
                    redirect($redirect_url);
                } else {
                    redirect(admin_url() . 'cities');
                }
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete City Post
     */
    public function delete_city_post()
    {
        $id = $this->input->post('id', true);
        if ($this->location_model->delete_city($id)) {
            reset_cache_data($this, "st");
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    //activate inactivate countries
    public function activate_inactivate_countries()
    {
        $action = $this->input->post('action', true);
        $this->location_model->activate_inactivate_countries($action);
        reset_cache_data($this, "st");
    }

    /**
     * Control Panel Language Post
     */
    public function control_panel_language_post()
    {
        $lang_id = $this->input->post('lang_id', true);
        $lang = $this->language_model->get_language($lang_id);
        if (!empty($lang)) {
            $this->session->set_userdata('mds_control_panel_lang', $lang);
        }
        redirect($this->agent->referrer());
    }
}
