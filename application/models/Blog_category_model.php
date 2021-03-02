<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_category_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'name' => $this->input->post('name', true),
            'slug' => $this->input->post('slug', true),
            'description' => $this->input->post('description', true),
            'keywords' => $this->input->post('keywords', true),
            'category_order' => $this->input->post('category_order', true)
        );
        return $data;
    }

    //add category
    public function add_category()
    {
        $data = $this->input_values();

        if (empty($data["slug"])) {
            //slug for title
            $data["slug"] = str_slug($data["name"]);
        }

        return $this->db->insert('blog_categories', $data);
    }

    //update slug
    public function update_slug($id)
    {
        $category = $this->get_category($id);

        if (empty($category->slug) || $category->slug == "-") {
            $data = array(
                'slug' => $category->id
            );
            $this->db->where('id', $id);
            $this->db->update('blog_categories', $data);
        } else {
            if ($this->check_is_slug_unique($category->slug, $id) == true) {
                $data = array(
                    'slug' => $category->slug . "-" . $category->id
                );

                $this->db->where('id', $id);
                $this->db->update('blog_categories', $data);
            }
        }
    }

    //check slug
    public function check_is_slug_unique($slug, $id)
    {
        $this->db->where('blog_categories.slug', $slug);
        $this->db->where('blog_categories.id !=', $id);
        $query = $this->db->get('blog_categories');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //get category
    public function get_category($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('blog_categories');
        return $query->row();
    }

    //get category by slug
    public function get_category_by_slug($slug)
    {
        $this->db->where('slug', $slug);
        $query = $this->db->get('blog_categories');
        return $query->row();
    }

    //get categories
    public function get_categories()
    {
        $this->db->where('blog_categories.lang_id', $this->selected_lang->id);
        $this->db->order_by('category_order');
        $query = $this->db->get('blog_categories');
        return $query->result();
    }

    //get categories by lang
    public function get_categories_all()
    {
        $this->db->order_by('category_order');
        $query = $this->db->get('blog_categories');
        return $query->result();
    }

    //get categories by lang
    public function get_categories_by_lang($lang_id)
    {
        $lang_id = clean_number($lang_id);
        $this->db->where('blog_categories.lang_id', $lang_id);
        $this->db->order_by('category_order');
        $query = $this->db->get('blog_categories');
        return $query->result();
    }

    //get category count
    public function get_category_count()
    {
        $query = $this->db->get('blog_categories');
        return $query->num_rows();
    }

    //update category
    public function update_category($id)
    {
        $id = clean_number($id);
        $data = $this->input_values();

        //slug for title
        if (empty($data["slug"])) {
            $data["slug"] = str_slug($data["name"]);
        }

        $this->db->where('id', $id);
        return $this->db->update('blog_categories', $data);
    }

    //delete category
    public function delete_category($id)
    {
        $id = clean_number($id);
        $category = $this->get_category($id);

        if (!empty($category)) {
            $this->db->where('id', $id);
            return $this->db->delete('blog_categories');
        } else {
            return false;
        }
    }

}
