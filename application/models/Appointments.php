<?php
class Appointments extends CI_Model {
    function add_appointment($buyer, $seller, $date, $time, $listing) {
        $this->db->insert('appointments', array('buyer_id' => $buyer, 'seller_id' => $seller, 'appointment_date' => $date, 'appointment_time' => $time, 'listing_id' => $listing));
    }
    function cancel_appointment($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("DELETE FROM appointments WHERE appointment_id = $id");
    }
    function adjust_appointment($id, $date, $time) {
        $data = array('appointment_date' => $date, 'appointment_time' => $time);
        $this->db->update('appointments', $data, "appointment_id=$id");
    }
    function list_myappointment($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("SELECT appointment_id, buyer_id, seller_id, appointments.listing_id, appointment_date, appointment_time, approved, listings.listing_sold AS sold, listings.listing_price AS price, listings.product_name AS product, buyer.username AS buyer, seller.username AS seller
         FROM appointments 
         INNER JOIN users AS seller ON seller.user_id = appointments.seller_id INNER JOIN users AS buyer ON buyer.user_id = appointments.buyer_id INNER JOIN listings ON listings.listing_id = appointments.listing_id 
         WHERE buyer_id = $id OR seller_id = $id AND listings.listing_sold = 0");
        return $query->result_array(); 
    }
    function approve_appointment($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("UPDATE appointments SET approved=1 WHERE appointment_id=$id");
    }
    function appointment_detail($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("SELECT * FROM appointments WHERE appointment_id = $id");
        return $query->result_array();
    }
    function purchaseApptCnt() {
        $id = $this->session->userdata('id');
        $query = $this->db->query("SELECT COUNT(*) AS cnt FROM appointments WHERE buyer_id = $id");
        return $query->result_array();
    }
    function salesApptCnt() {
        $id = $this->session->userdata('id');
        $query = $this->db->query("SELECT COUNT(*) AS cnt FROM appointments WHERE seller_id = $id");
        return $query->result_array();
    }
    function getApptCnt($id) {
        $userId = $this->session->userdata('id');
        $query = $this->db->query("SELECT COUNT(*) AS cnt FROM appointments WHERE listing_id = $id AND buyer_id = $userId");
        return $query->result_array();
    }
    function getItemAppt($id) {
        $userId = $this->session->userdata('id');
        $query = $this->db->query("SELECT * FROM appointments WHERE listing_id = $id AND buyer_id = $userId");
        return $query->result_array();
    }
    
}
?>