<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends CI_Controller {

    function __construct()
    {
         parent::__construct();
         $this->load->model('user','',TRUE);
    }

    /**
    * Access to the functionnality to view the user's notifications
    * Redirect to welcome page if not logged in.
    */
    function index($offset = 0) {
        if($this->session->userdata('logged_in')) {
            $data['title'] = 'Notifications';
			$session_data = $this->session->userdata('logged_in');
            $data['notifications'] = $this->user->get_messages($session_data['id'], $offset, 5);
			$data['nb_notifications'] = $this->user->count_unread_message($session_data['id']);
            $data['nextOffset'] = $offset + 5;
            $data['previousOffset'] = $offset - 5;
            
            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/notification_view');
            $this->load->view('templates/sticky-footer');
        //if user is not logged in : redirection to welcome page
        } else {  
            redirect('welcome', 'refresh');
			
        }
    }
    
    function read_notification() {
        $notificationId = $_GET['id'];
        $result = $this->user->read_message($notificationId);
        if($this->session->userdata('logged_in')['id'] == $result->recipient) {
            //$aResult['result'] = $result;
            $aResult['result'] = "success";
        } else {
            $aResult['error'] = 'Not allowed to read the notification'.' id = '.$notificationId.'content = '.$result->content;
        }
        
        echo json_encode($aResult);
    }
}

?>