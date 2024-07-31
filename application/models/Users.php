<?php
class Users extends CI_Model {
    
    function list_user() {
        $query = $this->db->query("SELECT * FROM users");
        return $query->result_array();
    }
    function find_user($id) {
        $query = $this->db->query("SELECT * FROM users WHERE user_id=$id");
        return $query->result_array();
    }
    function add_user($username, $first_name, $last_name, $email, $password, $address_line_one, $address_line_two, $city, $province) {
        $this->db->insert('users', array('username' => $username, 'email' => $email, 'password' => $password, 'first_name' => $first_name, 'last_name' => $last_name, 'address_line_1' => $address_line_one, 'address_line_2' => $address_line_two, 'city' => $city, 'province' => $province));
    }
    function findUserByEmail($email) {
        $query = $this->db->query("SELECT * FROM users WHERE email = ". $this->db->escape($email) );
        return $query->result_array();
    }
    function update_profile($id, $first_name, $last_name, $password, $address_line_one, $address_line_two, $city, $province) {
        $data = array('password' => $password, 'first_name' => $first_name, 'last_name' => $last_name, 'address_line_1' => $address_line_one, 'address_line_2' => $address_line_two, 'city' => $city, 'province' => $province);
        $this->db->update('users', $data, "user_id=$id");
    } 
    //Change its banned status
    function ban_switch($id) {
        $getState = $this->db->query("SELECT banned FROM users WHERE user_id=$id");
        $status = $getState->result_array()[0]['banned'];
        //If account is banned unban the account
        if($status == 1) {
            $query = $this->db->query("UPDATE users SET banned=0 WHERE user_id=$id");
        } 
        //If account is not banned ban the account
        else {
            $query = $this->db->query("UPDATE users SET banned=1 WHERE user_id=$id");
        }
    }
    function checkUserName($name) {
        $getState = $this->db->query("SELECT COUNT(*) AS stat FROM users WHERE username='$name'");
        $state = $getState->result_array()[0]['stat'];
        if($state == 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function checkEmail($email) {
        $getState = $this->db->query("SELECT COUNT(*) AS stat FROM users WHERE email='$email'");
        $state = $getState->result_array()[0]['stat'];
        if($state == 0) {
            return 1;
        } else {
            return 0;
        }
    }
    function updatePrivilege($id, $new) {
        $query = $this->db->query("UPDATE users SET privilege_id=$new WHERE user_id=$id");
    }
    function suspend_switch($id) {
        $getState = $this->db->query("SELECT COUNT(*) AS stat FROM users WHERE user_id=$id AND suspension_expire >= CURDATE()");
        $getSuspCnt = $this->db->query("SELECT suspension_count FROM users WHERE user_id=$id");
        $state = $getState->result_array()[0]['stat'];
        $suspCnt = $getSuspCnt->result_array()[0]['suspension_count'];
        $today = strtotime("Today");
        
        if($state == 0) {
            switch($suspCnt) {
                case 0:
                    $endDate = strtotime("+1 week", $today);
                    break;
                case 1:
                    $endDate = strtotime("+1 month", $today);
                    break;
                case 2:
                    $endDate = strtotime("+3 months", $today);
                    break;
                default:
                    $endDate = strtotime("+3 months", $today);
                    break;
            }
            $suspCnt = $suspCnt + 1;
            $finalDate = date("Y-m-d", $endDate);
            $suspend = $this->db->query("UPDATE users SET suspension_expire='$finalDate',  suspension_count=$suspCnt WHERE user_id=$id");
            
        }

        

    }
}
?>