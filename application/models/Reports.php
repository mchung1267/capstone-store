<?php
class Reports extends CI_Model {
    function list_report() {
        $query = $this->db->query("SELECT report_id, reports.listing_id AS listing_id, reports.appointment_id AS appointment_id, turn_on, port_work, camera_work, battery_work, damage_free, imei, battery_capacity, report_content, seller.suspension_count AS 
        suspensions, seller.complaint_count AS complaints, buyer.username AS buyername, seller.username AS sellername, buyer.email AS buyermail, seller.email AS sellermail, resolved, dismissed FROM reports
        INNER JOIN appointments ON appointments.appointment_id = reports.appointment_id INNER JOIN users AS seller ON appointments.seller_id = seller.user_id 
        INNER JOIN users AS buyer ON appointments.buyer_id = buyer.user_id");
        return $query->result_array();
    }
    function select_report($id) {
        $query = $this->db->query("SELECT report_id, reports.listing_id AS listing_id, reports.appointment_id AS appointment_id, turn_on, port_work, camera_work, battery_work, damage_free, imei, battery_capacity, report_content, seller.suspension_count AS 
        suspensions, seller.complaint_count AS complaints, buyer.username AS buyername, seller.username AS sellername, buyer.email AS buyermail, seller.email AS sellermail, resolved, dismissed  FROM reports
        INNER JOIN appointments ON appointments.appointment_id = reports.appointment_id INNER JOIN users AS seller ON appointments.seller_id = seller.user_id 
        INNER JOIN users AS buyer ON appointments.buyer_id = buyer.user_id WHERE report_id = $id");
        return $query->result_array();
    }
    function add_report($transaction_id, $appointment_id, $listing_id, $turn_on, $port_work, $camera_work, $battery_work, $damage_free, $imei, $battery_capacity, $report_content) {
        //Escape possibel SQL commands inside input so it would prevent SQL injection
        $this->db->insert('reports', array('transaction_id' => $transaction_id, 'appointment_id' => $appointment_id, 'listing_id' => $listing_id, 'turn_on' => $turn_on, 'port_work' => $port_work, 'camera_work' => $camera_work, 'battery_work' => $battery_work, 'damage_free' => $damage_free,'imei' => $imei, 'battery_capacity' => $battery_capacity, 'report_content' => $report_content));
    }
    function getReportCnt($id) {
        $query = $this->db->query("SELECT COUNT(*) AS cnt FROM reports INNER JOIN appointments ON appointments.appointment_id = reports.appointment_id INNER JOIN users ON users.user_id = appointments.seller_id WHERE users.user_id = $id");
        return $query->result_array();
    }
    function getReportCntForTransaction($id) {
        $query = $this->db->query("SELECT COUNT(*) AS cnt FROM reports WHERE transaction_id = $id");
        return $query->result_array();
    }
    function listMyReportsReceived($id) {
        $query = $this->db->query("SELECT report_id, reports.listing_id AS listing_id, reports.appointment_id AS appointment_id, turn_on, port_work, camera_work, battery_work, damage_free, imei, battery_capacity, report_content, seller.suspension_count AS 
        suspensions, seller.complaint_count AS complaints, buyer.username AS buyername, seller.username AS sellername, buyer.email AS buyermail, seller.email AS sellermail, resolved, dismissed  FROM reports
        INNER JOIN appointments ON appointments.appointment_id = reports.appointment_id INNER JOIN users AS seller ON appointments.seller_id = seller.user_id 
        INNER JOIN users AS buyer ON appointments.buyer_id = buyer.user_id WHERE seller.user_id = $id");   
        return $query->result_array(); }
    function listMyReportsSent($id) {
        $query = $this->db->query("SELECT report_id, reports.listing_id AS listing_id, reports.appointment_id AS appointment_id, turn_on, port_work, camera_work, battery_work, damage_free, imei, battery_capacity, report_content, seller.suspension_count AS 
        suspensions, seller.complaint_count AS complaints, buyer.username AS buyername, seller.username AS sellername, buyer.email AS buyermail, seller.email AS sellermail, resolved, dismissed  FROM reports
        INNER JOIN appointments ON appointments.appointment_id = reports.appointment_id INNER JOIN users AS seller ON appointments.seller_id = seller.user_id 
        INNER JOIN users AS buyer ON appointments.buyer_id = buyer.user_id WHERE buyer.user_id = $id"); 
         return $query->result_array();    }
    function resolve($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("UPDATE reports SET resolved = 1 WHERE report_id = $id");
    }
    function dismiss($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("UPDATE reports SET dismissed = 1 WHERE report_id = $id");
    }
}
?>