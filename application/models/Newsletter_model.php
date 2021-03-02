<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter_model extends CI_Model
{

    //add to subscribers
    public function add_to_subscribers($email)
    {
        $data = array(
            'email' => $email,
            'token' => generate_token(),
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('subscribers', $data);
    }

    //update subscriber token
    public function update_subscriber_token($email)
    {
        $subscriber = $this->get_subscriber($email);
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $data = array(
                    'token' => generate_token()
                );
                $this->db->where('email', $email);
                $this->db->update('subscribers', $data);
            }
        }
    }

    //delete from subscribers
    public function delete_from_subscribers($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        return $this->db->delete('subscribers');
    }

    //get subscribers
    public function get_subscribers()
    {
        $query = $this->db->get('subscribers');
        return $query->result();
    }

    //get subscriber
    public function get_subscriber($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('subscribers');
        return $query->row();
    }

    //get subscriber
    public function get_subscriber_by_token($token)
    {
        $token = remove_special_characters($token);
        $this->db->where('token', $token);
        $query = $this->db->get('subscribers');
        return $query->row();
    }

    //get subscriber by id
    public function get_subscriber_by_id($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('subscribers');
        return $query->row();
    }

    //unsubscribe email
    public function unsubscribe_email($email)
    {
        $this->db->where('email', $email);
        $this->db->delete('subscribers');
    }

}