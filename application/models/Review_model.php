<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_model extends CI_Model
{
    //add review
    public function add_review($rating, $product_id, $review_text)
    {
        $data = array(
            'product_id' => $product_id,
            'user_id' => $this->auth_user->id,
            'rating' => $rating,
            'review' => $review_text,
            'ip_address' => 0,
            'created_at' => date("Y-m-d H:i:s")
        );
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if (!empty($data['product_id']) && !empty($data['user_id']) && !empty($data['rating'])) {
            $this->db->insert('reviews', $data);
            //update product rating
            $this->update_product_rating($product_id);
        }
    }

    //update review
    public function update_review($review_id, $rating, $product_id, $review_text)
    {
        $data = array(
            'rating' => $rating,
            'review' => $review_text,
            'ip_address' => 0,
            'created_at' => date("Y-m-d H:i:s")
        );
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if (!empty($data['rating']) && !empty($data['review'])) {
            $this->db->where('product_id', $product_id);
            $this->db->where('user_id', $this->auth_user->id);
            $this->db->update('reviews', $data);
            //update product rating
            $this->update_product_rating($product_id);
        }
    }

    //get review count
    public function get_review_count($product_id)
    {
        $product_id = clean_number($product_id);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->where('reviews.product_id', $product_id);
        $query = $this->db->get('reviews');
        return $query->num_rows();
    }

    //get reviews
    public function get_reviews($product_id)
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('reviews.product_id', clean_number($product_id));
        $this->db->order_by('reviews.created_at', 'DESC');
        return $this->db->get('reviews')->result();
    }

    //get all reviews
    public function get_all_reviews()
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('reviews.*, users.username AS user_username, users.slug AS user_slug');
        $this->db->order_by('reviews.created_at', 'DESC');
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get latest reviews
    public function get_latest_reviews($limit)
    {
        $limit = clean_number($limit);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username');
        $this->db->order_by('reviews.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get limited reviews
    public function get_limited_reviews($product_id, $limit)
    {
        $product_id = clean_number($product_id);
        $limit = clean_number($limit);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('reviews.product_id', $product_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get review
    public function get_review($product_id, $user_id)
    {
        $product_id = clean_number($product_id);
        $user_id = clean_number($user_id);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('reviews.product_id', $product_id);
        $this->db->where('users.id', $user_id);
        $query = $this->db->get('reviews');
        return $query->row();
    }

    //get review by id
    public function get_review_by_id($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->get('reviews')->row();
    }

    //update product rating
    public function update_product_rating($product_id)
    {
        $product_id = clean_number($product_id);
        $reviews = $this->get_reviews($product_id);
        $data = array();
        if (!empty($reviews)) {
            $count = count($reviews);
            $total = 0;
            foreach ($reviews as $review) {
                $total += $review->rating;
            }
            $data['rating'] = round($total / $count);
        } else {
            $data['rating'] = 0;
        }
        $this->db->where('id', $product_id);
        $this->db->update('products', $data);
    }

    //get paginated vendor reviews
    public function get_paginated_vendor_reviews($user_id, $per_page, $offset)
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('reviews.*, users.username AS user_username, users.slug AS user_slug');
        $this->db->where('products.user_id', clean_number($user_id));
        $this->db->order_by('reviews.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get vendor reviews count
    public function get_vendor_reviews_count($user_id)
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('products.user_id', clean_number($user_id));
        return $this->db->count_all_results('reviews');
    }

    //calculate user rating
    public function calculate_user_rating($user_id)
    {
        $std = new stdClass();
        $std->count = 0;
        $std->rating = 0;

        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('COUNT(reviews.id) AS count, SUM(reviews.rating) AS total');
        $this->db->where('products.user_id', clean_number($user_id));
        $query = $this->db->get('reviews');
        if (!empty($query->row())) {
            $total = $query->row()->total;
            $count = $query->row()->count;
            if (!empty($total) and !empty($count)) {
                $avg = round($total / $count);
                $std->count = $count;
                $std->rating = $avg;
            }
        }
        return $std;
    }

    //delete review
    public function delete_review($id, $product_id = null)
    {
        $review = $this->get_review_by_id($id);
        if (!empty($review)) {
            $this->db->where('id', $id);
            if ($this->db->delete('reviews')) {
                $product = get_product($review->product_id);
                if (!empty($product)) {
                    $this->update_product_rating($product->id);
                }
                return true;
            }
        }
        return false;
    }

    //delete multi reviews
    public function delete_multi_reviews($review_ids)
    {
        if (!empty($review_ids)) {
            foreach ($review_ids as $id) {
                $this->delete_review($id);
            }
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * ABUSE REPORTS
    *-------------------------------------------------------------------------------------------------
    */

    //report abuse
    public function report_abuse()
    {
        $data = array(
            'item_type' => $this->input->post('item_type', true),
            'item_id' => $this->input->post('id', true),
            'report_user_id' => $this->auth_user->id,
            'description' => $this->input->post('description', true),
            'created_at' => date("Y-m-d H:i:s")
        );
        if (empty($data['item_id'])) {
            $data['item_id'] = 0;
        }
        return $this->db->insert('abuse_reports', $data);
    }

    //get paginated abuse reports
    public function get_paginated_abuse_reports($per_page, $offset)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        return $this->db->get('abuse_reports')->result();
    }

    //get abuse reports count
    public function get_abuse_reports_count()
    {
        return $this->db->count_all_results('abuse_reports');
    }

    //delete abuse report
    public function delete_abuse_report($id)
    {
        return $this->db->where('id', clean_number($id))->delete('abuse_reports');
    }

}
