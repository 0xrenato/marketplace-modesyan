<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ad_model extends CI_Model
{
    public function input_values()
    {
        $data = array(
            'ad_code_728' => $this->input->post('ad_code_728', false),
            'ad_code_468' => $this->input->post('ad_code_468', false),
            'ad_code_250' => $this->input->post('ad_code_250', false),
        );

        return $data;
    }

    public function input_url_values()
    {
        $data = array(
            'url_ad_code_728' => $this->input->post('url_ad_code_728', false),
            'url_ad_code_468' => $this->input->post('url_ad_code_468', false),
            'url_ad_code_250' => $this->input->post('url_ad_code_250', false),
        );

        return $data;
    }

    public function update_ad_spaces($ad_space)
    {
        $data = $this->input_values();
        $data_url = $this->input_url_values();

        if ($ad_space == "product_sidebar" || $ad_space == "products_sidebar" || $ad_space == "blog_post_details_sidebar" || $ad_space == "profile_sidebar") {

            $data["ad_code_300"] = $this->input->post('ad_code_300', false);
            $url_ad_code_300 = $this->input->post('url_ad_code_300', false);

            $this->load->model('upload_model');
            $file_path = $this->upload_model->ad_upload('file_ad_code_300');
            if (!empty($file_path)) {
                $data["ad_code_300"] = $this->create_ad_code($url_ad_code_300, $file_path);
            }
        } else {

            $this->load->model('upload_model');
            $file_path = $this->upload_model->ad_upload('file_ad_code_728');
            if (!empty($file_path)) {
                $data["ad_code_728"] = $this->create_ad_code($data_url["url_ad_code_728"], $file_path);
            }
            $file_path = $this->upload_model->ad_upload('file_ad_code_468');
            if (!empty($file_path)) {
                $data["ad_code_468"] = $this->create_ad_code($data_url["url_ad_code_468"], $file_path);
            }
        }

        $this->load->model('upload_model');
        $file_path = $this->upload_model->ad_upload('file_ad_code_250');
        if (!empty($file_path)) {
            $data["ad_code_250"] = $this->create_ad_code($data_url["url_ad_code_250"], $file_path);
        }

        $this->db->where('ad_space', $ad_space);
        return $this->db->update('ad_spaces', $data);
    }

    //get ads
    public function get_ads()
    {
        $key = "ad_spaces";
        $result = get_cached_data($this, $key, "st");
        if (!empty($result)) {
            return $result;
        }

        $query = $this->db->get('ad_spaces');
        $result = $query->result();

        set_cache_data($this, $key, $result, "st");
        return $result;
    }

    //get ad codes
    public function get_ad_codes($ad_space)
    {
        $this->db->where('ad_space', $ad_space);
        $query = $this->db->get('ad_spaces');
        return $query->row();
    }

    //create ad code
    public function create_ad_code($url, $image_path)
    {
        return '<a href="' . $url . '"><img src="' . base_url() . $image_path . '" alt=""></a>';
    }

    //update google adsense code
    public function update_google_adsense_code()
    {
        $data = array(
            'google_adsense_code' => $this->input->post('google_adsense_code', false)
        );
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * INDEX BANNERS
    *-------------------------------------------------------------------------------------------------
    */

    //add index banner
    public function add_index_banner()
    {
        $data = array(
            'banner_url' => add_https($this->input->post('banner_url', true)),
            'banner_order' => $this->input->post('banner_order', true),
            'banner_width' => $this->input->post('banner_width', true),
            'banner_location' => $this->input->post('banner_location', true)
        );
        if ($data["banner_width"] > 100) {
            $data["banner_width"] = 100;
        }
        $this->load->model('upload_model');
        $file_path = $this->upload_model->ad_upload('file');
        if (!empty($file_path)) {
            $data["banner_image_path"] = $file_path;
        }
        return $this->db->insert('homepage_banners', $data);
    }

    //edit index banner
    public function edit_index_banner($id)
    {
        $banner = $this->get_index_banner($id);
        if (!empty($banner)) {
            $data = array(
                'banner_url' => add_https($this->input->post('banner_url', true)),
                'banner_order' => $this->input->post('banner_order', true),
                'banner_width' => $this->input->post('banner_width', true),
                'banner_location' => $this->input->post('banner_location', true)
            );
            if ($data["banner_width"] > 100) {
                $data["banner_width"] = 100;
            }
            $this->load->model('upload_model');
            $file_path = $this->upload_model->ad_upload('file');
            if (!empty($file_path)) {
                $data["banner_image_path"] = $file_path;
            }
            $this->db->where('id', $banner->id);
            return $this->db->update('homepage_banners', $data);
        }
        return false;
    }

    //get index banner
    public function get_index_banner($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->get('homepage_banners')->row();
    }

    //get index banners
    public function get_index_banners()
    {
        $this->db->order_by('banner_order');
        return $this->db->get('homepage_banners')->result();
    }

    //get index banners array
    public function get_index_banners_array()
    {
        $banners = $this->get_index_banners();
        $array = array();
        if (!empty($banners)) {
            foreach ($banners as $banner) {
                @$array[$banner->banner_location][] = $banner;
            }
        }
        return $array;
    }

    //get index banners back end
    public function get_index_banners_back_end()
    {
        $this->db->order_by('id');
        return $this->db->get('homepage_banners')->result();
    }

    //delete index banner
    public function delete_index_banner($id)
    {
        $banner = $this->get_index_banner($id);
        if (!empty($banner)) {
            delete_file_from_server($banner->banner_image_path);
            $this->db->where('id', $banner->id);
            return $this->db->delete('homepage_banners');
        }
        return false;
    }

}
