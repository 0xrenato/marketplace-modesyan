<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //add product
    public function add_product()
    {
        $data = array(
            'slug' => str_slug($this->input->post('title_' . $this->selected_lang->id, true)),
            'product_type' => $this->input->post('product_type', true),
            'listing_type' => $this->input->post('listing_type', true),
            'sku' => "",
            'price' => 0,
            'currency' => "",
            'discount_rate' => 0,
            'vat_rate' => 0,
            'user_id' => $this->auth_user->id,
            'status' => 0,
            'is_promoted' => 0,
            'promote_start_date' => date('Y-m-d H:i:s'),
            'promote_end_date' => date('Y-m-d H:i:s'),
            'promote_plan' => "none",
            'promote_day' => 0,
            'visibility' => 1,
            'rating' => 0,
            'pageviews' => 0,
            'demo_url' => "",
            'external_link' => "",
            'files_included' => "",
            'stock' => 1,
            'shipping_delivery_time_id' => 0,
            'multiple_sale' => 1,
            'is_deleted' => 0,
            'is_draft' => 1,
            'is_free_product' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );

        if (empty($data['sku'])) {
            $data['sku'] = "";
        }
        if (!empty($data['slug'])) {
            $data['slug'] = substr($data['slug'], 0, 200);
        }
        if (empty($data['multiple_sale'])) {
            $data['multiple_sale'] = 0;
        }
        //set category id
        $data['category_id'] = get_dropdown_category_id();

        return $this->db->insert('products', $data);
    }

    //add product title and desc
    public function add_product_title_desc($product_id)
    {
        $main_title = trim($this->input->post('title_' . $this->site_lang->id, true));
        foreach ($this->languages as $language) {
            $title = trim($this->input->post('title_' . $language->id, true));
            if (!empty($title)) {
                $data = array(
                    'product_id' => $product_id,
                    'lang_id' => $language->id,
                    'title' => !empty($title) ? $title : $main_title,
                    'description' => $this->input->post('description_' . $language->id, false),
                    'seo_title' => $this->input->post('seo_title_' . $language->id, true),
                    'seo_description' => $this->input->post('seo_description_' . $language->id, true),
                    'seo_keywords' => $this->input->post('seo_keywords_' . $language->id, true)
                );
                $this->db->insert('product_details', $data);
            }
        }
    }

    //edit product title and desc
    public function edit_product_title_desc($product_id)
    {
        $main_title = trim($this->input->post('title_' . $this->site_lang->id, true));
        foreach ($this->languages as $language) {
            $title = trim($this->input->post('title_' . $language->id, true));
            $data = array(
                'product_id' => $product_id,
                'lang_id' => $language->id,
                'title' => !empty($title) ? $title : $main_title,
                'description' => $this->input->post('description_' . $language->id, false),
                'seo_title' => $this->input->post('seo_title_' . $language->id, true),
                'seo_description' => $this->input->post('seo_description_' . $language->id, true),
                'seo_keywords' => $this->input->post('seo_keywords_' . $language->id, true)
            );
            $row = get_product_details($product_id, $language->id, false);
            if (empty($row)) {
                $this->db->insert('product_details', $data);
            } else {
                $this->db->where('product_id', $product_id)->where('lang_id', $language->id);
                $this->db->update('product_details', $data);
            }
        }
    }

    //edit product details
    public function edit_product_details($id)
    {
        $product = $this->get_product_by_id($id);
        $data = array(
            'sku' => $this->input->post('sku', true),
            'price' => $this->input->post('price', true),
            'currency' => $this->input->post('currency', true),
            'discount_rate' => $this->input->post('discount_rate', true),
            'vat_rate' => $this->input->post('vat_rate', true),
            'demo_url' => trim($this->input->post('demo_url', true)),
            'external_link' => trim($this->input->post('external_link', true)),
            'files_included' => trim($this->input->post('files_included', true)),
            'stock' => $this->input->post('stock', true),
            'shipping_class_id' => $this->input->post('shipping_class_id', true),
            'shipping_delivery_time_id' => $this->input->post('shipping_delivery_time_id', true),
            'multiple_sale' => $this->input->post('multiple_sale', true),
            'is_free_product' => $this->input->post('is_free_product', true),
            'is_draft' => 0
        );

        $data["price"] = get_price($data["price"], 'database');
        if (empty($data["price"])) {
            $data["price"] = 0;
        }
        if (empty($data["discount_rate"])) {
            $data["discount_rate"] = 0;
        }
        if (empty($data["vat_rate"])) {
            $data["vat_rate"] = 0;
        }
        if (empty($data["external_link"])) {
            $data["external_link"] = "";
        }
        if (empty($data["stock"])) {
            $data["stock"] = 0;
        }
        if (empty($data["shipping_class_id"])) {
            $data["shipping_class_id"] = 0;
        }
        if (empty($data["shipping_delivery_time_id"])) {
            $data["shipping_delivery_time_id"] = 0;
        }
        if (!empty($data["is_free_product"])) {
            $data["is_free_product"] = 1;
        } else {
            $data["is_free_product"] = 0;
        }

        //unset price if bidding system selected
        if ($this->general_settings->bidding_system == 1) {
            $array['price'] = 0;
        }
        //validate sku
        $is_sku_valid = true;
        if (!empty($data['sku'])) {
            $row = $this->db->where('sku', remove_special_characters($data['sku']))->where('id != ', clean_number($id))->where('user_id = ', clean_number($this->auth_user->id))->get('products')->row();
            if (!empty($row)) {
                $is_sku_valid = false;
                $data['sku'] = "";
            }
        }

        if ($this->input->post('submit', true) == 'save_as_draft') {
            $data["is_draft"] = 1;
        } else {
            if ($this->general_settings->approve_before_publishing == 0 || $this->auth_user->role == 'admin') {
                $data["status"] = 1;
            }
        }

        $this->db->where('id', clean_number($id));
        if ($this->db->update('products', $data)) {
            if ($is_sku_valid == false) {
                $this->session->set_flashdata('error', trans("msg_error_sku"));
                redirect($this->agent->referrer());
                exit();
            }
            return true;
        }
        return false;
    }

    //edit product
    public function edit_product($product, $slug)
    {
        $data = array(
            'product_type' => $this->input->post('product_type', true),
            'listing_type' => $this->input->post('listing_type', true),
            'slug' => $slug,
            'sku' => $this->input->post('sku', true)
        );
        if (empty($data['sku'])) {
            $data['sku'] = "";
        }
        //set category id
        $data['category_id'] = get_dropdown_category_id();

        $data["is_sold"] = $product->is_sold;
        $data["visibility"] = $product->visibility;
        if ($product->is_draft != 1) {
            $data["is_sold"] = $this->input->post('is_sold', true);
            $data["visibility"] = $this->input->post('visibility', true);
        }
        if (!empty($data['slug'])) {
            $data['slug'] = substr($data['slug'], 0, 200);
        }
        $this->db->where('id', $product->id);
        return $this->db->update('products', $data);
    }

    //update custom fields
    public function update_product_custom_fields($product_id)
    {
        $product = $this->get_product_by_id($product_id);
        if (!empty($product)) {
            $custom_fields = $this->field_model->get_custom_fields_by_category($product->category_id);
            if (!empty($custom_fields)) {
                //delete previous custom field values
                $this->field_model->delete_field_product_values_by_product_id($product_id);

                foreach ($custom_fields as $custom_field) {
                    $input_value = $this->input->post('field_' . $custom_field->id, true);
                    //add custom field values
                    if (!empty($input_value)) {
                        if ($custom_field->field_type == 'checkbox') {
                            foreach ($input_value as $key => $value) {
                                $data = array(
                                    'field_id' => $custom_field->id,
                                    'product_id' => $product_id,
                                    'product_filter_key' => $custom_field->product_filter_key
                                );
                                $data['field_value'] = '';
                                $data['selected_option_id'] = $value;
                                $this->db->insert('custom_fields_product', $data);
                            }
                        } else {
                            $data = array(
                                'field_id' => $custom_field->id,
                                'product_id' => clean_number($product_id),
                                'product_filter_key' => $custom_field->product_filter_key,
                            );
                            if ($custom_field->field_type == 'radio_button' || $custom_field->field_type == 'dropdown') {
                                $data['field_value'] = '';
                                $data['selected_option_id'] = $input_value;
                            } else {
                                $data['field_value'] = $input_value;
                                $data['selected_option_id'] = 0;
                            }
                            $this->db->insert('custom_fields_product', $data);
                        }
                    }
                }
            }
        }
    }

    //update slug
    public function update_slug($id)
    {
        $product = $this->get_product_by_id($id);
        if (!empty($product)) {
            if (empty($product->slug) || $product->slug == "-") {
                $data = array(
                    'slug' => $product->id,
                );
            } else {
                if ($this->general_settings->product_link_structure == "id-slug") {
                    $data = array(
                        'slug' => $product->id . "-" . $product->slug,
                    );
                } else {
                    $data = array(
                        'slug' => $product->slug . "-" . $product->id,
                    );
                }
            }
            if (!empty($this->page_model->check_page_slug_for_product($data["slug"]))) {
                $data["slug"] .= uniqid();
            }
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
    }

    //build sql query string
    public function build_query($type = "active", $compile_query = false)
    {
        $select = "products.*,
            users.username AS user_username, users.shop_name AS shop_name, users.role AS user_role, users.slug AS user_slug,
            round(products.price - ((products.price * products.discount_rate)/100)) AS price_final,
            (SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = " . clean_number($this->selected_lang->id) . " LIMIT 1) AS title,
            (SELECT CONCAT(storage, '::', image_small) FROM images WHERE products.id = images.product_id ORDER BY is_main DESC LIMIT 1) AS image,
            (SELECT CONCAT(storage, '::', image_small) FROM images WHERE products.id = images.product_id ORDER BY is_main DESC LIMIT 1, 1) AS image_second,
            (SELECT COUNT(wishlist.id) FROM wishlist WHERE products.id = wishlist.product_id) AS wishlist_count,
            (SELECT variations.id FROM variations WHERE products.id = variations.product_id LIMIT 1) AS has_variation";
        if (item_count($this->languages) > 1) {
            $select .= ", (SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id != " . clean_number($this->selected_lang->id) . " LIMIT 1) AS second_title";
        }
        if ($this->auth_check) {
            $select .= ", (SELECT COUNT(wishlist.id) FROM wishlist WHERE products.id = wishlist.product_id AND wishlist.user_id = " . clean_number($this->auth_user->id) . ") AS is_in_wishlist";
        } else {
            $select .= ", 0 AS is_in_wishlist";
        }

        $status = ($type == 'draft' || $type == 'pending') ? 0 : 1;
        $visibility = ($type == 'hidden') ? 0 : 1;
        $is_sold = ($type == 'sold') ? 1 : 0;
        $is_draft = ($type == 'draft') ? 1 : 0;

        $this->db->select($select);
        if ($compile_query == true) {
            $this->db->from('products');
        }

        if ($this->general_settings->membership_plans_system == 1) {
            if ($type == "expired") {
                $this->db->join('users', 'products.user_id = users.id AND users.is_membership_plan_expired = 1');
            } else {
                $this->db->join('users', 'products.user_id = users.id AND users.is_membership_plan_expired = 0');
            }
        } else {
            $this->db->join('users', 'products.user_id = users.id');
        }
        if ($type == 'wishlist') {
            $this->db->join('wishlist', 'products.id = wishlist.product_id');
        }
        $this->db->where('users.banned', 0);
        $this->db->where('products.status', $status);
        $this->db->where('products.visibility', $visibility);
        $this->db->where('products.is_draft', $is_draft);
        $this->db->where('products.is_deleted', 0);
        if ($type == 'promoted') {
            $this->db->where('products.is_promoted', 1);
        }
        if ($this->general_settings->vendor_verification_system == 1) {
            $this->db->where('users.role !=', 'member');
        }
        if ($is_sold == 1) {
            $this->db->where('products.is_sold', 1);
        } else {
            if ($this->general_settings->show_sold_products != 1) {
                $this->db->where('products.is_sold', 0);
            }
        }
        //default location
        if (!empty($this->default_location->country_id)) {
            $this->db->where('users.country_id', $this->default_location->country_id);
        }
        if (!empty($this->default_location->state_id)) {
            $this->db->where('users.state_id', $this->default_location->state_id);
        }
        if (!empty($this->default_location->city_id)) {
            $this->db->where('users.city_id', $this->default_location->city_id);
        }
        if ($compile_query == true) {
            return $this->db->get_compiled_select() . " ";
        }
    }

    //filter products
    public function filter_products($query_string_array = null, $category_ids = null, $custom_filters = null, $user_id = null)
    {
        $p_min = clean_number(input_get("p_min"));
        $p_max = clean_number(input_get("p_max"));
        $sort = str_slug(input_get("sort"));
        $product_type = remove_special_characters($this->input->get("product_type", true));
        $search = remove_special_characters(trim($this->input->get('search', true)));

        if (!empty($search)) {
            $array = explode(' ', $search);
            $array_search_words = array();
            foreach ($array as $item) {
                if (strlen($item) > 1) {
                    array_push($array_search_words, $item);
                }
            }
        }

        //check if custom filters selected
        $array_selected_filters = array();
        if (!empty($query_string_array)) {
            foreach ($query_string_array as $key => $array_values) {
                if ($key != "product_type" && $key != "p_min" && $key != "p_max" && $key != "sort" && $key != "search") {
                    $key_id = get_product_filter_id_by_key($custom_filters, $key);
                    if (!empty($key_id)) {
                        $item = new stdClass();
                        $item->id = $key_id;
                        $item->key = $key;
                        $item->array_values = $array_values;
                        array_push($array_selected_filters, $item);
                    }
                }
            }
        }

        if (!empty($array_selected_filters)) {
            $array_queries = array();
            foreach ($array_selected_filters as $filter) {
                $this->db->join('custom_fields_options', 'custom_fields_options.id = custom_fields_product.selected_option_id');
                $this->db->select('product_id');
                $this->db->where('custom_fields_product.field_id', $filter->id);
                $this->db->group_start();
                $this->db->where_in('custom_fields_options.option_key', $filter->array_values);
                $this->db->group_end();
                $this->db->from('custom_fields_product');
                $array_queries[] = $this->db->get_compiled_select();
                $this->db->reset_query();
            }
            if (!empty($array_queries)) {
                $this->build_query();
                foreach ($array_queries as $query) {
                    $this->db->where_in('products.id', $query, FALSE);
                }
            }
        } else {
            $this->build_query();
        }
        //is vendor products
        if (!empty($user_id)) {
            $this->db->where("products.user_id", $user_id);
        }

        //add protuct filter options
        if (!empty($category_ids)) {
            $this->db->where_in("products.category_id", $category_ids, FALSE);
            if (empty($sort)) {
                $this->db->order_by('products.is_promoted', 'DESC');
            }
        }

        if ($p_min != "") {
            $this->db->where('(products.price - ((products.price * products.discount_rate)/100)) >=', intval($p_min * 100));
        }
        if ($p_max != "") {
            $this->db->where('(products.price - ((products.price * products.discount_rate)/100)) <=', intval($p_max * 100));
        }

        if (!empty($array_search_words)) {
            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->where('product_details.lang_id', clean_number($this->selected_lang->id));
            $this->db->group_start();
            foreach ($array_search_words as $word) {
                if (!empty($word)) {
                    $this->db->like('product_details.title', $word);
                }
            }
            $this->db->or_like('products.sku', clean_slug($search));
            $this->db->group_end();
            if (empty($sort)) {
                $this->db->order_by('products.is_promoted', 'DESC');
            }
        }

        //sort products
        if (!empty($sort) && $sort == "lowest_price") {
            $this->db->order_by('price_final');
        } elseif (!empty($sort) && $sort == "highest_price") {
            $this->db->order_by('price_final', 'DESC');
        } else {
            $this->db->order_by('products.created_at', 'DESC');
        }
    }

    //search products (AJAX search)
    public function search_products($search)
    {
        if (!empty($search)) {
            $array = explode(' ', $search);
            $str = "";
            $array_like = array();
            $this->build_query();
            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->where('product_details.lang_id', clean_number($this->selected_lang->id));
            $this->db->group_start();
            foreach ($array as $item) {
                if (strlen($item) > 1) {
                    $this->db->like('product_details.title', clean_str($item));
                }
            }
            $this->db->or_like('products.sku', clean_slug($search));
            $this->db->group_end();
            $this->db->order_by('products.is_promoted', 'DESC')->limit(10);
            $query = $this->db->get('products');
            return $query->result();
        }
        return array();
    }

    //get products
    public function get_products()
    {
        $this->build_query();
        $this->db->order_by('products.created_at');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get limited products
    public function get_products_limited($limit)
    {
        $lc_key = get_location_cache_key($this);
        $key = "latest_products_lang_" . $this->selected_lang->id . "_limit_" . $limit;
        $result_cache = get_cached_data($this, $key, "pr");
        if (!empty($result_cache)) {
            if (!empty($result_cache[$lc_key])) {
                return $result_cache[$lc_key];
            }
        } else {
            $result_cache = array();
        }

        $this->build_query();
        $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($limit));
        $result = $this->db->get('products')->result();

        $result_cache[$lc_key] = $result;
        set_cache_data($this, $key, $result_cache, "pr");
        return $result;
    }

    //get promoted products
    public function get_promoted_products()
    {
        $this->build_query('promoted');
        $this->db->select("(SELECT COUNT(id) FROM products) AS num_rows");
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }

    //get promoted products
    public function get_promoted_products_limited($per_page, $offset)
    {
        $lc_key = get_location_cache_key($this);
        $key = "promoted_products_lang_" . $this->selected_lang->id . "_" . $per_page . "_" . $offset;
        $result_cache = get_cached_data($this, $key, "pr");
        if (!empty($result_cache)) {
            if (!empty($result_cache[$lc_key])) {
                return $result_cache[$lc_key];
            }
        } else {
            $result_cache = array();
        }

        $this->build_query('promoted');
        $this->db->order_by('products.promote_start_date', 'DESC')->limit(clean_number($per_page), clean_number($offset));
        $result = $this->db->get('products')->result();

        $result_cache[$lc_key] = $result;
        set_cache_data($this, $key, $result_cache, "pr");
        return $result;
    }

    //get promoted products count
    public function get_promoted_products_count()
    {
        $lc_key = get_location_cache_key($this);
        $key = "promoted_products_count_lang_" . $this->selected_lang->id;
        $result_cache = get_cached_data($this, $key, "pr");
        if (!empty($result_cache)) {
            if (!empty($result_cache[$lc_key])) {
                return $result_cache[$lc_key];
            }
        } else {
            $result_cache = array();
        }

        $this->build_query('promoted');
        $result = $this->db->count_all_results('products');

        $result_cache[$lc_key] = $result;
        set_cache_data($this, $key, $result_cache, "pr");
        return $result;
    }

    //check promoted products
    public function check_promoted_products()
    {
        $this->db->where('is_promoted', 1);
        $products = $this->db->get('products')->result();
        if (!empty($products)) {
            foreach ($products as $item) {
                if (date_difference($item->promote_end_date, date('Y-m-d H:i:s')) < 1) {
                    $data = array(
                        'is_promoted' => 0,
                    );
                    $this->db->where('id', $item->id);
                    $this->db->update('products', $data);
                }
            }
        }
    }

    //get special offers
    public function get_special_offers()
    {
        $lc_key = get_location_cache_key($this);
        $key = "special_offers_lang_" . $this->selected_lang->id;
        $result_cache = get_cached_data($this, $key, "pr");
        if (!empty($result_cache)) {
            if (!empty($result_cache[$lc_key])) {
                return $result_cache[$lc_key];
            }
        } else {
            $result_cache = array();
        }

        $this->build_query();
        $this->db->where('products.is_special_offer', 1);
        $this->db->order_by('products.special_offer_date', 'DESC')->limit(20);
        $result = $this->db->get('products')->result();

        $result_cache[$lc_key] = $result;
        set_cache_data($this, $key, $result_cache, "pr");
        return $result;
    }

    //get index categories products
    public function get_index_categories_products($categories)
    {
        $limit = 15;
        $lc_key = get_location_cache_key($this);
        $key = "index_category_products_lang_" . $this->selected_lang->id;
        $result_cache = get_cached_data($this, $key, "pr");
        if (!empty($result_cache)) {
            if (!empty($result_cache[$lc_key])) {
                return $result_cache[$lc_key];
            }
        } else {
            $result_cache = array();
        }

        $products_array = array();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                if ($category->show_subcategory_products == 1) {
                    $this->build_query();
                    $this->db->group_start();
                    $this->db->where("products.category_id IN (SELECT id FROM categories WHERE FIND_IN_SET(" . clean_number($category->id) . ", categories.parent_tree))");
                    $this->db->or_where("products.category_id", clean_number($category->id));
                    $this->db->group_end();
                    $this->db->order_by('products.created_at', 'DESC')->limit($limit);
                    $products_array[$category->id] = $this->db->get('products')->result();
                } else {
                    $this->build_query();
                    $this->db->where_in('products.category_id', clean_number($category->id), FALSE);
                    $this->db->order_by('products.created_at', 'DESC')->limit($limit);
                    $products_array[$category->id] = $this->db->get('products')->result();
                }
            }
        }

        $result_cache[$lc_key] = $products_array;
        set_cache_data($this, $key, $result_cache, "pr");
        return $products_array;
    }

    //get paginated filtered products
    public function get_paginated_filtered_products($query_string_array = null, $category_ids = null, $custom_filters, $per_page, $offset)
    {
        $this->filter_products($query_string_array, $category_ids, $custom_filters);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get paginated filtered products count
    public function get_paginated_filtered_products_count($query_string_array = null, $category_ids = null, $custom_filters)
    {
        $this->filter_products($query_string_array, $category_ids, $custom_filters);
        return $this->db->count_all_results('products');
    }

    //get products count by category
    public function get_products_count_by_category($category_ids)
    {
        return $this->db->where('products.category_id', clean_number($category_ids))->count_all_results('products');
    }

    //get paginated profile products
    public function get_paginated_profile_products($user_id, $category_ids, $per_page, $offset)
    {
        $this->filter_products(null, $category_ids, null, $user_id);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get profile products count
    public function get_profile_products_count($user_id, $category_ids)
    {
        $this->filter_products(null, $category_ids, null, $user_id);
        return $this->db->count_all_results('products');
    }

    //get related products
    public function get_related_products($product_id, $category_id)
    {
        $lc_key = get_location_cache_key($this);
        $lc_key = "pr" . $product_id . "_" . $lc_key;
        $key = "related_products_lang_" . $this->selected_lang->id;
        $result_cache = get_cached_data($this, $key, "pr");
        if (!empty($result_cache)) {
            if (!empty($result_cache[$lc_key])) {
                return $result_cache[$lc_key];
            }
        } else {
            $result_cache = array();
        }

        $this->build_query();
        $result = $this->db->where('products.category_id', clean_number($category_id))->where('products.id !=', clean_number($product_id))->order_by('rand()')->limit(5)->get('products')->result();

        $result_cache[$lc_key] = $result;
        set_cache_data($this, $key, $result_cache, "pr");
        return $result;
    }

    //get more products by user
    public function get_more_products_by_user($user_id, $product_id)
    {
        $cache_key = "lang_" . $this->selected_lang->id;
        $key = "more_products_by_user_" . $user_id;
        $result_cache = get_cached_data($this, $key, "pr");
        if (!empty($result_cache)) {
            if (!empty($result_cache[$cache_key])) {
                return $result_cache[$cache_key];
            }
        } else {
            $result_cache = array();
        }

        $this->build_query();
        $this->db->where('users.id', clean_number($user_id));
        $this->db->where('products.id != ', clean_number($product_id));
        $this->db->order_by('products.created_at', 'DESC')->limit(6);
        $result = $this->db->get('products')->result();

        $result_cache[$cache_key] = $result;
        set_cache_data($this, $key, $result_cache, "pr");
        return $result;
    }

    //get user products count
    public function get_user_products_count($user_id, $list_type = 'active')
    {
        $this->build_query();
        $this->db->where('users.id', clean_number($user_id));
        return $this->db->count_all_results('products');
    }

    //get paginated user products
    public function get_paginated_user_products($user_id, $list_type, $per_page, $offset)
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        $this->db->order_by('products.created_at', 'DESC')->limit($per_page, $offset);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get user paginated products count
    public function get_paginated_user_products_count($user_id, $list_type = 'active')
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        return $this->db->count_all_results('products');
    }

    //filter user products
    public function filter_user_products($list_type)
    {
        $product_type = input_get('product_type');
        $category = clean_number(input_get('category'));
        $subcategory = clean_number(input_get('subcategory'));
        $stock = input_get('stock');
        $q = input_get('q');

        $category_ids = array();
        $category_id = $category;
        if (!empty($subcategory)) {
            $category_id = $subcategory;
        }
        if (!empty($category_id)) {
            $category_ids = $this->category_model->get_subcategories_tree_ids($category_id, true, true);;
        }

        if ($list_type == "pending") {
            $this->build_query('pending', false, false);
        } elseif ($list_type == "draft") {
            $this->build_query('draft', false, false);
        } elseif ($list_type == "hidden") {
            $this->build_query('hidden', false, false);
        } elseif ($list_type == "expired") {
            $this->build_query('expired', false, false);
        } elseif ($list_type == "sold") {
            $this->build_query('sold', false, false);
        } else {
            $this->build_query('active', false, false);
        }

        if ($product_type == "physical" || $product_type == "digital") {
            $this->db->where('products.product_type', $product_type);
        }
        if (!empty($category_ids)) {
            $this->db->where_in("products.category_id", $category_ids, FALSE);
        }
        if ($stock == "in_stock" || $stock == "out_of_stock") {
            $this->db->group_start();
            if ($stock == "out_of_stock") {
                $this->db->where("products.product_type = 'physical' AND products.stock <=", 0);
            } else {
                $this->db->where("products.product_type = 'digital' OR products.stock >", 0);
            }
            $this->db->group_end();
        }
        if (!empty($q)) {
            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->where('product_details.lang_id', $this->selected_lang->id);
            $this->db->group_start();
            $this->db->like('product_details.title', $q);
            $this->db->or_like('products.sku', $q);
            $this->db->or_like('products.promote_plan', $q);
            $this->db->group_end();
        }
    }

    //get user wishlist products
    public function get_paginated_user_wishlist_products($user_id, $per_page, $offset)
    {
        $this->build_query('wishlist');
        $this->db->where('wishlist.user_id', clean_number($user_id));
        $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get user wishlist products count
    public function get_user_wishlist_products_count($user_id)
    {
        $this->build_query('wishlist');
        $this->db->where('wishlist.user_id', clean_number($user_id));
        return $this->db->count_all_results('products');
    }

    //get guest wishlist products
    public function get_paginated_guest_wishlist_products($per_page, $offset)
    {
        $wishlist = $this->session->userdata('mds_guest_wishlist');
        if (!empty($wishlist) && item_count($wishlist) > 0) {
            $this->build_query();
            $this->db->where_in('products.id', $wishlist, FALSE);
            $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($per_page), clean_number($offset));
            return $this->db->get('products')->result();
        }
        return array();
    }

    //get guest wishlist products count
    public function get_guest_wishlist_products_count()
    {
        $wishlist = $this->session->userdata('mds_guest_wishlist');
        if (!empty($wishlist) && item_count($wishlist) > 0) {
            $this->build_query();
            $this->db->where_in('products.id', $wishlist, FALSE);
            return $this->db->count_all_results('products');
        }
        return 0;
    }

    //get paginated downloads
    public function get_paginated_user_downloads($user_id, $per_page, $offset)
    {
        $this->db->where('buyer_id', clean_number($user_id));
        $this->db->order_by('purchase_date', 'DESC')->limit($per_page, $offset);
        return $this->db->get('digital_sales')->result();
    }

    //get user downloads count
    public function get_user_downloads_count($user_id)
    {
        $this->db->where('buyer_id', clean_number($user_id));
        return $this->db->count_all_results('digital_sales');
    }

    //get digital sale
    public function get_digital_sale($sale_id)
    {
        $this->db->where('id', clean_number($sale_id));
        return $this->db->get('digital_sales')->row();
    }

    //get digital sale by buyer id
    public function get_digital_sale_by_buyer_id($buyer_id, $product_id)
    {
        $this->db->where('buyer_id', clean_number($buyer_id));
        $this->db->where('product_id', clean_number($product_id));
        return $this->db->get('digital_sales')->row();
    }

    //get digital sale by order id
    public function get_digital_sale_by_order_id($buyer_id, $product_id, $order_id)
    {
        $this->db->where('buyer_id', clean_number($buyer_id));
        $this->db->where('product_id', clean_number($product_id));
        $this->db->where('order_id', clean_number($order_id));
        return $this->db->get('digital_sales')->row();
    }

    //get product by id
    public function get_product_by_id($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->get('products')->row();
    }

    //get available product
    public function get_active_product($id)
    {
        $this->build_query();
        $this->db->where('products.id', $id);
        return $this->db->get('products')->row();
    }

    //get product by slug
    public function get_product_by_slug($slug)
    {
        if ($this->general_settings->membership_plans_system == 1) {
            $this->db->join('users', 'products.user_id = users.id AND users.banned = 0 AND users.is_membership_plan_expired = 0');
        } else {
            $this->db->join('users', 'products.user_id = users.id AND users.banned = 0');
        }
        $this->db->select('products.*, users.username as user_username, users.shop_name as shop_name, users.role as user_role, users.slug as user_slug');
        $this->db->where('products.slug', clean_slug($slug))->where('products.is_draft', 0)->where('products.is_deleted', 0);
        if ($this->general_settings->show_sold_products != 1) {
            $this->db->where('products.is_sold', 0);
        }
        if ($this->general_settings->vendor_verification_system == 1) {
            $this->db->where('users.role != ', 'member');
        }
        return $this->db->get('products')->row();
    }

    //get product details
    public function get_product_details($id, $lang_id, $get_main_on_null = true)
    {
        $this->db->where('product_details.product_id', clean_number($id))->where('product_details.lang_id', clean_number($lang_id));
        $row = $this->db->get('product_details')->row();
        if ((empty($row) || empty($row->title)) && $get_main_on_null == true) {
            $this->db->where('product_details.product_id', clean_number($id))->limit(1);
            $row = $this->db->get('product_details')->row();
        }
        return $row;
    }

    //is product in wishlist
    public function is_product_in_wishlist($product_id)
    {
        if ($this->auth_check) {
            $this->db->where('user_id', $this->auth_user->id)->where('product_id', clean_number($product_id));
            $query = $this->db->get('wishlist');
            if (!empty($query->row())) {
                return true;
            }
        } else {
            $wishlist = $this->session->userdata('mds_guest_wishlist');
            if (!empty($wishlist)) {
                if (in_array($product_id, $wishlist)) {
                    return true;
                }
            }
        }
        return false;
    }

    //get product wishlist count
    public function get_product_wishlist_count($product_id)
    {
        $this->db->where('product_id', clean_number($product_id));
        return $this->db->count_all_results('wishlist');
    }

    //add remove wishlist
    public function add_remove_wishlist($product_id)
    {
        if ($this->auth_check) {
            if ($this->is_product_in_wishlist($product_id)) {
                $this->db->where('user_id', $this->auth_user->id);
                $this->db->where('product_id', clean_number($product_id));
                $this->db->delete('wishlist');
            } else {
                $data = array(
                    'user_id' => $this->auth_user->id,
                    'product_id' => clean_number($product_id)
                );
                $this->db->insert('wishlist', $data);
            }
        } else {
            if ($this->is_product_in_wishlist($product_id)) {
                $wishlist = array();
                if (!empty($this->session->userdata('mds_guest_wishlist'))) {
                    $wishlist = $this->session->userdata('mds_guest_wishlist');
                }
                $new = array();
                if (!empty($wishlist)) {
                    foreach ($wishlist as $item) {
                        if ($item != clean_number($product_id)) {
                            array_push($new, $item);
                        }
                    }
                }
                $this->session->set_userdata('mds_guest_wishlist', $new);
            } else {
                $wishlist = array();
                if (!empty($this->session->userdata('mds_guest_wishlist'))) {
                    $wishlist = $this->session->userdata('mds_guest_wishlist');
                }
                array_push($wishlist, clean_number($product_id));
                $this->session->set_userdata('mds_guest_wishlist', $wishlist);
            }
        }
    }

    //get vendor total pageviews count
    public function get_vendor_total_pageviews_count($user_id)
    {
        $this->db->select('SUM(products.pageviews) as total_pageviews');
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)->where('products.user_id', clean_number($user_id));
        $query = $this->db->get('products');
        return $query->row()->total_pageviews;
    }

    //get vendor most viewed products
    public function get_vendor_most_viewed_products($user_id, $limit)
    {
        $this->build_query();
        $this->db->where('products.user_id', clean_number($user_id))->order_by('products.pageviews', 'DESC')->limit(clean_number($limit));
        $query = $this->db->get('products');
        return $query->result();
    }

    //increase product pageviews
    public function increase_product_pageviews($product)
    {
        if (!empty($product)) {
            if (!isset($_COOKIE['modesy_product_' . $product->id])) {
                //increase hit
                setcookie("modesy_product_" . $product->id, '1', time() + (86400 * 300), "/");
                $data = array(
                    'pageviews' => $product->pageviews + 1
                );
                $this->db->where('id', $product->id);
                $this->db->update('products', $data);
            }
        }
    }

    //get rss products by category
    public function get_rss_products_by_category($category_id)
    {
        $category_ids = $this->category_model->get_subcategories_tree_ids($category_id, true, true);
        if (empty($category_ids) || item_count($category_ids) < 1) {
            return array();
        }
        $this->build_query();
        $this->db->where_in('products.category_id', $category_ids, FALSE);
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }

    //get rss products by user
    public function get_rss_products_by_user($user_id)
    {
        $this->build_query();
        $this->db->where('users.id', clean_number($user_id));
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }

    //delete product
    public function delete_product($product_id)
    {
        $product = $this->get_product_by_id($product_id);
        if (!empty($product)) {
            $data = array(
                'is_deleted' => 1
            );
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    /*
    *------------------------------------------------------------------------------------------
    * LICENSE KEYS
    *------------------------------------------------------------------------------------------
    */

    //add license keys
    public function add_license_keys($product_id)
    {
        $license_keys = trim($this->input->post('license_keys', true));
        $allow_duplicate = $this->input->post('allow_duplicate', true);

        $license_keys_array = explode(",", $license_keys);
        if (!empty($license_keys_array)) {
            foreach ($license_keys_array as $license_key) {
                $license_key = trim($license_key);
                if (!empty($license_key)) {

                    //check duplicate
                    $add_key = true;
                    if (empty($allow_duplicate)) {
                        $row = $this->check_license_key($product_id, $license_key);
                        if (!empty($row)) {
                            $add_key = false;
                        }
                    }

                    //add license key
                    if ($add_key == true) {
                        $data = array(
                            'product_id' => $product_id,
                            'license_key' => trim($license_key),
                            'is_used' => 0
                        );
                        $this->db->insert('product_license_keys', $data);
                    }

                }
            }
        }
    }

    //get license keys
    public function get_license_keys($product_id)
    {
        $this->db->where('product_id', clean_number($product_id));
        return $this->db->get('product_license_keys')->result();
    }

    //get license key
    public function get_license_key($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->get('product_license_keys')->row();
    }

    //get unused license key
    public function get_unused_license_key($product_id)
    {
        $this->db->where('product_id', clean_number($product_id))->where('is_used = 0')->limit(1);
        return $this->db->get('product_license_keys')->row();
    }

    //check license key
    public function check_license_key($product_id, $license_key)
    {
        $this->db->where('product_id', clean_number($product_id))->where('license_key', $license_key);
        return $this->db->get('product_license_keys')->row();
    }

    //set license key used
    public function set_license_key_used($id)
    {
        $data = array(
            'is_used' => 1
        );
        $this->db->where('id', clean_number($id));
        $this->db->update('product_license_keys', $data);
    }

    //delete license key
    public function delete_license_key($id)
    {
        $license_key = $this->get_license_key($id);
        if (!empty($license_key)) {
            $this->db->where('id', $license_key->id);
            return $this->db->delete('product_license_keys');
        }
        return false;
    }

}
