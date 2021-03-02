<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Variation_model extends CI_Model
{
    //add variation
    public function add_variation()
    {
        $product_id = $this->input->post('product_id', true);
        $array_names = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'label' => $this->input->post('label_lang_' . $language->id, true)
            );
            array_push($array_names, $item);
        }
        $array_names = serialize($array_names);
        $data = array(
            'product_id' => $product_id,
            'user_id' => $this->auth_user->id,
            'parent_id' => $this->input->post('parent_id', true),
            'label_names' => $array_names,
            'variation_type' => $this->input->post('variation_type', true),
            'insert_type' => 'new',
            'option_display_type' => $this->input->post('option_display_type', true),
            'show_images_on_slider' => $this->input->post('show_images_on_slider', true),
            'use_different_price' => $this->input->post('use_different_price', true),
            'is_visible' => $this->input->post('is_visible', true)
        );

        if (empty($data["parent_id"])) {
            $data["parent_id"] = 0;
        }
        if (empty($data["show_images_on_slider"])) {
            $data["show_images_on_slider"] = 0;
        }
        if (empty($data["use_different_price"])) {
            $data["use_different_price"] = 0;
        }

        $this->db->insert('variations', $data);
    }

    //edit variation
    public function edit_variation($id)
    {
        $array_names = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'label' => $this->input->post('label_lang_' . $language->id, true)
            );
            array_push($array_names, $item);
        }
        $array_names = serialize($array_names);
        $data = array(
            'parent_id' => $this->input->post('parent_id', true),
            'label_names' => $array_names,
            'variation_type' => $this->input->post('variation_type', true),
            'option_display_type' => $this->input->post('option_display_type', true),
            'show_images_on_slider' => $this->input->post('show_images_on_slider', true),
            'use_different_price' => $this->input->post('use_different_price', true),
            'is_visible' => $this->input->post('is_visible', true)
        );
        if (empty($data["parent_id"])) {
            $data["parent_id"] = 0;
        }
        if (empty($data["show_images_on_slider"])) {
            $data["show_images_on_slider"] = 0;
        }
        if (empty($data["use_different_price"])) {
            $data["use_different_price"] = 0;
        }

        $this->db->where('id', clean_number($id));
        $this->db->update('variations', $data);
    }

    //get variation
    public function get_variation($id)
    {
        $this->db->where('id', clean_number($id));
        $query = $this->db->get('variations');
        return $query->row();
    }

    //select variation
    public function select_variation($variation_id, $product_id)
    {
        $variation = $this->get_variation($variation_id);
        $new_variation_id = 0;
        if (!empty($variation)) {
            $data = array(
                'product_id' => $product_id,
                'user_id' => $this->auth_user->id,
                'parent_id' => $variation->parent_id,
                'label_names' => $variation->label_names,
                'variation_type' => $variation->variation_type,
                'insert_type' => 'copy',
                'option_display_type' => $variation->option_display_type,
                'show_images_on_slider' => $variation->show_images_on_slider,
                'use_different_price' => $variation->use_different_price,
                'is_visible' => $variation->is_visible
            );
            $this->db->insert('variations', $data);
            $new_variation_id = $this->db->insert_id();
        }

        if (!empty($new_variation_id)) {
            $options = $this->get_variation_options($variation_id);
            if (!empty($options)) {
                foreach ($options as $option) {
                    $data = array(
                        'variation_id' => $new_variation_id,
                        'parent_id' => $option->parent_id,
                        'option_names ' => $option->option_names,
                        'stock' => $option->stock,
                        'color' => $option->color,
                        'price' => 0,
                        'discount_rate' => 0,
                        'is_default' => $option->is_default,
                        'use_default_price' => 1,
                        'no_discount' => 1
                    );
                    $this->db->insert('variation_options', $data);
                }
            }
        }
    }

    //get variation by user id
    public function get_variation_by_user_id($user_id)
    {
        $this->db->where('user_id', clean_number($user_id));
        $query = $this->db->get('variations');
        return $query->result();
    }

    //get product variations
    public function get_product_variations($product_id)
    {
        $this->db->where('product_id', clean_number($product_id));
        $query = $this->db->get('variations');
        return $query->result();
    }

    //is there variation uses different price
    public function is_there_variation_uses_different_price($product_id, $except_id = null)
    {
        if (!empty($except_id)) {
            $sql = "SELECT * FROM variations WHERE id != ? AND product_id = ? AND use_different_price = 1 ORDER BY id LIMIT 1";
            $query = $this->db->query($sql, array(clean_number($except_id), clean_number($product_id)));
        } else {
            $sql = "SELECT * FROM variations WHERE product_id = ? AND use_different_price = 1 ORDER BY id LIMIT 1";
            $query = $this->db->query($sql, array(clean_number($product_id)));
        }
        if (!empty($query->row())) {
            return true;
        }
        return false;
    }

    //get product sub variation
    public function get_product_sub_variation($parent_id)
    {
        $sql = "SELECT * FROM variations WHERE parent_id = ? ORDER BY id";
        $query = $this->db->query($sql, array(clean_number($parent_id)));
        return $query->row();
    }

    //get half width product variations
    public function get_half_width_product_variations($product_id)
    {
        $sql = "SELECT * FROM variations WHERE product_id = ? AND is_visible = 1 AND (variation_type = 'text' OR variation_type = 'number' OR variation_type = 'dropdown') ORDER BY id";
        $query = $this->db->query($sql, array(clean_number($product_id)));
        return $query->result();
    }

    //get full width product variations
    public function get_full_width_product_variations($product_id)
    {
        $sql = "SELECT * FROM variations WHERE product_id = ? AND is_visible = 1 AND (variation_type = 'checkbox' OR variation_type = 'radio_button') ORDER BY id";
        $query = $this->db->query($sql, array(clean_number($product_id)));
        return $query->result();
    }

    //delete variation
    public function delete_variation($id)
    {
        $this->db->where('id', clean_number($id));
        if ($this->db->delete('variations')) {
            $this->delete_variation_options($id);
        }
    }

    //add variation option
    public function add_variation_option($variation_id)
    {
        $array_names = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'option_name' => $this->input->post('option_name_' . $language->id, true)
            );
            array_push($array_names, $item);
        }
        $array_names = serialize($array_names);
        $data = array(
            'variation_id' => $variation_id,
            'parent_id' => $this->input->post('parent_id', true),
            'option_names ' => $array_names,
            'stock' => $this->input->post('option_stock', true),
            'color' => $this->input->post('option_color', true),
            'price' => $this->input->post('option_price', true),
            'discount_rate' => $this->input->post('option_discount_rate', true),
            'is_default' => $this->input->post('is_default', true),
            'use_default_price' => $this->input->post('use_default_price', true),
            'no_discount' => $this->input->post('no_discount', true)
        );

        if (!empty($data["price"])) {
            $data["price"] = get_price($data["price"], 'database');
        } else {
            $data["price"] = 0;
        }
        if (empty($data["color"])) {
            $data["color"] = "";
        }
        if (empty($data["discount_rate"])) {
            $data["discount_rate"] = 0;
        }
        if ($data["discount_rate"] > 99) {
            $data["discount_rate"] = 99;
        }
        if (empty($data["use_default_price"])) {
            $data["use_default_price"] = 0;
        }
        if (empty($data["no_discount"])) {
            $data["no_discount"] = 0;
        }
        if (empty($data["parent_id"])) {
            $data["parent_id"] = 0;
        }
        if (empty($data["is_default"])) {
            $data["is_default"] = 0;
        } else {
            $data["price"] = 0;
            $data["discount_rate"] = 0;
        }

        if ($this->db->insert('variation_options', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    //edit variation option
    public function edit_variation_option($option_id)
    {
        $array_names = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'option_name' => $this->input->post('option_name_' . $language->id, true)
            );
            array_push($array_names, $item);
        }
        $array_names = serialize($array_names);
        $data = array(
            'parent_id' => $this->input->post('parent_id', true),
            'option_names ' => $array_names,
            'stock' => $this->input->post('option_stock', true),
            'color' => $this->input->post('option_color', true),
            'price' => $this->input->post('option_price', true),
            'discount_rate' => $this->input->post('option_discount_rate', true),
            'is_default' => $this->input->post('is_default', true),
            'use_default_price' => $this->input->post('use_default_price', true),
            'no_discount' => $this->input->post('no_discount', true)
        );

        if (!empty($data["price"])) {
            $data["price"] = get_price($data["price"], 'database');
        } else {
            $data["price"] = 0;
        }
        if (empty($data["color"])) {
            $data["color"] = "";
        }
        if (empty($data["discount_rate"])) {
            $data["discount_rate"] = 0;
        }
        if ($data["discount_rate"] > 99) {
            $data["discount_rate"] = 99;
        }
        if (empty($data["use_default_price"])) {
            $data["use_default_price"] = 0;
        }
        if (empty($data["no_discount"])) {
            $data["no_discount"] = 0;
        }
        if (empty($data["parent_id"])) {
            $data["parent_id"] = 0;
        }
        if (empty($data["is_default"])) {
            $data["is_default"] = 0;
        } else {
            $data["price"] = 0;
            $data["discount_rate"] = 0;
        }

        $this->db->where('id', clean_number($option_id));
        return $this->db->update('variation_options', $data);
    }

    //clear variation default option
    public function clear_variation_default_option($variation_id, $option_id)
    {
        $variation_option = $this->get_variation_option($option_id);

        if (!empty($variation_option) && $variation_option->is_default == 1) {
            $data = array(
                'is_default' => 0
            );
            $this->db->where('id != ', clean_number($option_id));
            $this->db->where('variation_id', clean_number($variation_id));
            return $this->db->update('variation_options', $data);
        }
    }

    //is variation option exist
    public function is_variation_option_exist($variation_id, $option_id = null)
    {
        $array_names = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'option_name' => $this->input->post('option_name_' . $language->id, true)
            );
            array_push($array_names, $item);
        }
        $array_names = serialize($array_names);

        if (!empty($option_id)) {
            $this->db->where('id !=', $option_id);
        }
        $this->db->where('variation_id', $variation_id);
        $this->db->where('option_names', $array_names);
        $query = $this->db->get('variation_options');
        $rows = $query->result();
        if (count($rows) > 0) {
            return true;
        }
    }

    //get variation options
    public function get_variation_options($variation_id)
    {
        $sql = "SELECT * FROM variation_options WHERE variation_id = ? ORDER BY id";
        $query = $this->db->query($sql, array(clean_number($variation_id)));
        return $query->result();
    }

    //get variation option
    public function get_variation_option($option_id)
    {
        $sql = "SELECT * FROM variation_options WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($option_id)));
        return $query->row();
    }

    //get variation default option
    public function get_variation_default_option($variation_id)
    {
        $sql = "SELECT * FROM variation_options WHERE variation_id = ? ORDER BY is_default DESC, id LIMIT 1";
        $query = $this->db->query($sql, array(clean_number($variation_id)));
        return $query->row();
    }

    //get variation sub options
    public function get_variation_sub_options($parent_id)
    {
        $sql = "SELECT * FROM variation_options WHERE parent_id = ? ORDER BY id";
        $query = $this->db->query($sql, array(clean_number($parent_id)));
        return $query->result();
    }

    //get variation option images
    public function get_variation_option_images($option_id)
    {
        $this->db->where('variation_option_id', $option_id);
        $query = $this->db->get('images_variation');
        return $query->result();
    }

    //get variation option main image
    public function get_variation_option_main_image($option_id)
    {
        $sql = "SELECT * FROM images_variation WHERE variation_option_id = ? ORDER BY is_main DESC LIMIT 1";
        $query = $this->db->query($sql, array(clean_number($option_id)));
        return $query->row();
    }

    //upload variation image
    public function upload_variation_image($product_id, $variation_option_id)
    {
        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file');
        if (!empty($temp_path)) {
            $data = array(
                'product_id' => $product_id,
                'variation_option_id' => $variation_option_id,
                'image_default' => $this->upload_model->product_default_image_upload($temp_path, "images"),
                'image_big' => $this->upload_model->product_big_image_upload($temp_path, "images"),
                'image_small' => $this->upload_model->product_variation_small_image_upload($temp_path, "images"),
                'is_main' => 0,
                'storage' => "local"
            );
            $this->upload_model->delete_temp_image($temp_path);

            //move to s3
            if ($this->storage_settings->storage == "aws_s3") {
                $this->load->model("aws_model");
                $data["storage"] = "aws_s3";
                //move images
                if (!empty($data["image_default"])) {
                    $this->aws_model->put_product_object($data["image_default"], FCPATH . "uploads/images/" . $data["image_default"]);
                    delete_file_from_server("uploads/images/" . $data["image_default"]);
                }
                if (!empty($data["image_big"])) {
                    $this->aws_model->put_product_object($data["image_big"], FCPATH . "uploads/images/" . $data["image_big"]);
                    delete_file_from_server("uploads/images/" . $data["image_big"]);
                }
                if (!empty($data["image_small"])) {
                    $this->aws_model->put_product_object($data["image_small"], FCPATH . "uploads/images/" . $data["image_small"]);
                    delete_file_from_server("uploads/images/" . $data["image_small"]);
                }
            }
            $this->db->insert('images_variation', $data);
            $data = array(
                'image_id' => $this->db->insert_id()
            );
            echo json_encode($data);
        }
    }

    //upload variation images session
    public function upload_variation_images_session()
    {
        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file');
        if (!empty($temp_path)) {
            $file_id = $this->input->post('file_id', true);
            $images = $this->get_sess_variation_images_array();
            $item = new stdClass();
            $item->img_default = $this->upload_model->product_default_image_upload($temp_path, "temp");
            $item->img_big = $this->upload_model->product_big_image_upload($temp_path, "temp");
            $item->img_small = $this->upload_model->product_variation_small_image_upload($temp_path, "temp");
            $item->file_id = $file_id;
            $item->is_main = 0;
            $item->file_time = time();
            array_push($images, $item);
            $this->set_sess_variation_images_array($images);
            $this->upload_model->delete_temp_image($temp_path);
        }
    }

    //add variation images
    public function add_variation_images($product_id, $variation_option_id)
    {
        $images = $this->get_sess_variation_images_array();
        if (!empty($images)) {
            foreach ($images as $image) {
                if (!empty($image)) {
                    $image_storage = "local";
                    $this->load->model('upload_model');
                    $directory = $this->upload_model->create_upload_directory('images');
                    if ($this->storage_settings->storage == "aws_s3") {
                        $image_storage = "aws_s3";
                        $this->load->model("aws_model");
                        //move default image
                        $this->aws_model->put_product_object($directory . $image->img_default, FCPATH . "uploads/temp/" . $image->img_default);
                        delete_file_from_server("uploads/temp/" . $image->img_default);
                        //move big image
                        $this->aws_model->put_product_object($directory . $image->img_big, FCPATH . "uploads/temp/" . $image->img_big);
                        delete_file_from_server("uploads/temp/" . $image->img_big);
                        //move small image
                        $this->aws_model->put_product_object($directory . $image->img_small, FCPATH . "uploads/temp/" . $image->img_small);
                        delete_file_from_server("uploads/temp/" . $image->img_small);
                    } else {
                        //move default image
                        copy(FCPATH . "uploads/temp/" . $image->img_default, FCPATH . "uploads/images/" . $directory . $image->img_default);
                        delete_file_from_server("uploads/temp/" . $image->img_default);
                        //move big image
                        copy(FCPATH . "uploads/temp/" . $image->img_big, FCPATH . "uploads/images/" . $directory . $image->img_big);
                        delete_file_from_server("uploads/temp/" . $image->img_big);
                        //move small image
                        copy(FCPATH . "uploads/temp/" . $image->img_small, FCPATH . "uploads/images/" . $directory . $image->img_small);
                        delete_file_from_server("uploads/temp/" . $image->img_small);
                    }

                    //add to database
                    $data = array(
                        'product_id' => $product_id,
                        'variation_option_id' => $variation_option_id,
                        'image_default' => $directory . $image->img_default,
                        'image_big' => $directory . $image->img_big,
                        'image_small' => $directory . $image->img_small,
                        'is_main' => $image->is_main,
                        'storage' => $image_storage
                    );
                    $this->db->insert('images_variation', $data);
                }
            }
        }

        $this->unset_sess_variation_images_array();
    }

    //set variation images array session
    public function set_sess_variation_images_array($images)
    {
        $this->session->set_userdata('mds_vr_images_ary', $images);
    }

    //get variation images array session
    public function get_sess_variation_images_array()
    {
        $images = array();
        if (!empty($this->session->userdata('mds_vr_images_ary'))) {
            $images = $this->session->userdata('mds_vr_images_ary');
        }
        if (!empty($images)) {
            usort($images, function ($a, $b) {
                if ($a->file_time == $b->file_time) return 0;
                return $a->file_time < $b->file_time ? 1 : -1;
            });
        }
        return $images;
    }

    //set variation image main session
    public function set_sess_variation_image_main($file_id)
    {
        $images = $this->get_sess_variation_images_array();
        if (!empty($images)) {
            foreach ($images as $image) {
                if ($image->file_id == $file_id) {
                    $image->is_main = 1;
                } else {
                    $image->is_main = 0;
                }
            }
        }
        $this->set_sess_variation_images_array($images);
    }

    //set variation image main
    public function set_variation_image_main($file_id, $variation_option_id)
    {
        $this->db->where('variation_option_id', $variation_option_id);
        $query = $this->db->get('images_variation');
        $rows = $query->result();
        if (!empty($rows)) {
            foreach ($rows as $row) {
                if ($row->id == $file_id) {
                    $data['is_main'] = 1;
                } else {
                    $data['is_main'] = 0;
                }
                $this->db->where('id', $row->id);
                $this->db->update('images_variation', $data);
            }
        }
    }

    //unset variation images array session
    public function unset_sess_variation_images_array()
    {
        if (!empty($this->session->userdata('mds_vr_images_ary'))) {
            $this->session->unset_userdata('mds_vr_images_ary');
        }
    }

    //get variation image
    public function get_variation_image($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('images_variation');
        return $query->row();
    }

    //delete variation options
    public function delete_variation_options($variation_id)
    {
        $options = $this->get_variation_options($variation_id);
        if (!empty($options)) {
            foreach ($options as $item) {
                $this->delete_variation_option($item->id);
            }
        }
    }

    //delete variation option
    public function delete_variation_option($option_id)
    {
        $option = $this->get_variation_option($option_id);
        if (!empty($option)) {
            $this->db->where('id', $option->id);
            $result = $this->db->delete('variation_options');
            if ($result) {
                //delete images
                $images = $this->get_variation_option_images($option->id);
                if (!empty($images)) {
                    foreach ($images as $image) {
                        $this->delete_variation_image($image->id);
                    }
                }
            }
            return $result;
        }
        return false;
    }

    //delete variation image session
    public function delete_variation_image_session($file_id)
    {
        $images = $this->get_sess_variation_images_array();
        $images_new = array();
        if (!empty($images)) {
            foreach ($images as $image) {
                if ($image->file_id == $file_id) {
                    delete_file_from_server("uploads/temp/" . $image->img_default);
                    delete_file_from_server("uploads/temp/" . $image->img_big);
                    delete_file_from_server("uploads/temp/" . $image->img_small);
                } else {
                    $item = new stdClass();
                    $item->img_default = $image->img_default;
                    $item->img_big = $image->img_big;
                    $item->img_small = $image->img_small;
                    $item->file_id = $image->file_id;
                    $item->is_main = $image->is_main;
                    $item->file_time = $image->file_time;
                    array_push($images_new, $item);
                }
            }
        }
        unset($images);
        $this->set_sess_variation_images_array($images_new);
    }

    //delete variation image
    public function delete_variation_image($image_id)
    {
        $image = $this->get_variation_image($image_id);
        if (!empty($image)) {
            if ($image->storage == "aws_s3") {
                $this->load->model("aws_model");
                $this->aws_model->delete_product_object($image->image_default);
                $this->aws_model->delete_product_object($image->image_big);
                $this->aws_model->delete_product_object($image->image_small);
            } else {
                delete_file_from_server("uploads/images/" . $image->image_default);
                delete_file_from_server("uploads/images/" . $image->image_big);
                delete_file_from_server("uploads/images/" . $image->image_small);
            }
            $this->db->where('id', $image->id);
            $this->db->delete('images_variation');
        }
    }

}