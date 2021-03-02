<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Language_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'name' => $this->input->post('name', true),
            'short_form' => $this->input->post('short_form', true),
            'language_code' => $this->input->post('language_code', true),
            'language_order' => $this->input->post('language_order', true),
            'text_direction' => $this->input->post('text_direction', true),
            'text_editor_lang' => $this->input->post('text_editor_lang', true),
            'status' => $this->input->post('status', true)
        );
        return $data;
    }

    //add language
    public function add_language()
    {
        $data = $this->input_values();

        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file');
        if (!empty($temp_path)) {
            $data["flag_path"] = $this->upload_model->flag_upload($temp_path);
        } else {
            $data["flag_path"] = "";
        }

        if ($this->db->insert('languages', $data)) {
            $language_id = $this->db->insert_id();
            //insert translations
            $translations = $this->get_language_translations(1);
            if (!empty($translations)) {
                foreach ($translations as $translation) {
                    $data_translation = array(
                        'lang_id' => $language_id,
                        'label' => $translation->label,
                        'translation' => $translation->translation
                    );
                    $this->db->insert('language_translations', $data_translation);
                }
            }
            return $language_id;
        }
        return false;
    }

    //import language
    public function import_language()
    {
        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_file('file');
        if (!empty($temp_path)) {
            $json = file_get_contents($temp_path);
            if (!empty($json)) {
                $count = item_count($this->language_model->get_languages());
                $json_array = json_decode($json);
                $language = $json_array->language;
                //flag
                $flag = "";
                $temp_flag = $this->upload_model->upload_temp_image('flag');
                if (!empty($temp_flag)) {
                    $flag = $this->upload_model->flag_upload($temp_flag);
                }
                //add language
                if (isset($json_array->language)) {
                    $data = array(
                        'name' => isset($json_array->language->name) ? $json_array->language->name : 'language',
                        'short_form' => isset($json_array->language->short_form) ? $json_array->language->short_form : 'ln',
                        'language_code' => isset($json_array->language->language_code) ? $json_array->language->language_code : 'cd',
                        'text_direction' => isset($json_array->language->text_direction) ? $json_array->language->text_direction : 'ltr',
                        'text_editor_lang' => isset($json_array->language->text_editor_lang) ? $json_array->language->text_editor_lang : 'ln',
                        'status' => 1,
                        'language_order' => $count + 1,
                        'flag_path' => $flag
                    );
                    $this->db->insert('languages', $data);
                    $language_id = $this->db->insert_id();
                    //add language settings
                    $this->add_language_settings($language_id);
                    //add language pages
                    $this->add_language_pages($language_id);
                    //add translations
                    if (isset($json_array->translations)) {
                        foreach ($json_array->translations as $translation) {
                            $data_translation = array(
                                'lang_id' => $language_id,
                                'label' => $translation->label,
                                'translation' => $translation->translation
                            );
                            $this->db->insert('language_translations', $data_translation);
                        }
                    }
                }
            }
            @unlink($temp_flag);
            @unlink($temp_path);
            return true;
        }
        return false;
    }

    //export language
    public function export_language()
    {
        $lang_id = $this->input->post("lang_id");
        $language = $this->get_language($lang_id);
        if (!empty($language)) {
            $array_lang = array();
            $obj_lang = new stdClass();
            $obj_lang->name = $language->name;
            $obj_lang->short_form = $language->short_form;
            $obj_lang->language_code = $language->language_code;
            $obj_lang->text_direction = $language->text_direction;
            $obj_lang->text_editor_lang = $language->text_editor_lang;
            $array_lang['language'] = $obj_lang;
            //translations
            $this->db->select('label,translation');
            $this->db->where('lang_id', clean_number($lang_id));
            $this->db->order_by('id');
            $rows = $this->db->get('language_translations')->result();
            $array_lang['translations'] = $rows;

            $file_path = FCPATH . 'uploads/temp/' . $language->name . '.json';
            $json = json_encode($array_lang);
            $file = fopen($file_path, 'w+');
            fwrite($file, $json);
            fclose($file);
            if (file_exists($file_path)) {
                $this->load->helper('download');
                @force_download($file_path, NULL);
            }
            exit();
        }
    }

    //add language settings
    public function add_language_settings($lang_id)
    {
        //add settings
        $settings = array(
            'lang_id' => $lang_id,
            'site_font' => 19,
            'dashboard_font' => 22,
            'site_title' => "Modesy",
            'homepage_title' => "Index",
            'site_description ' => "Modesy",
            'keywords' => "modesy",
            'facebook_url' => "",
            'twitter_url' => "",
            'instagram_url' => "",
            'pinterest_url' => "",
            'linkedin_url' => "",
            'vk_url' => "",
            'whatsapp_url' => "",
            'telegram_url' => "",
            'youtube_url' => "",
            'about_footer' => "",
            'contact_text' => "",
            'contact_address' => "",
            'contact_email' => "",
            'contact_phone' => "",
            'copyright' => "",
            'cookies_warning' => 1,
            'cookies_warning_text' => "This site uses cookies. By continuing to browse the site you are agreeing to our use of cookies.",
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('settings', $settings);
    }

    //add language pages
    public function add_language_pages($lang_id)
    {
        $page_terms = array(
            'lang_id' => $lang_id,
            'title' => "Terms & Conditions",
            'slug' => "terms-conditions",
            'description' => "Terms & Conditions Page",
            'keywords' => "Terms, Conditions, Page",
            'page_content' => "",
            'page_order' => 1,
            'visibility' => 1,
            'title_active' => 1,
            'location' => "information",
            'is_custom' => 0,
            'page_default_name' => "terms_conditions",
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('pages', $page_terms);

        $page_contact = array(
            'lang_id' => $lang_id,
            'title' => "Contact",
            'slug' => "contact",
            'description' => "Contact Page",
            'keywords' => "Contact, Page",
            'page_content' => "",
            'page_order' => 1,
            'visibility' => 1,
            'title_active' => 1,
            'location' => "top_menu",
            'is_custom' => 0,
            'page_default_name' => "contact",
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('pages', $page_contact);

        $page_blog = array(
            'lang_id' => $lang_id,
            'title' => "Blog",
            'slug' => "blog",
            'description' => "Blog Page",
            'keywords' => "Blog, Page",
            'page_content' => "",
            'page_order' => 1,
            'visibility' => 1,
            'title_active' => 1,
            'location' => "quick_links",
            'is_custom' => 0,
            'page_default_name' => "blog",
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('pages', $page_blog);

    }

    //update language
    public function update_language($id)
    {
        $language = $this->get_language($id);
        if (!empty($language)) {
            $data = $this->input_values();

            $this->load->model('upload_model');
            $temp_path = $this->upload_model->upload_temp_image('file');
            if (!empty($temp_path)) {
                delete_file_from_server($language->flag_path);
                $data["flag_path"] = $this->upload_model->flag_upload($temp_path);
            }

            $this->db->where('id', clean_number($id));
            return $this->db->update('languages', $data);
        }
    }

    //get language
    public function get_language($id)
    {
        $sql = "SELECT * FROM languages WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get site language
    public function get_site_language($languages)
    {
        if (!empty($languages)) {
            foreach ($languages as $language) {
                if ($language->id == $this->general_settings->site_lang) {
                    return $language;
                }
            }
            foreach ($languages as $language) {
                return $language;
            }
        }
        $query = $this->db->query("SELECT * FROM languages ORDER BY id LIMIT 1");
        return $query->row();
    }

    //get languages
    public function get_languages()
    {
        $query = $this->db->query("SELECT * FROM languages ORDER BY language_order");
        return $query->result();
    }

    //get language translations
    public function get_language_translations($lang_id)
    {
        $sql = "SELECT * FROM language_translations WHERE lang_id = ?";
        $query = $this->db->query($sql, array(clean_number($lang_id)));
        return $query->result();
    }

    //get paginated translations
    public function get_paginated_translations($lang_id, $per_page, $offset)
    {
        $q = trim($this->input->get('q', true));
        if (!empty($q)) {
            $like = '%' . $q . '%';
            $sql = "SELECT * FROM language_translations WHERE lang_id = ? AND (label LIKE ? OR translation LIKE ?) ORDER BY id LIMIT ?, ?";
            $query = $this->db->query($sql, array(clean_number($lang_id), $like, $like, clean_number($offset), clean_number($per_page)));
        } else {
            $sql = "SELECT * FROM language_translations WHERE lang_id = ? ORDER BY id LIMIT ?, ?";
            $query = $this->db->query($sql, array(clean_number($lang_id), clean_number($offset), clean_number($per_page)));
        }
        return $query->result();
    }

    //get translations count
    public function get_translation_count($lang_id)
    {
        $q = trim($this->input->get('q', true));
        if (!empty($q)) {
            $like = '%' . $q . '%';
            $sql = "SELECT * FROM language_translations WHERE lang_id = ? AND (label LIKE ? OR translation LIKE ?)";
            $query = $this->db->query($sql, array(clean_number($lang_id), $like, $like));
        } else {
            $sql = "SELECT * FROM language_translations WHERE lang_id = ?";
            $query = $this->db->query($sql, array(clean_number($lang_id)));
        }
        return $query->num_rows();
    }

    //get active languages
    public function get_active_languages()
    {
        $query = $this->db->query("SELECT * FROM languages WHERE status = 1 ORDER BY language_order");
        return $query->result();
    }

    //set language
    public function set_language()
    {
        $data = array(
            'site_lang' => $this->input->post('site_lang', true),
        );

        $lang = $this->language_model->get_language($data["site_lang"]);

        if (!empty($lang)) {
            $this->db->where('id', 1);
            return $this->db->update('general_settings', $data);
        }

        return false;
    }

    //delete language
    public function delete_language($id)
    {
        $language = $this->get_language($id);
        if (!empty($language)) {
            //delete translations
            $sql = "SELECT * FROM language_translations WHERE lang_id = ?";
            $query = $this->db->query($sql, array(clean_number($language->id)));
            $translations = $query->result();
            if (!empty($translations)) {
                foreach ($translations as $translation) {
                    $this->db->where('id', $translation->id);
                    $this->db->delete('language_translations');
                }
            }
            //delete pages
            $this->db->where('lang_id', $language->id);
            $this->db->delete('pages');
            //delete flag
            delete_file_from_server($language->flag_path);
            //delete language
            $this->db->where('id', $language->id);
            return $this->db->delete('languages');
        } else {
            return false;
        }
    }

    //update translation
    public function update_translation($lang_id, $id, $translation)
    {
        $data = array(
            'translation' => $translation
        );
        $this->db->where('lang_id', clean_number($lang_id));
        $this->db->where('id', clean_number($id));
        $this->db->update('language_translations', $data);
    }
}
