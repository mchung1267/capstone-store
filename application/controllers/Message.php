<?php
class Message extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->TPL['active'] = array('main' => false,
                                        'items' => false,
                                        'myaccount' => false,
                                        'about' => false,
                                        'register' => false,
                                        'login' => false);
        if($this->session->userdata('id') == NULL) {
            redirect(base_url() . "index.php/Login");
        } else if($this->session->userdata('access_level') == 3) {
            redirect(base_url() . "index.php/Admin");
        } 
    }
    public function index() {
        $this->load->model('Messages','',TRUE);
        $messages = $this->Messages->show_my_messages($this->session->userdata('id'));
        $unread = $this->Messages->unread_message_count($this->session->userdata('id'));
        $this->TPL['messages'] = $messages;
        $this->TPL['unreadCnt'] = $unread[0]['cnt'];
        $this->template->show('Messages',$this->TPL);
    }
    public function detail($id) {
        $this->load->model('Messages','',TRUE);
        $message = $this->Messages->message_detail($id);
        $this->Messages->read($id);
        $this->TPL['message'] = $message[0];
        $this->template->show('MessageDetails',$this->TPL);
    }
    public function delete($id) {
        $this->load->model('Messages','',TRUE);
        $this->Messages->delete_message($id);
        redirect(base_url() . "index.php/Message");
    }
    public function compose($id) {
        $this->load->model('Users','',TRUE);
        $user = $this->Users->find_user($id);
        $receiver = $user[0]['username'];
        $this->TPL['sendto'] = $id;
        $this->TPL['receiver'] = $receiver;
        $this->template->show('NewMessage',$this->TPL);
    }
    public function send($id) {
        $this->load->model('Messages','',TRUE);
        $this->load->model('Users','',TRUE);
        $title = $this->input->post('title');
        $content = $this->input->post('content');
        $sender = $this->session->userdata('id');
        $today = date("Y-m-d", strtotime("Today"));
        $received = $this->Users->find_user($id);
        $sentby = $this->Users->find_user($sender);
		$userMail = $received[0]['email'];
		$username = $received[0]['username'];
        $senderName = $sentby[0]['username'];
        $currTime = date("H:i:s");
        $this->Messages->add_message($sender, $id, $today, $currTime, $title, $content);


        $this->load->config('email');
		$this->load->library('email');
		
		$from = $this->config->item('smtp_user');
		$to = $userMail;
		$subject = "A message from $senderName";
        $message = "<h3>Hello, $username,</h3><p>$senderName has sent a message to you. The message is here: </p><p>$content</p>";
        if($this->session->userdata('access_level') == 2) {
            $subject = "A message from ElectroTown Moderator";
            $message = "<h3>Hello, $username,</h3><p>A moderator $senderName has sent a message to you regarding recent complaint filed against you. The message is here: </p><p>$content</p>";
        }
		

		$this->email->set_newline("\r\n");
		$this->email->from($from, "ElectroTown Support");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		if ($this->email->send()) {
			redirect(site_url("Message"));
		} else {
			show_error($this->email->print_debugger());
		}
        redirect(base_url() . "index.php/Message");
    }

}
?>