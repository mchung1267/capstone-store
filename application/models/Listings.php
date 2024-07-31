<?php

class Listings extends CI_Model {
    function add_listing($product_name, $type, $userid, $price, $details, $imei, $brand, $storage, $processor, $ramsize, $enddate) {
        $this->db->insert('listings', array('user_id' => $userid, 'listing_price' => $price, 'category' => $type, 'product_name' => $product_name, 'listing_brand' => $brand, 'listing_imei' => $imei, 'listing_details' => $details, 'listing_processor' => $processor, 'listing_storage' => $storage, 'listing_ramsize' => $ramsize, 'listing_enddate' => $enddate));
    }
    function revise_listing($id, $product_name, $type, $price, $details, $imei, $brand, $storage, $processor, $ramsize) {
        $data = array('listing_price' => $price, 'category' => $type, 'product_name' => $product_name, 'listing_details' => $details, 'listing_imei' => $imei, 'listing_brand' => $brand, 'listing_storage'=> $storage, 'listing_processor'=> $processor, 'listing_ramsize'=> $ramsize);
        $this->db->update('listings', $data, "listing_id=$id");
    }
    function mylisting($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("SELECT * FROM listings WHERE user_id = $id AND listing_sold=0");
        return $query->result_array();
    }
    function show_listing() {
        $query = $this->db->query("SELECT * FROM listings");
        return $query->result_array();
    }
    function show_approved_listing($id) {
        if($id == NULL) {
            $query = $this->db->query("SELECT * FROM listings WHERE listing_approved=1 AND listing_sold=0 AND listing_enddate >= CURDATE()");
        } else {
            $id = $this->db->escape($id);
            $query = $this->db->query("SELECT * FROM listings WHERE listing_approved=1 AND listing_sold=0 AND listing_enddate >= CURDATE() AND user_id !=$id");
        }
        return $query->result_array();
    }
    function sold($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("UPDATE listings SET listing_sold = 1 WHERE listing_id=$id");
    }
    function show_pending_listing() {
        $query = $this->db->query("SELECT * FROM listings WHERE listing_approved=0 AND listing_rejected=0");
        return $query->result_array();
    }
    function show_listing_detail($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("SELECT * FROM listings WHERE listing_id=$id");
        return $query->result_array();
    }
    function delete($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("DELETE FROM listings WHERE listing_id=$id");
    }
    function approve_listing($id) {
        $id = $this->db->escape($id);
        $getState = $this->db->query("SELECT listing_approved FROM listings WHERE listing_id=$id");
        $status = $getState->result_array()[0]['listing_approved'];

        if($status == 0) {
            $query = $this->db->query("UPDATE listings SET listing_approved=1 WHERE listing_id=$id");
        }
    }
    function reject_listing($id) {
        $id = $this->db->escape($id);
        $getState = $this->db->query("SELECT listing_approved FROM listings WHERE listing_id=$id");
        $status = $getState->result_array()[0]['listing_rejected'];

        if($status == 0) {
            $query = $this->db->query("UPDATE listings SET listing_rejected=1 WHERE listing_id=$id");
        }
    }
    function get_latest() {
        $query = $this->db->query("SELECT MAX(listing_id) AS maximum FROM listings");
        return $query->result_array();
    }
}
?>