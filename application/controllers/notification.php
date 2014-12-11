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
    function index() {
        if($this->session->userdata('logged_in')) {
            $data['title'] = 'Notifications';
            $data['notifications'] = $this->user->get_messages($this->session->userdata('logged_in')['id']);
            
            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/notification_view');
            $this->load->view('templates/footer');
        //if user is not logged in : redirection to welcome page
        } else {  
            redirect('welcome', 'refresh');
        }
    }
    
    function read_notification() {
        $notificationId = $_GET['id'];
        $result = $this->user->read_message($notificationId);
        if($this->session->userdata('logged_in')['id'] == $result->recipient) {
            $aResult['result'] = $result;
        } else {
            $aResult['error'] = 'Not allowed to read the notification'.' id = '.$notificationId.'content = '.$result->content;
        }
        
        echo json_encode($aResult);
    }
}

?>