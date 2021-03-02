<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    //update homepage manager settings
    public function update_homepage_manager_settings()
    {
        $data = array(
            'featured_categories' => $this->input->post('featured_categories', true),
            'index_promoted_products' => $this->input->post('index_promoted_products', true),
            'index_latest_products' => $this->input->post('index_latest_products', true),
            'index_blog_slider' => $this->input->post('index_blog_slider', true),
            'index_promoted_products_count' => $this->input->post('index_promoted_products_count', true),
            'index_latest_products_count' => $this->input->post('index_latest_products_count', true)
        );
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update settings
    public function update_settings()
    {
        $data = array(
            'site_title' => $this->input->post('site_title', true),
            'homepage_title' => $this->input->post('homepage_title', true),
            'site_description' => $this->input->post('site_description', true),
            'keywords' => $this->input->post('keywords', true),
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'whatsapp_url' => $this->input->post('whatsapp_url', true),
            'telegram_url' => $this->input->post('telegram_url', true),
            'youtube_url' => $this->input->post('youtube_url', true),
            'about_footer' => $this->input->post('about_footer', true),
            'contact_text' => $this->input->post('contact_text', false),
            'contact_address' => $this->input->post('contact_address', true),
            'contact_email' => $this->input->post('contact_email', true),
            'contact_phone' => $this->input->post('contact_phone', true),
            'copyright' => $this->input->post('copyright', true),
            'cookies_warning' => $this->input->post('cookies_warning', false),
            'cookies_warning_text' => $this->input->post('cookies_warning_text', false)
        );
        $lang_id = $this->input->post('lang_id', true);

        $this->db->where('lang_id', $lang_id);
        return $this->db->update('settings', $data);
    }

    //update general settings
    public function update_general_settings()
    {
        $data = array(
            'application_name' => $this->input->post('application_name', true),
            'custom_css_codes' => $this->input->post('custom_css_codes', false),
            'custom_javascript_codes' => $this->input->post('custom_javascript_codes', false),
            'facebook_comment_status' => $this->input->post('facebook_comment_status', false),
            'facebook_comment' => $this->input->post('facebook_comment', false)
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update recaptcha settings
    public function update_recaptcha_settings()
    {
        $data = array(
            'recaptcha_site_key' => $this->input->post('recaptcha_site_key', true),
            'recaptcha_secret_key' => $this->input->post('recaptcha_secret_key', true),
            'recaptcha_lang' => $this->input->post('recaptcha_lang', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);

    }

    //update maintenance mode settings
    public function update_maintenance_mode_settings()
    {
        $data = array(
            'maintenance_mode_title' => $this->input->post('maintenance_mode_title', true),
            'maintenance_mode_description' => $this->input->post('maintenance_mode_description', true),
            'maintenance_mode_status' => $this->input->post('maintenance_mode_status', true),
        );

        if (empty($data["maintenance_mode_status"])) {
            $data["maintenance_mode_status"] = 0;
        }

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);

    }

    //update email settings
    public function update_email_settings()
    {
        $data = array(
            'mail_library' => $this->input->post('mail_library', true),
            'mail_protocol' => $this->input->post('mail_protocol', true),
            'mail_title' => $this->input->post('mail_title', true),
            'mail_host' => $this->input->post('mail_host', true),
            'mail_port' => $this->input->post('mail_port', true),
            'mail_username' => $this->input->post('mail_username', true),
            'mail_password' => $this->input->post('mail_password', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update email verification
    public function update_email_verification()
    {
        $data = array(
            'email_verification' => $this->input->post('email_verification', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update email options
    public function update_email_options()
    {
        $data = array(
            'send_email_new_product' => $this->input->post('send_email_new_product', true),
            'send_email_buyer_purchase' => $this->input->post('send_email_buyer_purchase', true),
            'send_email_order_shipped' => $this->input->post('send_email_order_shipped', true),
            'send_email_contact_messages' => $this->input->post('send_email_contact_messages', true),
            'send_email_shop_opening_request' => $this->input->post('send_email_shop_opening_request', true),
            'send_email_bidding_system' => $this->input->post('send_email_bidding_system', true),
            'mail_options_account' => $this->input->post('mail_options_account', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update facebook login
    public function update_facebook_login()
    {
        $data = array(
            'facebook_app_id' => trim($this->input->post('facebook_app_id', true)),
            'facebook_app_secret' => trim($this->input->post('facebook_app_secret', true))
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update google login
    public function update_google_login()
    {
        $data = array(
            'google_client_id' => trim($this->input->post('google_client_id', true)),
            'google_client_secret' => trim($this->input->post('google_client_secret', true))
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update vk login
    public function update_vk_login()
    {
        $data = array(
            'vk_app_id' => trim($this->input->post('vk_app_id', true)),
            'vk_secure_key' => trim($this->input->post('vk_secure_key', true))
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update seo tools
    public function update_seo_tools()
    {
        $data_general = array(
            'google_analytics' => $this->input->post('google_analytics', false)
        );
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data_general);
    }

    //update payment gateway
    public function update_payment_gateway($name_key)
    {
        $gateway = $this->get_payment_gateway($name_key);
        if (!empty($gateway)) {
            $data = array(
                'public_key' => trim($this->input->post('public_key', true)),
                'secret_key' => trim($this->input->post('secret_key', true)),
                'environment' => !empty($this->input->post('environment', true)) ? $this->input->post('environment', true) : 'production',
                'locale' => !empty($this->input->post('locale', true)) ? $this->input->post('locale', true) : '',
                'status' => !empty($this->input->post('status', true)) ? 1 : 0,
            );
            if ($this->payment_settings->currency_converter == 1){
                $data['base_currency'] = $this->input->post('base_currency', true);
            }
            return $this->db->where('name_key', clean_str($name_key))->update('payment_gateways', $data);
        }
        return false;
    }

    //get payment gateway
    public function get_payment_gateway($name_key)
    {
        return $this->db->where('name_key', clean_slug($name_key))->get('payment_gateways')->row();
    }

    //get active payment gateways
    public function get_active_payment_gateways()
    {
        return $this->db->where('status', 1)->get('payment_gateways')->result();
    }

    //update bank transfer settings
    public function update_bank_transfer_settings()
    {
        $data = array(
            'bank_transfer_enabled' => $this->input->post('bank_transfer_enabled', true),
            'bank_transfer_accounts' => $this->input->post('bank_transfer_accounts', false)
        );

        $this->db->where('id', 1);
        return $this->db->update('payment_settings', $data);
    }

    //update cash on delivery settings
    public function update_cash_on_delivery_settings()
    {
        $data = array(
            'cash_on_delivery_enabled' => $this->input->post('cash_on_delivery_enabled', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('payment_settings', $data);
    }

    //update pricing settings
    public function update_pricing_settings()
    {
        $data = array(
            'price_per_day' => $this->input->post('price_per_day', true),
            'price_per_month' => $this->input->post('price_per_month', true),
            'free_product_promotion' => $this->input->post('free_product_promotion', true)
        );

        $data['price_per_day'] = get_price($data["price_per_day"], 'database');
        $data['price_per_month'] = get_price($data["price_per_month"], 'database');

        $this->db->where('id', 1);
        return $this->db->update('payment_settings', $data);
    }

    //update preferences
    public function update_preferences($form)
    {
        if ($form == 'homepage') {
            $data = array(
                'index_promoted_products' => $this->input->post('index_promoted_products', true),
            );
        } elseif ($form == 'general') {
            $data = array(
                'multilingual_system' => $this->input->post('multilingual_system', true),
                'rss_system' => $this->input->post('rss_system', true),
                'vendor_verification_system' => $this->input->post('vendor_verification_system', true),
                'hide_vendor_contact_information' => $this->input->post('hide_vendor_contact_information', true),
                'guest_checkout' => $this->input->post('guest_checkout', true),
                'location_search_header' => $this->input->post('location_search_header', true),
                'pwa_status' => $this->input->post('pwa_status', true)
            );
        } elseif ($form == 'products') {
            $data = array(
                'approve_before_publishing' => $this->input->post('approve_before_publishing', true),
                'promoted_products' => $this->input->post('promoted_products', true),
                'vendor_bulk_product_upload' => $this->input->post('vendor_bulk_product_upload', true),
                'show_sold_products' => $this->input->post('show_sold_products', true),
                'product_link_structure' => $this->input->post('product_link_structure', true)
            );
        } elseif ($form == 'reviews_comments') {
            $data = array(
                'reviews' => $this->input->post('reviews', true),
                'product_comments' => $this->input->post('product_comments', true),
                'blog_comments' => $this->input->post('blog_comments', true),
                'comment_approval_system' => $this->input->post('comment_approval_system', true)
            );
        }

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update visual settings
    public function update_visual_settings()
    {
        $data = array(
            'site_color' => $this->input->post('site_color', true)
        );

        $this->load->model('upload_model');
        $file_path = $this->upload_model->logo_upload('logo');
        if (!empty($file_path)) {
            $data["logo"] = $file_path;
        }

        $file_path = $this->upload_model->logo_upload('logo_email');
        if (!empty($file_path)) {
            $data["logo_email"] = $file_path;
        }

        $file_path = $this->upload_model->favicon_upload('favicon');
        if (!empty($file_path)) {
            $data["favicon"] = $file_path;
        }

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update watermark settings
    public function update_watermark_settings()
    {
        $data = array(
            'watermark_product_images' => $this->input->post('watermark_product_images', true),
            'watermark_blog_images' => $this->input->post('watermark_blog_images', true),
            'watermark_thumbnail_images' => $this->input->post('watermark_thumbnail_images', true),
            'watermark_vrt_alignment' => $this->input->post('watermark_vrt_alignment', true),
            'watermark_hor_alignment' => $this->input->post('watermark_hor_alignment', true)
        );
        //update watermark image
        $this->load->model('upload_model');
        $file_path = $this->upload_model->watermark_upload('watermark_image');
        if (!empty($file_path)) {
            //delete old watermarks
            delete_file_from_server($this->general_settings->watermark_image_large);
            delete_file_from_server($this->general_settings->watermark_image_mid);
            delete_file_from_server($this->general_settings->watermark_image_small);
            //upload new files
            $data['watermark_image_large'] = $file_path;
            $data['watermark_image_mid'] = $this->upload_model->resize_watermark($file_path, 300, 300);
            $data['watermark_image_small'] = $this->upload_model->resize_watermark($file_path, 100, 100);
        }

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update product cache system
    public function update_product_cache_system()
    {
        $data = array(
            'product_cache_system' => $this->input->post('product_cache_system', true),
            'refresh_cache_database_changes' => $this->input->post('refresh_cache_database_changes', true),
            'cache_refresh_time' => $this->input->post('cache_refresh_time', true) * 60
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update static content cache system
    public function update_static_content_cache_system()
    {
        $data = array(
            'static_content_cache_system' => $this->input->post('static_content_cache_system', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update storage settings
    public function update_storage_settings()
    {
        $data = array(
            'storage' => $this->input->post('storage', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('storage_settings', $data);
    }

    //update system settings
    public function update_system_settings()
    {
        $data = array(
            'physical_products_system' => $this->input->post('physical_products_system', true),
            'digital_products_system' => $this->input->post('digital_products_system', true),
            'marketplace_system' => $this->input->post('marketplace_system', true),
            'classified_ads_system' => $this->input->post('classified_ads_system', true),
            'bidding_system' => $this->input->post('bidding_system', true),
            'selling_license_keys_system' => $this->input->post('selling_license_keys_system', true),
            'multi_vendor_system' => $this->input->post('multi_vendor_system', true),
            'vat_status' => $this->input->post('vat_status', true),
            'commission_rate' => $this->input->post('commission_rate', true),
            'timezone' => trim($this->input->post('timezone', true))
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //get routes
    public function get_routes()
    {
        $query = $this->db->get('routes');
        return $query->result();
    }

    //update route settings
    public function update_route_settings()
    {
        $routes = $this->get_routes();
        if (!empty($routes)) {
            foreach ($routes as $route) {
                $data = array(
                    'route' => trim($this->input->post('route_' . $route->id, true))
                );
                $this->db->where('id', $route->id);
                $this->db->update('routes', $data);
            }
        }
        return true;
    }

    //update aws s3
    public function update_aws_s3()
    {
        $data = array(
            'aws_key' => trim($this->input->post('aws_key', true)),
            'aws_secret' => trim($this->input->post('aws_secret', true)),
            'aws_bucket' => trim($this->input->post('aws_bucket', true)),
            'aws_region' => trim($this->input->post('aws_region', true)),
            'aws_base_url' => trim($this->input->post('aws_base_url', true))
        );

        if (substr($data['aws_base_url'], -1) != '/') {
            $data['aws_base_url'] = $data['aws_base_url'] . '/';
        }

        $this->db->where('id', 1);
        return $this->db->update('storage_settings', $data);
    }

    //update navigation
    public function update_navigation()
    {
        $data = array(
            'menu_limit' => $this->input->post('menu_limit', true),
            'selected_navigation' => $this->input->post('navigation', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //get general settings
    public function get_general_settings()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('general_settings');
        return $query->row();
    }

    //get system settings
    public function get_system_settings()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('general_settings');
        return $query->row();
    }

    //get payment settings
    public function get_payment_settings()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('payment_settings');
        return $query->row();
    }

    //get storage settings
    public function get_storage_settings()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('storage_settings');
        return $query->row();
    }

    //get settings
    public function get_settings($lang_id)
    {
        return $this->db->where('lang_id', clean_number($lang_id))->get('settings')->row();
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * FONT SETTINGS
    *-------------------------------------------------------------------------------------------------
    */

    //get selected fonts
    public function get_selected_fonts()
    {
        $sql = "SELECT * FROM ((SELECT font_url AS site_font_url, font_family AS site_font_family FROM fonts WHERE id = ?) AS tbl_site, 
        (SELECT font_url AS dashboard_font_url, font_family AS dashboard_font_family FROM fonts WHERE id = ?) AS tbl_dashboard)";
        $query = $this->db->query($sql, array(clean_number($this->settings->site_font), clean_number($this->settings->dashboard_font)));
        return $query->row();
    }

    //get fonts
    public function get_fonts()
    {
        $query = $this->db->query("SELECT * FROM fonts ORDER BY font_name");
        return $query->result();
    }

    //get font
    public function get_font($id)
    {
        $sql = "SELECT * FROM fonts WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //add font
    public function add_font()
    {
        $data = array(
            'font_name' => $this->input->post('font_name', true),
            'font_url' => $this->input->post('font_url', false),
            'font_family' => $this->input->post('font_family', true),
            'is_default' => 0
        );
        return $this->db->insert('fonts', $data);
    }

    //set site font
    public function set_site_font()
    {
        $lang_id = $this->input->post('lang_id', true);
        $data = array(
            'site_font' => $this->input->post('site_font', true),
            'dashboard_font' => $this->input->post('dashboard_font', true)
        );
        $this->db->where('lang_id', clean_number($lang_id));
        return $this->db->update('settings', $data);
    }

    //update font
    public function update_font($id)
    {
        $data = array(
            'font_name' => $this->input->post('font_name', true),
            'font_url' => $this->input->post('font_url', false),
            'font_family' => $this->input->post('font_family', true)
        );
        $this->db->where('id', clean_number($id));
        return $this->db->update('fonts', $data);
    }

    //delete font
    public function delete_font($id)
    {
        $font = $this->get_font($id);
        if (!empty($font)) {
            $this->db->where('id', $font->id);
            return $this->db->delete('fonts');
        }
        return false;
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * FORM SETTINGS
    *-------------------------------------------------------------------------------------------------
    */

    //update product settings
    public function update_product_settings()
    {
        $submit = $this->input->post("submit", true);
        if ($submit == "marketplace") {
            $data = array(
                'marketplace_sku' => get_checkbox_value($this->input->post('marketplace_sku', true)),
                'marketplace_variations' => get_checkbox_value($this->input->post('marketplace_variations', true)),
                'marketplace_shipping' => get_checkbox_value($this->input->post('marketplace_shipping', true)),
                'marketplace_product_location' => get_checkbox_value($this->input->post('marketplace_product_location', true))
            );
        } elseif ($submit == "classified_ads") {
            $data = array(
                'classified_price' => get_checkbox_value($this->input->post('classified_price', true)),
                'classified_price_required' => get_checkbox_value($this->input->post('classified_price_required', true)),
                'classified_product_location' => get_checkbox_value($this->input->post('classified_product_location', true)),
                'classified_external_link' => get_checkbox_value($this->input->post('classified_external_link', true))
            );
        } elseif ($submit == "physical_products") {
            $data = array(
                'physical_demo_url' => get_checkbox_value($this->input->post('physical_demo_url', true)),
                'physical_video_preview' => get_checkbox_value($this->input->post('physical_video_preview', true)),
                'physical_audio_preview' => get_checkbox_value($this->input->post('physical_audio_preview', true))
            );
        } elseif ($submit == "digital_products") {
            $data = array(
                'digital_demo_url' => get_checkbox_value($this->input->post('digital_demo_url', true)),
                'digital_video_preview' => get_checkbox_value($this->input->post('digital_video_preview', true)),
                'digital_audio_preview' => get_checkbox_value($this->input->post('digital_audio_preview', true)),
                'digital_allowed_file_extensions' => ""
            );

            $ext_array = @explode(',', $this->input->post('digital_allowed_file_extensions', true));
            if (!empty($ext_array)) {
                $exts = json_encode($ext_array);
                $exts = str_replace('[', '', $exts);
                $exts = str_replace(']', '', $exts);
                $exts = str_replace('.', '', $exts);
                $exts = strtolower($exts);
                $data['digital_allowed_file_extensions'] = $exts;
            }
        } elseif ($submit == "file_upload") {
            $data = array(
                'max_file_size_image' => $this->input->post('max_file_size_image', true) * 1048576,
                'max_file_size_video' => $this->input->post('max_file_size_video', true) * 1048576,
                'max_file_size_audio' => $this->input->post('max_file_size_audio', true) * 1048576,
            );
            return $this->db->where('id', 1)->update('general_settings', $data);
        }
        if (!empty($data)) {
            return $this->db->where('id', 1)->update('product_settings', $data);
        }
        return false;
    }

    //get product settings
    public function get_product_settings()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('product_settings');
        return $query->row();
    }

    //delete old sessions
    function delete_old_sessions()
    {
        $this->db->query("DELETE FROM ci_sessions WHERE timestamp < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 3 DAY))");
    }
}
