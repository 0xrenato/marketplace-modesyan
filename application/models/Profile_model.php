<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_model extends CI_Model
{
    //update profile
    public function update_profile($data, $user_id)
    {
        $user_id = clean_number($user_id);
        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file');
        if (!empty($temp_path)) {
            //delete old avatar
            delete_file_from_server($this->auth_user->avatar);
            $data["avatar"] = $this->upload_model->avatar_upload($temp_path);
            $this->upload_model->delete_temp_image($temp_path);
        }
        $temp_path_cover = $this->upload_model->upload_temp_image('file_cover');
        if (!empty($temp_path_cover)) {
            //delete old cover
            delete_file_from_server($this->auth_user->cover_image);
            $data["cover_image"] = $this->upload_model->cover_image_upload($temp_path_cover);
            $this->upload_model->delete_temp_image($temp_path_cover);
        }
        $this->session->set_userdata('modesy_user_old_email', $this->auth_user->email);

        if (empty($data['show_email'])) {
            $data['show_email'] = 0;
        }
        if (empty($data['show_phone'])) {
            $data['show_phone'] = 0;
        }
        if (empty($data['show_location'])) {
            $data['show_location'] = 0;
        }

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //update cover image
    public function update_cover_image()
    {
        $submit = $this->input->post("submit", true);
        if ($submit == "delete_cover") {
            $data["cover_image"] = "";
            @delete_file_from_server($this->auth_user->cover_image);
            return $this->db->where('id', $this->auth_user->id)->update('users', $data);
        } else {
            $data = array(
                'cover_image_type' => $this->input->post("cover_image_type", true)
            );
            $this->load->model('upload_model');
            $temp_path = $this->upload_model->upload_temp_image('file');
            if (!empty($temp_path)) {
                //delete old cover
                delete_file_from_server($this->auth_user->cover_image);
                $data["cover_image"] = $this->upload_model->cover_image_upload($temp_path);
                $this->upload_model->delete_temp_image($temp_path);
            }
            return $this->db->where('id', $this->auth_user->id)->update('users', $data);
        }
    }

    //edit user
    public function edit_user($id)
    {
        $user = $this->auth_model->get_user($id);
        if (!empty($user)) {
            $data = array(
                'username' => $this->input->post('username', true),
                'email' => $this->input->post('email', true),
                'slug' => $this->input->post('slug', true),
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                'phone_number' => $this->input->post('phone_number', true),
                'shop_name' => $this->input->post('shop_name', true),
                'about_me' => $this->input->post('about_me', true),
                'country_id' => $this->input->post('country_id', true),
                'state_id' => $this->input->post('state_id', true),
                'city_id' => $this->input->post('city_id', true),
                'address' => $this->input->post('address', true),
                'zip_code' => $this->input->post('zip_code', true),
                'personal_website_url' => $this->input->post('personal_website_url', true),
                'facebook_url' => $this->input->post('facebook_url', true),
                'twitter_url' => $this->input->post('twitter_url', true),
                'instagram_url' => $this->input->post('instagram_url', true),
                'pinterest_url' => $this->input->post('pinterest_url', true),
                'linkedin_url' => $this->input->post('linkedin_url', true),
                'vk_url' => $this->input->post('vk_url', true),
                'whatsapp_url' => $this->input->post('whatsapp_url', true),
                'telegram_url' => $this->input->post('telegram_url', true),
                'youtube_url' => $this->input->post('youtube_url', true)
            );

            $this->load->model('upload_model');
            $temp_path = $this->upload_model->upload_temp_image('file');
            if (!empty($temp_path)) {
                $data["avatar"] = $this->upload_model->avatar_upload($temp_path);
                $this->upload_model->delete_temp_image($temp_path);
                //delete old
                delete_file_from_server($user->avatar);
            }

            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        }
    }

    //update shop settings
    public function update_shop_settings($shop_name)
    {
        $user_id = $this->auth_user->id;
        $data = array(
            'shop_name' => $shop_name,
            'about_me' => $this->input->post('about_me', true),
            'show_rss_feeds' => $this->input->post('show_rss_feeds', true),
            'country_id' => $this->input->post('country_id', true),
            'state_id' => $this->input->post('state_id', true),
            'city_id' => $this->input->post('city_id', true),
            'address' => $this->input->post('address', true),
            'zip_code' => $this->input->post('zip_code', true)
        );

        $data["country_id"] = !empty($data["country_id"]) ? $data["country_id"] : 0;
        $data["state_id"] = !empty($data["state_id"]) ? $data["state_id"] : 0;
        $data["city_id"] = !empty($data["city_id"]) ? $data["city_id"] : 0;
        $data["address"] = !empty($data["address"]) ? $data["address"] : "";
        $data["zip_code"] = !empty($data["zip_code"]) ? $data["zip_code"] : "";

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //check email updated
    public function check_email_updated($user_id)
    {
        $user_id = clean_number($user_id);
        if ($this->general_settings->email_verification == 1) {
            $user = $this->auth_model->get_user($user_id);
            if (!empty($user)) {
                if (!empty($this->session->userdata('modesy_user_old_email')) && $this->session->userdata('modesy_user_old_email') != $user->email) {
                    //send confirm email
                    $this->load->model("email_model");
                    $this->email_model->send_email_activation($user->id);
                    $data = array(
                        'email_status' => 0
                    );

                    $this->db->where('id', $user->id);
                    return $this->db->update('users', $data);
                }
            }
            if (!empty($this->session->userdata('modesy_user_old_email'))) {
                $this->session->unset_userdata('modesy_user_old_email');
            }
        }

        return false;
    }

    //shipping address input values
    public function shipping_address_input_values()
    {
        return array(
            'title' => $this->input->post('title', true),
            'first_name' => $this->input->post('first_name', true),
            'last_name' => $this->input->post('last_name', true),
            'email' => $this->input->post('email', true),
            'phone_number' => $this->input->post('phone_number', true),
            'address' => $this->input->post('address', true),
            'country_id' => $this->input->post('country_id', true),
            'state_id' => $this->input->post('state_id', true),
            'city' => $this->input->post('city', true),
            'zip_code' => $this->input->post('zip_code', true)
        );
    }

    //add shipping address
    public function add_shipping_address()
    {
        $data = $this->shipping_address_input_values();
        $data['user_id'] = $this->auth_user->id;
        return $this->db->insert('shipping_addresses', $data);
    }

    //edit shipping address
    public function edit_shipping_address()
    {
        $id = $this->input->post('id', true);
        $row = $this->get_shipping_address_by_id($id);
        if (!empty($row) && $this->auth_user->id == $row->user_id) {
            $data = $this->shipping_address_input_values();
            return $this->db->where('id', $row->id)->update('shipping_addresses', $data);
        }
        return false;
    }

    //get shipping address
    public function get_shipping_address_by_id($id)
    {
        if (!empty($id)) {
            return $this->db->where('id', clean_number($id))->get('shipping_addresses')->row();
        }
        return false;
    }

    //delete shipping address
    public function delete_shipping_address()
    {
        $id = $this->input->post('id', true);
        $row = $this->get_shipping_address_by_id($id);
        if (!empty($row) && $this->auth_user->id == $row->user_id) {
            return $this->db->where('id', $row->id)->delete('shipping_addresses');
        }
        return false;
    }


    //update update social media
    public function update_social_media()
    {
        $user_id = $this->auth_user->id;
        $data = array(
            'personal_website_url' => $this->input->post('personal_website_url', true),
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'whatsapp_url' => $this->input->post('whatsapp_url', true),
            'telegram_url' => $this->input->post('telegram_url', true),
            'youtube_url' => $this->input->post('youtube_url', true)
        );

        foreach ($data as $key => $value) {
            if (!empty(trim($value))) {
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    return false;
                }
            }
        }

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //change password input values
    public function change_password_input_values()
    {
        $data = array(
            'old_password' => $this->input->post('old_password', true),
            'password' => $this->input->post('password', true),
            'password_confirm' => $this->input->post('password_confirm', true)
        );
        return $data;
    }

    //change password
    public function change_password($old_password_exists)
    {
        $this->load->library('bcrypt');
        $user = $this->auth_user;
        if (!empty($user)) {
            $data = $this->change_password_input_values();
            if ($old_password_exists == 1) {
                //password does not match stored password.
                if (!$this->bcrypt->check_password($data['old_password'], $user->password)) {
                    $this->session->set_flashdata('error', trans("msg_wrong_old_password"));
                    $this->session->set_flashdata('form_data', $this->change_password_input_values());
                    redirect($this->agent->referrer());
                }
            }

            $data = array(
                'password' => $this->bcrypt->hash_password($data['password'])
            );

            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //follow user
    public function follow_unfollow_user()
    {
        $data = array(
            'following_id' => $this->input->post('following_id', true),
            'follower_id' => $this->input->post('follower_id', true)
        );

        $follow = $this->get_follow($data["following_id"], $data["follower_id"]);
        if (empty($follow)) {
            //add follower
            $this->db->insert('followers', $data);
        } else {
            $this->db->where('id', $follow->id);
            $this->db->delete('followers');
        }
    }

    //get shipping addresses
    public function get_shipping_addresses($user_id)
    {
        return $this->db->where('user_id', clean_number($user_id))->get('shipping_addresses')->result();
    }

    //follow
    public function get_follow($following_id, $follower_id)
    {
        $following_id = clean_number($following_id);
        $follower_id = clean_number($follower_id);
        $this->db->where('following_id', $following_id);
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->row();
    }

    //is user follows
    public function is_user_follows($following_id, $follower_id)
    {
        $following_id = clean_number($following_id);
        $follower_id = clean_number($follower_id);
        $follow = $this->get_follow($following_id, $follower_id);
        if (empty($follow)) {
            return false;
        } else {
            return true;
        }
    }

    //get followers
    public function get_followers($following_id)
    {
        $following_id = clean_number($following_id);
        $this->db->join('users', 'followers.follower_id = users.id');
        $this->db->select('users.*');
        $this->db->where('following_id', $following_id);
        $query = $this->db->get('followers');
        return $query->result();
    }

    //get followers count
    public function get_followers_count($following_id)
    {
        $following_id = clean_number($following_id);
        $this->db->join('users', 'followers.follower_id = users.id');
        $this->db->select('users.*');
        $this->db->where('following_id', $following_id);
        $query = $this->db->get('followers');
        return $query->num_rows();
    }

    //get following users
    public function get_following_users($follower_id)
    {
        $follower_id = clean_number($follower_id);
        $this->db->join('users', 'followers.following_id = users.id');
        $this->db->select('users.*');
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->result();
    }

    //get following users
    public function get_following_users_count($follower_id)
    {
        $follower_id = clean_number($follower_id);
        $this->db->join('users', 'followers.following_id = users.id');
        $this->db->select('users.*');
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->num_rows();
    }

    //search members
    public function search_members($search)
    {
        $search = remove_special_characters($search);
        $this->db->like('users.username', $search);
        $this->db->or_like('users.shop_name', $search);
        $query = $this->db->get('users');
        return $query->result();
    }

    //search members limited
    public function search_members_limited($search)
    {
        $search = remove_special_characters($search);
        $this->db->like('users.username', $search);
        $this->db->limit(8);
        $query = $this->db->get('users');
        return $query->result();
    }
}
