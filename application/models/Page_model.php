<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'title' => $this->input->post('title', true),
            'slug' => $this->input->post('slug', true),
            'description' => $this->input->post('description', true),
            'keywords' => $this->input->post('keywords', true),
            'page_content' => $this->input->post('page_content', false),
            'page_order' => $this->input->post('page_order', true),
            'visibility' => $this->input->post('visibility', true),
            'title_active' => $this->input->post('title_active', true),
            'location' => $this->input->post('location', true)
        );
        return $data;
    }

    //add page
    public function add()
    {
        $data = $this->page_model->input_values();
        if (empty($data["slug"])) {
            //slug for title
            $data["slug"] = str_slug($data["title"]);
        }
        $data["created_at"] = date('Y-m-d H:i:s');

        return $this->db->insert('pages', $data);
    }

    //update page
    public function update($id)
    {
        $page = $this->get_page_by_id($id);
        if (!empty($page)) {
            //set values
            $data = $this->page_model->input_values();

            $this->db->where('id', $id);
            return $this->db->update('pages', $data);
        }
        return false;
    }

    //update slug
    public function update_slug($id)
    {
        $page = $this->get_page_by_id($id);
        if (empty($page)) {
            if (empty($page->slug) || $page->slug == "-") {
                $data = array(
                    'slug' => $page->id
                );
                $this->db->where('id', $id);
                return $this->db->update('pages', $data);
            } else {
                if (!empty($this->check_page_slug($page->slug, $id))) {
                    $data = array(
                        'slug' => $page->slug . "-" . $page->id
                    );
                    $this->db->where('id', $id);
                    return $this->db->update('pages', $data);
                }
            }
        }
    }

    //check page slug
    public function check_page_slug($slug, $id, $lang_id)
    {
        $this->db->where('slug', remove_special_characters($slug))->where('id !=', clean_number($id));
        return $this->db->get('pages')->row();
    }

    //check page slug for product
    public function check_page_slug_for_product($slug)
    {
        $slug = remove_special_characters($slug);
        $this->db->where('slug', $slug);
        $query = $this->db->get('pages');
        return $query->row();
    }

    //get pages
    public function get_pages()
    {
        $this->db->where('pages.lang_id', $this->selected_lang->id);
        $this->db->order_by('page_order');
        $query = $this->db->get('pages');
        return $query->result();
    }

    //get all pages
    public function get_pages_all()
    {
        $this->db->order_by('page_order');
        $query = $this->db->get('pages');
        return $query->result();
    }

    //get page
    public function get_page($slug)
    {
        $slug = remove_special_characters($slug);
        $this->db->where('slug', $slug);
        $this->db->where('visibility', 1);
        $this->db->where('pages.lang_id', $this->selected_lang->id);
        $query = $this->db->get('pages');
        return $query->row();
    }

    //get page by default name
    public function get_page_by_default_name($default_name, $lang_id)
    {
        $this->db->where('page_default_name', clean_str($default_name))->where('visibility', 1)->where('lang_id', clean_number($lang_id));
        return $this->db->get('pages')->row();
    }

    //get page by id
    public function get_page_by_id($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('pages');
        return $query->row();
    }

    //get menu links
    public function get_menu_links($lang_id)
    {
        $key = "pages_" . $this->selected_lang->id;
        $result = get_cached_data($this, $key, "st");
        if (!empty($result)) {
            return $result;
        }
        $this->db->select('id, title, slug, page_order, location, page_default_name')->where('lang_id', clean_number($lang_id))->where('visibility', 1);
        $this->db->order_by('page_order');
        $result = $this->db->get('pages')->result();

        set_cache_data($this, $key, $result, "st");
        return $result;
    }

    //delete page
    public function delete($id)
    {
        $id = clean_number($id);
        $page = $this->get_page_by_id($id);
        if (!empty($page)) {

            $this->db->where('id', $id);
            return $this->db->delete('pages');
        }
        return false;
    }
}
