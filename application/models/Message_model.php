<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_Model
{
    //add conversation
    public function add_conversation()
    {
        $data = array(
            'sender_id' => $this->auth_user->id,
            'receiver_id' => $this->input->post('receiver_id', true),
            'subject' => $this->input->post('subject', true),
            'created_at' => date("Y-m-d H:i:s")
        );

        //check conversation exists
        $this->db->where('sender_id', $data['sender_id']);
        $this->db->where('receiver_id', $data['receiver_id']);
        $this->db->where('subject', $data['subject']);
        $query = $this->db->get('conversations');
        $row = $query->row();

        if (!empty($row)) {
            return $row->id;
        } else {
            if ($this->db->insert('conversations', $data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }

    //add message
    public function add_message($conversation_id)
    {
        $conversation_id = clean_number($conversation_id);
        $data = array(
            'conversation_id' => $conversation_id,
            'sender_id' => $this->auth_user->id,
            'receiver_id' => $this->input->post('receiver_id', true),
            'message' => $this->input->post('message', true),
            'is_read' => 0,
            'deleted_user_id' => 0,
            'created_at' => date("Y-m-d H:i:s")
        );
        if (!empty($data['message'])) {
            return $this->db->insert('conversation_messages', $data);
        }
        return false;
    }

    //get unread conversations
    public function get_unread_conversations($user_id)
    {
        $user_id = clean_number($user_id);
        $query_unread_conversations = $this->get_user_unread_conversation_ids_query($user_id);
        $this->db->where("conversations.id IN ($query_unread_conversations)", NULL, FALSE);
        $this->db->order_by('conversations.created_at', 'DESC');
        $this->db->distinct();
        $query = $this->db->get('conversations');
        return $query->result();
    }

    //get read_conversations
    public function get_read_conversations($user_id)
    {
        $user_id = clean_number($user_id);
        $query_unread_conversations = $this->get_user_unread_conversation_ids_query($user_id);
        $query_conversations = $this->get_user_conversation_ids_query($user_id);
        $this->db->where("conversations.id IN ($query_conversations)", NULL, FALSE);
        $this->db->where("conversations.id NOT IN ($query_unread_conversations)", NULL, FALSE);
        $this->db->order_by('conversations.created_at', 'DESC');
        $this->db->distinct();
        $query = $this->db->get('conversations');
        return $query->result();
    }

    //get user latest conversation
    public function get_user_latest_conversation($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->join('conversation_messages', 'conversation_messages.conversation_id = conversations.id');
        $this->db->select('conversations.*, conversation_messages.is_read as is_read');
        $this->db->where('deleted_user_id != ', $this->auth_user->id);
        $this->db->group_start();
        $this->db->where('conversations.sender_id', $user_id);
        $this->db->or_where('conversations.receiver_id', $user_id);
        $this->db->group_end();
        $this->db->order_by('conversations.created_at', 'DESC');
        $query = $this->db->get('conversations');
        return $query->row();
    }

    //get user conversation
    public function get_user_conversation($id)
    {
        $this->db->where('conversation_id', clean_number($id));
        $this->db->where('deleted_user_id != ', $this->auth_user->id);
        $query = $this->db->get('conversation_messages');
        if ($query->num_rows() > 0) {
            $this->db->where('id', $id);
            $query = $this->db->get('conversations');
            return $query->row();
        }
        return false;
    }

    //get conversation
    public function get_conversation($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('conversations');
        return $query->row();
    }

    //get messages
    public function get_messages($conversation_id)
    {
        $conversation_id = clean_number($conversation_id);
        $this->db->where('conversation_id', $conversation_id);
        $query = $this->db->get('conversation_messages');
        return $query->result();
    }

    //get unread conversation count
    public function get_unread_conversations_count($receiver_id)
    {
        $this->db->join('conversation_messages', 'conversation_messages.conversation_id = conversations.id');
        $this->db->select('conversations.*, conversation_messages.is_read as is_read');
        $this->db->where('conversation_messages.receiver_id', clean_number($receiver_id));
        $this->db->where('conversation_messages.is_read', 0);
        $this->db->where('conversation_messages.deleted_user_id !=', clean_number($receiver_id));
        $this->db->distinct();
        $query = $this->db->get('conversations');
        return $query->num_rows();
    }

    //set conversation messages as read
    public function set_conversation_messages_as_read($conversation_id)
    {
        $conversation_id = clean_number($conversation_id);
        $messages = $this->get_unread_messages($conversation_id);
        if (!empty($messages)) {
            foreach ($messages as $message) {
                if ($message->receiver_id == $this->auth_user->id) {
                    $data = array(
                        'is_read' => 1
                    );
                    $this->db->where('id', $message->id);
                    $this->db->update('conversation_messages', $data);
                }
            }
        }
    }

    //get unread messages
    public function get_unread_messages($conversation_id)
    {
        $conversation_id = clean_number($conversation_id);
        $this->db->where('conversation_id', $conversation_id);
        $this->db->where('receiver_id', $this->auth_user->id);
        $this->db->where('is_read', 0);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('conversation_messages');
        return $query->result();
    }

    //get conversation unread messages count
    public function get_conversation_unread_messages_count($conversation_id)
    {
        $conversation_id = clean_number($conversation_id);
        $this->db->where('conversation_id', $conversation_id);
        $this->db->where('receiver_id', $this->auth_user->id);
        $this->db->where('is_read', 0);
        $query = $this->db->get('conversation_messages');
        return $query->num_rows();
    }

    //get user unread conversation ids
    public function get_user_unread_conversation_ids_query($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->select('conversation_id');
        $this->db->where('receiver_id', $user_id);
        $this->db->where('deleted_user_id !=', $user_id);
        $this->db->where('is_read', 0);
        $this->db->distinct();
        $this->db->from('conversation_messages');
        $query = $this->db->get_compiled_select();
        $this->db->reset_query();
        return $query;
    }

    //get user conversation ids
    public function get_user_conversation_ids_query($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->select('conversation_id');
        $this->db->group_start();
        $this->db->where('sender_id', $user_id);
        $this->db->or_where('receiver_id', $user_id);
        $this->db->group_end();
        $this->db->where('deleted_user_id !=', $user_id);
        $this->db->distinct();
        $this->db->from('conversation_messages');
        $query = $this->db->get_compiled_select();
        $this->db->reset_query();
        return $query;
    }

    //delete conversation
    public function delete_conversation($id)
    {
        $id = clean_number($id);
        $conversation = $this->get_conversation($id);
        if (!empty($conversation)) {
            $messages = $this->get_messages($conversation->id);

            if (!empty($messages)) {
                foreach ($messages as $message) {
                    if ($message->sender_id == $this->auth_user->id || $message->receiver_id == $this->auth_user->id) {
                        if ($message->deleted_user_id == 0) {
                            $data = array(
                                'deleted_user_id' => $this->auth_user->id
                            );
                            $this->db->where('id', $message->id);
                            $this->db->update('conversation_messages', $data);
                        } else {
                            $this->db->where('id', $message->id);
                            $this->db->delete('conversation_messages');
                        }
                    }
                }
            }

            //delete conversation if does not have messages
            $messages = $this->get_messages($conversation->id);
            if (empty($messages)) {
                $this->db->where('id', $conversation->id);
                $this->db->delete('conversations');
            }
        }
    }

}
