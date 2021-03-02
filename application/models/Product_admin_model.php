<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_admin_model extends CI_Model
{
    //build query
    public function build_query($lang_id = null, $type = null)
    {
        if (empty($lang_id)) {
            $lang_id = $this->site_lang->id;
        }
        $this->db->select("products.*");
        $this->db->select("(SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = " . clean_number($lang_id) . " LIMIT 1) AS title");
        if (item_count($this->languages) > 1) {
            $this->db->select("(SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id != " . clean_number($lang_id) . " LIMIT 1) AS second_title");
        }
        if ($this->general_settings->membership_plans_system == 1) {
            if ($type == "expired") {
                $this->db->join('users', 'products.user_id = users.id AND users.is_membership_plan_expired = 1');
            } else {
                $this->db->join('users', 'products.user_id = users.id AND users.is_membership_plan_expired = 0');
            }
        }
    }

    //get products
    public function get_products()
    {
        $this->build_query();
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }

    //get latest products
    public function get_latest_products($limit)
    {
        $this->build_query();
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($limit));
        return $this->db->get('products')->result();
    }

    //get products count
    public function get_products_count()
    {
        $this->build_query();
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        return $this->db->count_all_results('products');
    }

    //get pending products
    public function get_pending_products()
    {
        $this->build_query();
        $this->db->where('status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }

    //get latest pending products
    public function get_latest_pending_products($limit)
    {
        $this->build_query();
        $this->db->where('status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($limit));
        return $this->db->get('products')->result();
    }

    //get pending products count
    public function get_pending_products_count()
    {
        $this->build_query();
        $this->db->where('status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        return $this->db->count_all_results('products');
    }

    //filter by values
    public function filter_products($list, $category_ids)
    {
        $product_type = input_get('product_type');
        $stock = input_get('stock');
        $q = input_get('q');

        if (!empty($category_ids)) {
            $this->db->where_in("products.category_id", $category_ids);
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
        if ($product_type == "physical" || $product_type == "digital") {
            $this->db->where('products.product_type', $product_type);
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
        if (!empty($list)) {
            if ($list == "products") {
                $this->db->where('products.visibility', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "promoted_products") {
                $this->db->where('products.visibility', 1)->where('products.is_promoted', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "special_offers") {
                $this->db->where('products.visibility', 1)->where('products.is_special_offer', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.special_offer_date', 'DESC');
            }
            if ($list == "pending_products") {
                $this->db->where('products.visibility', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "hidden_products") {
                $this->db->where('products.visibility', 0)->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "expired_products") {
                $this->db->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "sold_products") {
                $this->db->where('products.is_sold', 1)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "drafts") {
                $this->db->where('products.is_draft', 1)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "deleted_products") {
                $this->db->where('products.is_deleted', 1);
                $this->db->order_by('products.created_at', 'DESC');
            }
        }
    }

    //get filter category ids
    public function get_filter_category_ids()
    {
        $category_id = input_get('category');
        $subcategory_id = input_get('subcategory');
        if (!empty($subcategory_id)) {
            $category_id = $subcategory_id;
        }
        if (!empty($category_id)) {
            return $this->category_model->get_subcategories_tree_ids($category_id, false, false);
        }
        return null;
    }

    //get paginated products count
    public function get_paginated_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        return $this->db->count_all_results('products');
    }

    //get paginated products
    public function get_paginated_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get paginated promoted products count
    public function get_paginated_promoted_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        return $this->db->count_all_results('products');
    }

    //get paginated promoted products
    public function get_paginated_promoted_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get paginated pending products count
    public function get_paginated_pending_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status !=', 1);
        return $this->db->count_all_results('products');
    }

    //get paginated pending products
    public function get_paginated_pending_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status !=', 1);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get paginated drafts count
    public function get_paginated_drafts_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        return $this->db->count_all_results('products');
    }

    //get paginated drafts
    public function get_paginated_drafts($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get paginated hidden product count
    public function get_paginated_hidden_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        return $this->db->count_all_results('products');
    }

    //get paginated hidden products
    public function get_paginated_hidden_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get expired product count
    public function get_paginated_expired_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query(null, "expired");
        $this->filter_products($list, $category_ids);
        return $this->db->count_all_results('products');
    }

    //get paginated expired products
    public function get_paginated_expired_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query(null, "expired");
        $this->filter_products($list, $category_ids);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get sold product count
    public function get_paginated_sold_products_count()
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products("sold_products", $category_ids);
        return $this->db->count_all_results('products');
    }

    //get paginated sold products
    public function get_paginated_sold_products($per_page, $offset)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products("sold_products", $category_ids);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get paginated deleted product count
    public function get_paginated_deleted_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        return $this->db->count_all_results('products');
    }

    //get paginated deleted products
    public function get_paginated_deleted_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get product
    public function get_product($id)
    {
        $this->db->where('products.id', clean_number($id));
        return $this->db->get('products')->row();
    }

    //approve product
    public function approve_product($id)
    {
        $product = $this->get_product($id);
        if (!empty($product)) {
            $data = array(
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    //add remove promoted products
    public function add_remove_promoted_products($product_id, $day_count)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            $transaction = null;
            if ($product->is_promoted == 1) {
                $data = array(
                    'is_promoted' => 0,
                );
            } else {
                $date = date('Y-m-d H:i:s');
                $end_date = date('Y-m-d H:i:s', strtotime($date . ' + ' . clean_number($day_count) . ' days'));
                $data = array(
                    'is_promoted' => 1,
                    'promote_start_date' => $date,
                    'promote_end_date' => $end_date
                );
                $transaction_id = $this->input->post('transaction_id', true);
                $transaction = $this->db->where('id', clean_number($transaction_id))->get('promoted_transactions')->row();
                if (!empty($transaction)) {
                    $data["promote_plan"] = $transaction->purchased_plan;
                    $data["promote_day"] = $transaction->day_count;
                }
            }
            $this->db->where('id', $product->id);
            $result = $this->db->update('products', $data);

            if ($result && !empty($transaction)) {
                $data_transaction = array(
                    'payment_status' => "Completed"
                );
                $this->db->where('id', $transaction->id);
                $this->db->update('promoted_transactions', $data_transaction);
            }

            return $result;
        }
        return false;
    }

    //add remove special offers
    public function add_remove_special_offers($product_id)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            if ($product->is_special_offer == 1) {
                $data = array(
                    'is_special_offer' => 0,
                    'special_offer_date' => ""
                );
            } else {
                $data = array(
                    'is_special_offer' => 1,
                    'special_offer_date' => date('Y-m-d H:i:s')
                );
            }
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    //delete product
    public function delete_product($product_id)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            $data = array(
                'is_deleted' => 1
            );
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    //delete product permanently
    public function delete_product_permanently($id)
    {
        $product = $this->get_product($id);
        if (!empty($product)) {
            //delete product details
            $this->db->where('product_id', $product->id)->delete('product_details');
            //delete product license keys
            $this->db->where('product_id', $product->id)->delete('product_license_keys');
            //delete images
            $this->file_model->delete_product_images($product->id);
            //delete digital product
            if ($product->product_type == "digital") {
                $this->file_model->delete_digital_file($product->id);
            }
            //delete comments
            $this->db->where('product_id', $product->id)->delete('comments');
            //delete reviews
            $this->db->where('product_id', $product->id)->delete('reviews');
            //delete from wishlist
            $this->db->where('product_id', $product->id)->delete('wishlist');
            //delete from custom fields
            $this->db->where('product_id', $product->id)->delete('custom_fields_product');
            //delete variations
            $variations = $this->db->where('product_id', $product->id)->get('variations')->result();
            if (!empty($variations)) {
                foreach ($variations as $variation) {
                    $this->db->where('variation_id', $variation->id)->delete('variation_options');
                    $this->db->where('id', $variation->id)->delete('variations');
                }
            }
            return $this->db->where('id', $product->id)->delete('products');
        }
        return false;
    }

    //delete multi product
    public function delete_multi_products($product_ids)
    {
        if (!empty($product_ids)) {
            foreach ($product_ids as $id) {
                $this->delete_product($id);
            }
        }
    }

    //delete multi product
    public function delete_multi_products_permanently($product_ids)
    {
        if (!empty($product_ids)) {
            foreach ($product_ids as $id) {
                $this->delete_product_permanently($id);
            }
        }
    }

    //restore product
    public function restore_product($product_id)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            $data = array(
                'is_deleted' => 0
            );
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    /*
    *------------------------------------------------------------------------------------------
    * CSV BULK IMPORT
    *------------------------------------------------------------------------------------------
    */

    //generate CSV object
    public function generate_csv_object($file_path)
    {
        $array = array();
        $fields = array();
        $txt_name = uniqid() . '-' . $this->auth_user->id . '.txt';
        $i = 0;
        $handle = fopen($file_path, "r");
        if ($handle) {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }
                foreach ($row as $k => $value) {
                    $array[$i][$fields[$k]] = $value;
                }
                $i++;
            }
            if (!feof($handle)) {
                return false;
            }
            fclose($handle);

            if (!empty($array)) {
                $txt_file = fopen(FCPATH . "uploads/temp/" . $txt_name, "w");
                fwrite($txt_file, serialize($array));
                fclose($txt_file);
                $csv_object = new stdClass();
                $csv_object->number_of_items = count($array);
                $csv_object->txt_file_name = $txt_name;
                @unlink($file_path);
                return $csv_object;
            }
        }
        return false;
    }

    //import csv item
    public function import_csv_item($txt_file_name, $index)
    {
        $file_path = FCPATH . 'uploads/temp/' . $txt_file_name;
        $file = fopen($file_path, 'r');
        $content = fread($file, filesize($file_path));
        $array = unserialize_data($content);
        if (!empty($array)) {
            $listing_type = $this->input->post('listing_type', true);
            $currency = $this->input->post('currency', true);
            $i = 1;
            foreach ($array as $item) {
                if (!empty($listing_type) && !empty($currency)) {
                    if ($i == $index) {
                        if (!$this->membership_model->is_allowed_adding_product()) {
                            echo "Upgrade your current plan if you want to upload more ads!";
                            exit();
                        }
                        $data = array();
                        $product_title = get_csv_value($item, 'title');
                        $data['slug'] = !empty(get_csv_value($item, 'slug')) ? get_csv_value($item, 'slug') : str_slug($product_title);
                        $data['product_type'] = "physical";
                        $data['listing_type'] = !empty($listing_type) ? $listing_type : 'sell_on_site';
                        $data['sku'] = get_csv_value($item, 'sku');
                        $data['category_id'] = !empty(get_csv_value($item, 'category_id', 'int')) ? get_csv_value($item, 'category_id', 'int') : 1;
                        $data['price'] = $this->get_csv_price(get_csv_value($item, 'price'));
                        $data['currency'] = !empty($currency) ? $currency : 'USD';
                        $data['discount_rate'] = get_csv_value($item, 'discount_rate', 'int');
                        $data['vat_rate'] = get_csv_value($item, 'vat_rate', 'int');
                        $data['user_id'] = $this->auth_user->id;
                        $data['status'] = 0;
                        $data['is_promoted'] = 0;
                        $data['promote_start_date'] = "";
                        $data['promote_end_date'] = "";
                        $data['promote_plan'] = "none";
                        $data['promote_day'] = 0;
                        $data['visibility'] = 1;
                        $data['rating'] = 0;
                        $data['pageviews'] = 0;
                        $data['demo_url'] = "";
                        $data['external_link'] = "";
                        $data['files_included'] = "";
                        $data['stock'] = get_csv_value($item, 'stock');
                        $data['shipping_class_id'] = 0;
                        $data['shipping_delivery_time_id'] = 0;
                        $data['multiple_sale'] = 1;
                        $data['is_sold'] = 0;
                        $data['is_deleted'] = 0;
                        $data['is_draft'] = 0;
                        $data['is_free_product'] = 0;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        if ($this->general_settings->approve_before_publishing == 0 || $this->auth_user->role == 'admin') {
                            $data["status"] = 1;
                        }
                        if ($this->db->insert('products', $data)) {
                            //last id
                            $last_id = $this->db->insert_id();
                            //update slug
                            $this->product_model->update_slug($last_id);
                            //add product title description
                            $data_title_desc = array(
                                'product_id' => $last_id,
                                'lang_id' => $this->selected_lang->id,
                                'title' => $product_title,
                                'description' => get_csv_value($item, 'description'),
                                'seo_title' => "",
                                'seo_description' => "",
                                'seo_keywords' => ""
                            );
                            $this->db->insert('product_details', $data_title_desc);

                            //upload images
                            $this->upload_product_images_csv(get_csv_value($item, 'image_url'), $last_id);

                            return $product_title;
                        }
                    }
                    $i++;
                }
            }
        }
    }

    //upload product csv images
    public function upload_product_images_csv($image_url, $product_id)
    {
        if (!empty($image_url)) {
            $this->load->model('upload_model');
            $array_image_urls = explode(',', $image_url);
            if (!empty($array_image_urls)) {
                foreach ($array_image_urls as $url) {
                    $url = trim($url);
                    if (filter_var($url, FILTER_VALIDATE_URL) !== FALSE) {
                        //upload images
                        $save_to = FCPATH . "uploads/temp/temp-" . $this->auth_user->id . ".jpg";
                        @copy($url, $save_to);
                        if (!empty($save_to) && file_exists($save_to)) {
                            $data_image = [
                                'product_id' => $product_id,
                                'image_default' => $this->upload_model->product_default_image_upload($save_to, "images"),
                                'image_big' => $this->upload_model->product_big_image_upload($save_to, "images"),
                                'image_small' => $this->upload_model->product_small_image_upload($save_to, "images"),
                                'is_main' => 0,
                                'storage' => "local"
                            ];
                            $this->upload_model->delete_temp_image($save_to);
                        }
                        //move to s3
                        if ($this->storage_settings->storage == "aws_s3") {
                            $this->load->model("aws_model");
                            $data_image["storage"] = "aws_s3";
                            //move images
                            if (!empty($data_image["image_default"])) {
                                $this->aws_model->put_product_object($data_image["image_default"], FCPATH . "uploads/images/" . $data_image["image_default"]);
                                delete_file_from_server("uploads/images/" . $data_image["image_default"]);
                            }
                            if (!empty($data_image["image_big"])) {
                                $this->aws_model->put_product_object($data_image["image_big"], FCPATH . "uploads/images/" . $data_image["image_big"]);
                                delete_file_from_server("uploads/images/" . $data_image["image_big"]);
                            }
                            if (!empty($data_image["image_small"])) {
                                $this->aws_model->put_product_object($data_image["image_small"], FCPATH . "uploads/images/" . $data_image["image_small"]);
                                delete_file_from_server("uploads/images/" . $data_image["image_small"]);
                            }
                        }
                        @$this->db->close();
                        @$this->db->initialize();
                        $this->db->insert('images', $data_image);
                    }
                }
            }
        }
    }

    //get csv price
    public function get_csv_price($price)
    {
        if (!empty($price)) {
            $price = str_replace(',', '.', $price);
            $price = preg_replace('/[^0-9\.,]/', '', $price);
            $price = @number_format($price, 2, '.', '');
            $price = str_replace('.00', '', $price);
            $price = floatval($price);
            return $price * 100;
        }
        return 0;
    }

}
