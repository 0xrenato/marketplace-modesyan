<?php
defined('BASEPATH') or exit('No direct script access allowed');

//include image resize library
require_once APPPATH . "third_party/intervention-image/vendor/autoload.php";

use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;

class Upload_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->quality = 85;
    }

    //upload temp image
    public function upload_temp_image($file_name)
    {
        if (isset($_FILES[$file_name])) {
            if (empty($_FILES[$file_name]['name'])) {
                return null;
            }
        }
        $config['upload_path'] = './uploads/temp/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['file_name'] = 'img_temp_' . generate_unique_id();
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return $data['upload_data']['full_path'];
            }
            return null;
        } else {
            return null;
        }
    }

    //upload temp file
    public function upload_temp_file($file_name)
    {
        if (isset($_FILES[$file_name])) {
            if (empty($_FILES[$file_name]['name'])) {
                return null;
            }
        }
        $config['upload_path'] = './uploads/temp/';
        $config['allowed_types'] = '*';
        $config['file_name'] = 'file_temp' . generate_unique_id();
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return $data['upload_data']['full_path'];
            }
            return null;
        } else {
            return null;
        }
    }

    //product default image upload
    public function product_default_image_upload($path, $folder)
    {
        $new_name = 'img_x500_' . generate_unique_id() . '.' . pathinfo($path, PATHINFO_EXTENSION);
        $new_path = 'uploads/' . $folder . '/' . $new_name;
        if ($folder == 'images') {
            $directory = $this->create_upload_directory('images');
            $new_name = $directory . $new_name;
            $new_path = 'uploads/images/' . $new_name;
        }
        $img = Image::make($path)->orientate();
        $img->resize(null, 500, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(FCPATH . $new_path, $this->quality);
        //add watermark
        if ($this->general_settings->watermark_product_images == 1) {
            $this->add_watermark(FCPATH . $new_path, 'mid');
        }
        return $new_name;
    }

    //product big image upload
    public function product_big_image_upload($path, $folder)
    {
        $new_name = 'img_1920x_' . generate_unique_id() . '.'. pathinfo($path, PATHINFO_EXTENSION);
        $new_path = 'uploads/' . $folder . '/' . $new_name;
        if ($folder == 'images') {
            $directory = $this->create_upload_directory('images');
            $new_name = $directory . $new_name;
            $new_path = 'uploads/images/' . $new_name;
        }
        $img = Image::make($path)->orientate();
        $img->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save(FCPATH . $new_path, $this->quality);
        //add watermark
        if ($this->general_settings->watermark_product_images == 1) {
            $this->add_watermark(FCPATH . $new_path, 'large');
        }
        return $new_name;
    }

    //product small image upload
    public function product_small_image_upload($path, $folder)
    {
        $new_name = 'img_x300_' . generate_unique_id() . '.'. pathinfo($path, PATHINFO_EXTENSION);
        $new_path = 'uploads/' . $folder . '/' . $new_name;
        if ($folder == 'images') {
            $directory = $this->create_upload_directory('images');
            $new_name = $directory . $new_name;
            $new_path = 'uploads/images/' . $new_name;
        }
        $img = Image::make($path)->orientate();
        $img->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(FCPATH . $new_path, $this->quality);
        //add watermark
        if ($this->general_settings->watermark_product_images == 1 && $this->general_settings->watermark_thumbnail_images == 1) {
            $this->add_watermark(FCPATH . $new_path, 'small');
        }
        return $new_name;
    }

    //product variation small image upload
    public function product_variation_small_image_upload($path, $folder)
    {
        $new_name = 'img_x200_' . generate_unique_id() . '.jpg';
        $new_path = 'uploads/' . $folder . '/' . $new_name;
        if ($folder == 'images') {
            $directory = $this->create_upload_directory('images');
            $new_name = $directory . $new_name;
            $new_path = 'uploads/images/' . $new_name;
        }
        $img = Image::make($path)->orientate();
        $img->fit(200, 200);
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_name;
    }

    //file manager image upload
    public function file_manager_image_upload($path)
    {
        $directory = $this->create_upload_directory('images-file-manager');
        $new_name = 'img_' . generate_unique_id() . '.jpg';
        $new_path = "uploads/images-file-manager/" . $directory . $new_name;
        $img = Image::make($path)->orientate();
        $img->resize(1280, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save(FCPATH . $new_path, $this->quality);
        //add watermark
        if ($this->general_settings->watermark_product_images == 1) {
            $this->add_watermark(FCPATH . $new_path, 'mid');
        }
        return $directory . $new_name;
    }

    //blog content image upload
    public function blog_content_image_upload($path)
    {
        $directory = $this->create_upload_directory('blog');
        $new_name = 'img_' . generate_unique_id() . '.jpg';
        $new_path = "uploads/blog/" . $directory . $new_name;
        $img = Image::make($path)->orientate();
        $img->resize(1280, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save(FCPATH . $new_path, $this->quality);
        //add watermark
        if ($this->general_settings->watermark_blog_images == 1) {
            $this->add_watermark(FCPATH . $new_path, 'mid');
        }
        return $new_path;
    }

    //blog image default upload
    public function blog_image_small_upload($path)
    {
        $directory = $this->create_upload_directory('blog');
        $new_name = 'img_thumb_' . generate_unique_id() . '.jpg';
        $new_path = "uploads/blog/" . $directory . $new_name;
        $img = Image::make($path)->orientate();
        $img->fit(500, 332);
        $img->save(FCPATH . $new_path, $this->quality);
        //add watermark
        if ($this->general_settings->watermark_blog_images == 1 && $this->general_settings->watermark_thumbnail_images == 1) {
            $this->add_watermark(FCPATH . $new_path, 'mid');
        }
        return $new_path;
    }

    //category image upload
    public function category_image_upload($path)
    {
        $new_path = 'uploads/category/category_' . generate_unique_id() . '.jpg';
        $img = Image::make($path)->orientate();
        $img->fit(420, 420);
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //slider image upload
    public function slider_image_upload($path)
    {
        $new_path = 'uploads/slider/slider_' . generate_unique_id() . '.jpg';
        $img = Image::make($path)->orientate();
        $img->fit(1920, 600);
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //slider image mobile upload
    public function slider_image_mobile_upload($path)
    {
        $new_path = 'uploads/slider/slider_' . generate_unique_id() . '.jpg';
        $img = Image::make($path)->orientate();
        $img->fit(768, 500);
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //avatar image upload
    public function avatar_upload($path)
    {
        $new_path = 'uploads/profile/avatar_' . generate_unique_id() . '.jpg';
        $img = Image::make($path)->orientate();
        $img->fit(240, 240);
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //cover image upload
    public function cover_image_upload($path)
    {
        $new_path = 'uploads/profile/cover_' . generate_unique_id() . '.jpg';
        $img = Image::make($path)->orientate();
        $img->fit(1920, 400);
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //logo image upload
    public function logo_upload($file_name)
    {
        $config['upload_path'] = './uploads/logo/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|svg';
        $config['file_name'] = 'logo_' . uniqid();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/logo/' . $data['upload_data']['file_name'];
            }
        }
        return null;
    }

    //favicon image upload
    public function favicon_upload($file_name)
    {
        $config['upload_path'] = './uploads/logo/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['file_name'] = 'favicon_' . uniqid();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/logo/' . $data['upload_data']['file_name'];
            }
        }
        return null;
    }

    //ad upload
    public function ad_upload($file_name)
    {
        $config['upload_path'] = './uploads/blocks/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['file_name'] = 'block_' . generate_unique_id();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/blocks/' . $data['upload_data']['file_name'];
            }
        }
        return null;
    }

    //flag upload
    public function flag_upload($path)
    {
        $new_path = 'uploads/blocks/flag_' . generate_unique_id() . '.jpg';
        $img = Image::make($path)->orientate();
        $img->resize(null, 100, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(FCPATH . $new_path);
        return $new_path;
    }

    //receipt upload
    public function receipt_upload($file_name)
    {
        $config['upload_path'] = './uploads/receipts/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['file_name'] = 'receipt_' . generate_unique_id();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/receipts/' . $data['upload_data']['file_name'];
            }
        }
        return null;
    }

    //watermark upload
    public function watermark_upload($file_name)
    {
        $config['upload_path'] = './uploads/logo/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['file_name'] = 'watermark_' . generate_unique_id();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/logo/' . $data['upload_data']['file_name'];
            }
        }
        return null;
    }

    //resize watermark
    public function resize_watermark($path, $width, $height)
    {
        $new_name = 'watermark_' . generate_unique_id() . '.png';
        $new_path = 'uploads/logo/' . $new_name;
        $img = Image::make($path)->orientate();
        $img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(FCPATH . $new_path);
        return 'uploads/logo/' . $new_name;
    }

    //digital file upload
    public function digital_file_upload($input_name, $file_name)
    {
        $config['upload_path'] = './uploads/digital-files/';
        $config['allowed_types'] = '*';
        $config['file_name'] = $file_name;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($input_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return true;
            }
            return null;
        } else {
            return null;
        }
    }

    //audio upload
    public function audio_upload($file_name)
    {
        $allowed_types = array('mp3', 'MP3', 'wav', 'WAV');
        if (!$this->check_file_mime_type($file_name, $allowed_types)) {
            return false;
        }
        $config['upload_path'] = './uploads/audios/';
        $config['allowed_types'] = '*';
        $config['file_name'] = 'audio_' . generate_unique_id();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return $data['upload_data']['file_name'];
            }
            return null;
        } else {
            return null;
        }
    }

    //video upload
    public function video_upload($file_name)
    {
        $allowed_types = array('mp4', 'MP4', 'webm', 'WEBM');
        if (!$this->check_file_mime_type($file_name, $allowed_types)) {
            return false;
        }
        $config['upload_path'] = './uploads/videos/';
        $config['allowed_types'] = '*';
        $config['file_name'] = 'video_' . generate_unique_id();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return $data['upload_data']['file_name'];
            }
            return null;
        } else {
            return null;
        }
    }

    //check file mime type
    public function check_file_mime_type($file_name, $allowed_types)
    {
        if (!isset($_FILES[$file_name])) {
            return false;
        }
        if (empty($_FILES[$file_name]['name'])) {
            return false;
        }
        $ext = pathinfo($_FILES[$file_name]['name'], PATHINFO_EXTENSION);
        if (in_array($ext, $allowed_types)) {
            return true;
        }
        return false;
    }

    //add watermark
    public function add_watermark($image_path, $watermark_size)
    {
        $watermark = $this->general_settings->watermark_image_large;
        if ($watermark_size == 'mid') {
            $watermark = $this->general_settings->watermark_image_mid;
        }
        if ($watermark_size == 'small') {
            $watermark = $this->general_settings->watermark_image_small;
        }
        if (file_exists($image_path) && file_exists($watermark)) {
            $this->load->library('image_lib');
            $config['source_image'] = $image_path;
            $config['quality'] = 100;
            $config['wm_overlay_path'] = FCPATH . $watermark;
            $config['wm_type'] = 'overlay';
            $config['wm_vrt_alignment'] = $this->general_settings->watermark_vrt_alignment;
            $config['wm_hor_alignment'] = $this->general_settings->watermark_hor_alignment;
            $this->image_lib->initialize($config);
            $this->image_lib->watermark();
        }
    }

    //delete temp image
    public function delete_temp_image($path)
    {
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    //create upload directory
    public function create_upload_directory($folder)
    {
        $directory = date("Ym");
        $directory_path = FCPATH . 'uploads/' . $folder . '/' . $directory . '/';

        //If the directory doesn't already exists.
        if (!is_dir($directory_path)) {
            //Create directory.
            @mkdir($directory_path, 0755, true);
        }
        //add index.html if does not exist
        if (!file_exists($directory_path . "index.html")) {
            copy(FCPATH . "uploads/index.html", $directory_path . "index.html");
        }

        return $directory . "/";
    }
}
