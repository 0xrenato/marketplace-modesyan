<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_model extends CI_Model
{

    /*
    *-------------------------------------------------------------------------------------------------
    * BLOG TAGS
    *-------------------------------------------------------------------------------------------------
    */

    //add post tags
    public function add_post_tags($post_id)
    {
        $post_id = clean_number($post_id);
        //tags
        $tags = trim($this->input->post('tags', true));

        $tags_array = explode(",", $tags);
        if (!empty($tags_array)) {
            foreach ($tags_array as $tag) {
                $tag = trim($tag);
                if (strlen($tag) > 1) {
                    $data = array(
                        'post_id' => $post_id,
                        'tag' => trim($tag),
                        'tag_slug' => str_slug(trim($tag))
                    );

                    if (empty($data["tag_slug"]) || $data["tag_slug"] == "-") {
                        $data["tag_slug"] = "tag-" . uniqid();
                    }

                    //insert tag
                    $this->db->insert('blog_tags', $data);
                }
            }
        }
    }

    //update post tags
    public function update_post_tags($post_id)
    {
        $post_id = clean_number($post_id);
        //delete old tags
        $this->delete_post_tags($post_id);

        //add new tags
        $tags = trim($this->input->post('tags', true));

        $tags_array = explode(",", $tags);
        if (!empty($tags_array)) {
            foreach ($tags_array as $tag) {
                $tag = trim($tag);
                if (strlen($tag) > 1) {
                    $data = array(
                        'post_id' => $post_id,
                        'tag' => trim($tag),
                        'tag_slug' => str_slug(trim($tag))
                    );

                    if (empty($data["tag_slug"]) || $data["tag_slug"] == "-") {
                        $data["tag_slug"] = "tag-" . uniqid();
                    }

                    //insert tag
                    $this->db->insert('blog_tags', $data);
                }
            }
        }
    }

    //get random post tags
    public function get_random_post_tags()
    {
        $this->db->join('blog_posts', 'blog_posts.id = blog_tags.post_id');
        $this->db->select('blog_tags.tag_slug, blog_tags.tag');
        $this->db->group_by('tag_slug, blog_tags.tag');
        $this->db->where('blog_posts.lang_id', $this->selected_lang->id);
        $this->db->order_by('rand()');
        $this->db->limit(10);
        $query = $this->db->get('blog_tags');
        return $query->result();
    }

    //get tags
    public function get_tags_all()
    {
        $this->db->join('blog_posts', 'blog_posts.id = blog_tags.post_id');
        $this->db->select('blog_tags.tag_slug, blog_tags.tag');
        $this->db->group_by('tag_slug, blog_tags.tag');
        $query = $this->db->get('blog_tags');
        return $query->result();
    }

    //get post tag
    public function get_post_tag($tag_slug)
    {
		$tag_slug = remove_special_characters($tag_slug);
        $this->db->join('blog_posts', 'blog_posts.id = blog_tags.post_id');
        $this->db->select('blog_tags.*, blog_posts.lang_id as tag_lang_id');
        $this->db->where('blog_tags.tag_slug', $tag_slug);
        $query = $this->db->get('blog_tags');
        return $query->row();
    }

    //get posts tags
    public function get_post_tags($post_id)
    {
        $post_id = clean_number($post_id);
        $this->db->where('post_id', $post_id);
        $query = $this->db->get('blog_tags');
        return $query->result();
    }

    //delete tags
    public function delete_post_tags($post_id)
    {
        $post_id = clean_number($post_id);
        //find tags
        $tags = $this->get_post_tags($post_id);
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                //delete
                $this->db->where('id', $tag->id);
                $this->db->delete('blog_tags');
            }
        }
    }

}
