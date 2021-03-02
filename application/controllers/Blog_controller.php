<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog_controller extends Admin_Core_Controller
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
     * Add Post
     */
    public function add_post()
    {
        $data['title'] = trans("add_post");
        $data['categories'] = $this->blog_category_model->get_categories_by_lang($this->selected_lang->id);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/blog/add_post', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Post Post
     */
    public function add_post_post()
    {
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');
        $this->form_validation->set_rules('category_id', trans("category"), 'required');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->blog_model->input_values());
            redirect($this->agent->referrer());
        } else {
            //if post added
            if ($this->blog_model->add_post()) {
                //last id
                $last_id = $this->db->insert_id();
                //update slug
                $this->blog_model->update_slug($last_id);
                //insert post tags
                $this->tag_model->add_post_tags($last_id);

                //reset cache
                reset_cache_data($this, "st");

                $this->session->set_flashdata('success', trans("msg_post_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->blog_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Posts
     */
    public function posts()
    {
        $data['title'] = trans("blog_posts");
        $data['posts'] = $this->blog_model->get_posts_all();
        $data['lang_search_column'] = 2;
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/blog/posts', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Post
     */
    public function update_post($id)
    {
        $data['title'] = trans("update_post");
        //get post
        $data['post'] = $this->blog_model->get_post($id);

        if (empty($data['post'])) {
            redirect($this->agent->referrer());
        }

        //combine post tags
        $tags = "";
        $count = 0;
        $tags_array = $this->tag_model->get_post_tags($id);
        foreach ($tags_array as $item) {
            if ($count > 0) {
                $tags .= ",";
            }
            $tags .= $item->tag;
            $count++;
        }

        $data['tags'] = $tags;
        $data['categories'] = $this->blog_category_model->get_categories_by_lang($data['post']->lang_id);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/blog/update_post', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Post Post
     */
    public function update_post_post()
    {
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');
        $this->form_validation->set_rules('category_id', trans("category"), 'required');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->blog_model->input_values());
            redirect($this->agent->referrer());
        } else {
            //post id
            $post_id = $this->input->post('id', true);

            if ($this->blog_model->update_post($post_id)) {
                //update slug
                $this->blog_model->update_slug($post_id);
                //update post tags
                $this->tag_model->update_post_tags($post_id);

                //reset cache
                reset_cache_data($this, "st");

                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect(admin_url() . "blog-posts");
            } else {
                $this->session->set_flashdata('form_data', $this->blog_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Delete Post Image Post
     */
    public function delete_post_image_post()
    {
        $id = $this->input->post('post_id', true);
        $this->blog_model->delete_post_image($id);
        reset_cache_data($this, "st");
    }

    /**
     * Delete Post
     */
    public function delete_post_post()
    {
        $id = $this->input->post('id', true);
        if ($this->blog_model->delete_post($id)) {
            $this->session->set_flashdata('success', trans("msg_post_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        //reset cache
        reset_cache_data($this, "st");
    }


    /**
     * Categories
     */
    public function categories()
    {
        $data['title'] = trans("categories");
        $data['categories'] = $this->blog_category_model->get_categories_all();
        $data['lang_search_column'] = 2;
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/blog/categories', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Category Post
     */
    public function add_category_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("category_name"), 'required|xss_clean|max_length[200]');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors_form', validation_errors());
            $this->session->set_flashdata('form_data', $this->blog_category_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->blog_category_model->add_category()) {
                //last id
                $last_id = $this->db->insert_id();
                //update slug
                $this->blog_category_model->update_slug($last_id);
                $this->session->set_flashdata('success_form', trans("msg_category_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->blog_category_model->input_values());
                $this->session->set_flashdata('error_form', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update Category
     */
    public function update_category($id)
    {
        $data['title'] = trans("update_category");
        //get category
        $data['category'] = $this->blog_category_model->get_category($id);
        if (empty($data['category'])) {
            redirect($this->agent->referrer());
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/blog/update_category', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Category Post
     */
    public function update_category_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("category_name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->blog_category_model->input_values());
            redirect($this->agent->referrer());
        } else {
            //category id
            $id = $this->input->post('id', true);
            if ($this->blog_category_model->update_category($id)) {
                //update slug
                $this->blog_category_model->update_slug($id);
                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect(admin_url() . 'blog-categories');
            } else {
                $this->session->set_flashdata('form_data', $this->blog_category_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete Category Post
     */
    public function delete_category_post()
    {
        $id = $this->input->post('id', true);

        //check blog posts
        if (!empty($this->blog_model->get_posts_count_by_category($id))) {
            $this->session->set_flashdata('error', trans("msg_delete_posts"));
        } else {
            if ($this->blog_category_model->delete_category($id)) {
                $this->session->set_flashdata('success', trans("msg_category_deleted"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
    }

    /**
     * Comments
     */
    public function comments()
    {
        $data['title'] = trans("approved_comments");
        $data['comments'] = $this->comment_model->get_approved_blog_comments();
        $data['top_button_text'] = trans("pending_comments");
        $data['top_button_url'] = admin_url() . "pending-blog-comments";
        $data['show_approve_button'] = false;
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comment/blog_comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Pending Comments
     */
    public function pending_comments()
    {
        $data['title'] = trans("pending_comments");
        $data['comments'] = $this->comment_model->get_pending_blog_comments();
        $data['top_button_text'] = trans("approved_comments");
        $data['top_button_url'] = admin_url() . "blog-comments";
        $data['show_approve_button'] = true;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comment/blog_comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Aprrove Comment Post
     */
    public function approve_comment_post()
    {
        $id = $this->input->post('id', true);
        if ($this->comment_model->approve_blog_comment($id)) {
            $this->session->set_flashdata('success', trans("msg_comment_approved"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Approve Selected Comments
     */
    public function approve_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->approve_multi_blog_comments($comment_ids);
    }

    /**
     * Delete Comment
     */
    public function delete_comment()
    {
        $id = $this->input->post('id', true);
        if ($this->comment_model->delete_blog_comment($id)) {
            $this->session->set_flashdata('success', trans("msg_comment_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Comments
     */
    public function delete_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->delete_multi_blog_comments($comment_ids);
    }

    //get categories by language
    public function get_categories_by_lang()
    {
        $lang_id = $this->input->post('lang_id', true);
        if (!empty($lang_id)):
            $categories = $this->blog_category_model->get_categories_by_lang($lang_id);
            foreach ($categories as $item) {
                echo '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
        endif;
    }
}
