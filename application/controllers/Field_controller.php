<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Field_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add Variation Post
     */
    public function add_variation_post()
    {
        if ($this->auth_check) {
            $product_id = $this->input->post('product_id', true);
            $this->variation_model->add_variation();
            $this->product_variation_list_html_content($product_id, "_response_variations");
        }
    }

    /**
     * Edit Variation
     */
    public function edit_variation()
    {
        $id = $this->input->post('id', true);
        if ($this->check_variation_permission($id)) {
            $this->product_variation_html_content($id, "_response_variation_edit");
        }
    }

    /**
     * Edit Variation Post
     */
    public function edit_variation_post()
    {
        $variation_id = $this->input->post('variation_id', true);
        if ($this->check_variation_permission($variation_id)) {
            $product_id = $this->input->post('product_id', true);
            $this->variation_model->edit_variation($variation_id);
            $this->product_variation_list_html_content($product_id, "_response_variations");
        }
    }

    /**
     * Delete Variation Post
     */
    public function delete_variation_post()
    {
        if ($this->auth_check) {
            $id = $this->input->post('id', true);
            $variation = $this->variation_model->get_variation($id);
            if (!empty($variation)) {
                if ($variation->user_id == $this->auth_user->id || $this->auth_user->role == "admin") {
                    $this->variation_model->delete_variation($id);
                    $this->product_variation_list_html_content($variation->product_id, "_response_variations");
                }
            }
        }
    }

    //product variation list html content
    private function product_variation_list_html_content($product_id, $view)
    {
        $vars = array(
            "product_variations" => $this->variation_model->get_product_variations($product_id)
        );
        $html_content = $this->load->view('dashboard/product/variation/' . $view, $vars, true);
        $data = array(
            'result' => 1,
            'html_content' => $html_content,
        );
        echo json_encode($data);
        reset_flash_data();
    }

    //product variation html content
    private function product_variation_html_content($variation_id, $view)
    {
        $variation = $this->variation_model->get_variation($variation_id);
        $product_variations = null;
        $parent_variation_options = null;
        $product = null;
        if (!empty($variation)) {
            $product = $this->product_model->get_product_by_id($variation->product_id);
            $product_variations = $this->variation_model->get_product_variations($variation->product_id);
            if ($variation->parent_id != 0) {
                $parent_variation_options = $this->variation_model->get_variation_options($variation->parent_id);
            }
        }
        $vars = array(
            "variation" => $variation,
            "product_variations" => $product_variations,
            "parent_variation_options" => $parent_variation_options,
            "product" => $product
        );
        $html_content = $this->load->view('dashboard/product/variation/' . $view, $vars, true);
        $data = array(
            'result' => 1,
            'html_content' => $html_content,
        );
        echo json_encode($data);
        reset_flash_data();
    }


    /**
     * Add Variation Option
     */
    public function add_variation_option()
    {
        $variation_id = $this->input->post('variation_id', true);
        if ($this->check_variation_permission($variation_id)) {
            $this->product_variation_html_content($variation_id, "_add_option");
        }
    }

    /**
     * Add Variation Option Post
     */
    public function add_variation_option_post()
    {
        $variation_id = $this->input->post('variation_id', true);
        if ($this->check_variation_permission($variation_id)) {
            $variation = $this->variation_model->get_variation($variation_id);
            if (!empty($variation)) {
                if ($this->variation_model->is_variation_option_exist($variation_id)) {
                    $this->session->set_flashdata('error', trans("msg_option_exists"));
                } else {
                    $variation_option_id = $this->variation_model->add_variation_option($variation_id);
                    if ($variation_option_id) {
                        $this->variation_model->add_variation_images($variation->product_id, $variation_option_id);
                        //clear default option
                        $this->variation_model->clear_variation_default_option($variation_id, $variation_option_id);
                        $this->session->set_flashdata('success', trans("msg_option_added"));
                    } else {
                        $this->session->set_flashdata('error', trans("msg_error"));
                    }
                }
                $this->product_variation_html_content($variation_id, "_add_option");
            }
        }
    }

    /**
     * View Variation Options
     */
    public function view_variation_options()
    {
        $variation_id = $this->input->post('variation_id', true);
        if ($this->check_variation_permission($variation_id)) {
            $this->product_variation_options_html_content($variation_id, "_options");
        }
    }

    //product variation options html content
    private function product_variation_options_html_content($variation_id, $view)
    {
        $variation = $this->variation_model->get_variation($variation_id);
        $vars = array(
            "variation" => $variation,
            "variation_options" => $this->variation_model->get_variation_options($variation_id),
            "product" => $this->product_model->get_product_by_id($variation->product_id)
        );
        $html_content = $this->load->view('dashboard/product/variation/' . $view, $vars, true);
        $data = array(
            'result' => 1,
            'html_content' => $html_content,
        );
        echo json_encode($data);
        reset_flash_data();
    }

    //edit variation option
    public function edit_variation_option()
    {
        $variation_id = $this->input->post('variation_id', true);
        $parent_variation_options = null;
        if ($this->check_variation_permission($variation_id)) {
            $variation = $this->variation_model->get_variation($variation_id);
            if (!empty($variation) && $variation->parent_id != 0) {
                $parent_variation_options = $this->variation_model->get_variation_options($variation->parent_id);
            }
            $option_id = $this->input->post('option_id', true);
            $vars = array(
                "variation" => $variation,
                "variation_option" => $this->variation_model->get_variation_option($option_id),
                "variation_option_images" => $this->variation_model->get_variation_option_images($option_id),
                "parent_variation_options" => $parent_variation_options,
            );
            $html_content = $this->load->view('dashboard/product/variation/_edit_option', $vars, true);
            $data = array(
                'result' => 1,
                'html_content' => $html_content,
            );
            echo json_encode($data);
        }
    }

    /**
     * Edit Variation Option Post
     */
    public function edit_variation_option_post()
    {
        $variation_id = $this->input->post('variation_id', true);
        $parent_variation_options = null;
        if ($this->check_variation_permission($variation_id)) {
            $option_id = $this->input->post('option_id', true);

            //check option exist
            if ($this->variation_model->is_variation_option_exist($variation_id, $option_id)) {
                $this->session->set_flashdata('error', trans("msg_option_exists"));
            } elseif ($this->variation_model->edit_variation_option($option_id)) {
                //clear default option
                $this->variation_model->clear_variation_default_option($variation_id, $option_id);
                $this->session->set_flashdata('success', trans("msg_updated"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }

            $variation = $this->variation_model->get_variation($variation_id);
            if (!empty($variation) && $variation->parent_id != 0) {
                $parent_variation_options = $this->variation_model->get_variation_options($variation->parent_id);
            }
            $vars = array(
                "variation" => $variation,
                "variation_option" => $this->variation_model->get_variation_option($option_id),
                "variation_option_images" => $this->variation_model->get_variation_option_images($option_id),
                "parent_variation_options" => $parent_variation_options
            );
            $html_content = $this->load->view('dashboard/product/variation/_edit_option', $vars, true);
            $data = array(
                'result' => 1,
                'html_content' => $html_content,
            );
            echo json_encode($data);
            reset_flash_data();
        }
    }

    //delete variation option
    public function delete_variation_option_post()
    {
        $variation_id = $this->input->post('variation_id', true);
        if ($this->check_variation_permission($variation_id)) {
            $option_id = $this->input->post('option_id', true);
            $this->variation_model->delete_variation_option($option_id);
            $this->product_variation_options_html_content($variation_id, "_options");
        }
    }

    //select variation
    public function select_variation_post()
    {
        $variation_id = $this->input->post('variation_id', true);
        if ($this->check_variation_permission($variation_id)) {
            $product_id = $this->input->post('product_id', true);
            $this->variation_model->select_variation($variation_id, $product_id);
            $this->product_variation_list_html_content($product_id, "_response_variations");
        }
    }

    public function check_variation_permission($variation_id)
    {
        if ($this->auth_check) {
            $variation = $this->variation_model->get_variation($variation_id);
            if (!empty($variation)) {
                if ($variation->user_id == $this->auth_user->id || $this->auth_user->role == "admin") {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Upload Variation Image
     */
    public function upload_variation_image()
    {
        $variation_option_id = $this->input->post('variation_option_id', true);
        $variation_option = $this->variation_model->get_variation_option($variation_option_id);
        if (!empty($variation_option)) {
            if ($this->check_variation_permission($variation_option->variation_id)) {
                $variation = $this->variation_model->get_variation($variation_option->variation_id);
                $this->variation_model->upload_variation_image($variation->product_id, $variation_option->id);
            }
        }
    }

    /**
     * Upload Variation Image Session
     */
    public function upload_variation_image_session()
    {
        $this->variation_model->upload_variation_images_session();
    }

    /**
     * Get Uploaded Variation Image Session
     */
    public function get_sess_uploaded_variation_image()
    {
        $file_id = $this->input->post('file_id', true);
        $images = $this->variation_model->get_sess_variation_images_array();
        if (!empty($images)) {
            foreach ($images as $image) {
                if ($image->file_id == $file_id) {
                    echo '<img src="' . base_url() . "uploads/temp/" . $image->img_default . '" alt="">' .
                        '<a href="javascript:void(0)" class="btn-img-delete btn-delete-variation-image-session" data-file-id="' . $image->file_id . '"><i class="icon-close"></i></a>' .
                        '<a href="javascript:void(0)" class="btn btn-xs btn-secondary btn-is-image-main btn-set-variation-image-main-session" data-file-id="' . $image->file_id . '">' . trans("main") . '</a>';
                    break;
                }
            }
        }
    }

    /**
     * Set Main Image Session
     */
    public function set_variation_image_main_session()
    {
        $file_id = $this->input->post('file_id', true);
        $this->variation_model->set_sess_variation_image_main($file_id);
    }

    /**
     * Set Main Image
     */
    public function set_variation_image_main()
    {
        $file_id = $this->input->post('file_id', true);
        $variation_option_id = $this->input->post('option_id', true);
        $this->variation_model->set_variation_image_main($file_id, $variation_option_id);
    }

    /**
     * Delete Variation Image Session
     */
    public function delete_variation_image_session_post()
    {
        $file_id = $this->input->post('file_id', true);
        $this->variation_model->delete_variation_image_session($file_id);
    }

    /**
     * Delete Variation Image
     */
    public function delete_variation_image_post()
    {
        $variation_id = $this->input->post('variation_id', true);
        if ($this->check_variation_permission($variation_id)) {
            $image_id = $this->input->post('image_id', true);
            $this->variation_model->delete_variation_image($image_id);
        }
    }

    /**
     * Get Uploaded Variation Image
     */
    public function get_uploaded_variation_image()
    {
        $image_id = $this->input->post('image_id', true);
        $image = $this->variation_model->get_variation_image($image_id);
        if (!empty($image)) {
            $option = $this->variation_model->get_variation_option($image->variation_option_id);
            if (!empty($option)) {
                echo '<div id="uploaded_vr_img_' . $image->id . '"><img src="' . get_variation_option_image_url($image) . '" alt="">' .
                    '<a href="javascript:void(0)" class="btn-img-delete btn-delete-variation-image" data-variation-id="' . $option->variation_id . '" data-file-id="' . $image->id . '"><i class="icon-close"></i></a>' .
                    '<a href="javascript:void(0)" class="btn btn-xs btn-secondary btn-is-image-main btn-set-variation-image-main" data-file-id="' . $image->id . '" data-option-id="' . $image->variation_option_id . '">' . trans("main") . '</a></div>';
            }
        }
    }


}
