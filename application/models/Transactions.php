<?php
class Transactions extends CI_Model {
    function list_transactions() {
        $query = $this->db->query("SELECT * FROM transactions");
        return $query->result_array();
    }
    function list_administrative() {
        $query = $this->db->query("SELECT transaction_id, transactions.appointment_id AS appointment_id, transactions.listing_id AS listing_id, seller.user_id AS seller_id, buyer.user_id AS buyer_id, seller.username AS seller, buyer.username AS buyer, listings.product_name AS product, listings.category AS category, listings.listing_price AS price, seller.address_line_1 AS line1, seller.address_line_2 AS line2, seller.city AS city, seller.province AS province FROM transactions INNER JOIN appointments ON appointments.appointment_id = transactions.appointment_id INNER JOIN listings ON listings.listing_id = transactions.listing_id INNER JOIN users AS buyer ON appointments.buyer_id = buyer.user_id INNER JOIN users AS seller ON appointments.seller_id = seller.user_id");
        return $query->result_array();
    }
    function myTransactions($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("SELECT transaction_id, transactions.appointment_id AS appointment_id, transactions.listing_id AS listing_id, seller.user_id AS seller_id, buyer.user_id AS buyer_id, seller.username AS seller, buyer.username AS buyer, listings.product_name AS product, listings.category AS category, listings.listing_price AS price, seller.address_line_1 AS line1, seller.address_line_2 AS line2, seller.city AS city, seller.province AS province FROM transactions INNER JOIN appointments ON appointments.appointment_id = transactions.appointment_id INNER JOIN listings ON listings.listing_id = transactions.listing_id INNER JOIN users AS buyer ON appointments.buyer_id = buyer.user_id INNER JOIN users AS seller ON appointments.seller_id = seller.user_id WHERE buyer.user_id = $id OR seller.user_id = $id");
        return $query->result_array();
    }
    function transaction_detail($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("SELECT transaction_id, transactions.appointment_id AS appointment_id, transactions.listing_id AS listing_id, seller.user_id AS seller_id, buyer.user_id AS buyer_id, seller.username AS seller, buyer.username AS buyer, listings.product_name AS product, listings.category AS category, listings.listing_price AS price, seller.address_line_1 AS line1, seller.address_line_2 AS line2, seller.city AS city, seller.province AS province FROM transactions INNER JOIN appointments ON appointments.appointment_id = transactions.appointment_id INNER JOIN listings ON listings.listing_id = transactions.listing_id INNER JOIN users AS buyer ON appointments.buyer_id = buyer.user_id INNER JOIN users AS seller ON appointments.seller_id = seller.user_id WHERE transaction_id = $id");
        return $query->result_array();
    }
    function add_transaction($listing, $appointment) {
        $this->db->insert('transactions', array('listing_id' => $listing, 'appointment_id' => $appointment));
    }
    function myTransactionCnt($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("SELECT COUNT(*) AS cnt FROM transactions INNER JOIN appointments ON appointments.appointment_id = transactions.appointment_id INNER JOIN listings ON listings.listing_id = transactions.listing_id INNER JOIN users AS buyer ON appointments.buyer_id = buyer.user_id INNER JOIN users AS seller ON appointments.seller_id = seller.user_id WHERE buyer.user_id = $id OR seller.user_id = $id");
        return $query->result_array();
    }
    function deleteTransaction($id) {
        $id = $this->db->escape($id);
        $query = $this->db->query("DELETE FROM transactions WHERE transaction_id=$id");
    }

}
?>