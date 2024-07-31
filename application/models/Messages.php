<?php
class Messages extends CI_Model {
    function add_message($sender_id, $receiver_id, $send_date, $sent_time, $message_title, $message_content) {
        $this->db->insert('messages', array('sender_id' => $sender_id, 'receiver_id' => $receiver_id, 'send_date' => $send_date, 'sent_time' => $sent_time, 'message_title' => $message_title, 'message_content' => $message_content));
    }
    function delete_message($message_id) {
        $query = $this->db->query("DELETE FROM messages WHERE message_id = $message_id");
    }
    function show_my_messages($id) {
        $query = $this->db->query("SELECT message_id, sender_id, receiver_id, sentby.username AS sender, received.username AS receiver, send_date, sent_time, message_title, message_content, message_read FROM messages INNER JOIN users AS sentby ON messages.sender_id = sentby.user_id INNER JOIN users AS received ON messages.receiver_id = received.user_id WHERE sender_id = $id OR receiver_id = $id");
        return $query->result_array();
    }
    function show_received_messages($receiver) {
        $query = $this->db->query("SELECT * FROM messages WHERE receiver_id = $receiver");
        return $query->result_array();
    }
    function show_sent_messages($sender) {
        $query = $this->db->query("SELECT * FROM messages WHERE sender_id = $sender");
        return $query->result_array();
    }
    function unread_message_count($id) {
        $query = $this->db->query("SELECT COUNT(*) AS cnt FROM messages WHERE message_read = 0 AND receiver_id = $id");
        return $query->result_array();
    }
    function message_detail($id) {
        $query = $this->db->query("SELECT message_id, sender_id, sentby.username AS sender, received.username AS receiver, send_date, sent_time, message_title, message_content, message_read FROM messages INNER JOIN users AS sentby ON messages.sender_id = sentby.user_id INNER JOIN users AS received ON messages.receiver_id = received.user_id WHERE message_id = $id");
        return $query->result_array();
    }
    function read($id) {
        $query = $this->db->query("UPDATE messages SET message_read = 1 WHERE message_id = $id");
    }
}
?>