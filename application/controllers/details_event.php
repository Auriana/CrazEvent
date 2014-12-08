<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Details_Event extends CI_Controller {

    function __construct() {
         parent::__construct();
         $this->load->model('event','',TRUE);
    }

    /**
    * Access to the functionnality of viewing an event in full detail.
    * Redirect to welcome page if not logged in.
    * params :
    *    id : id of the event to display in the managing forms
    */
    function index($id) {
        if($this->session->userdata('logged_in')) {
			$data['title'] = 'Détails de l\évènement';
			

			$info_event = $this->event->get_details($id);
            $session_data = $this->session->userdata('logged_in');
            
            $info_event['id_user'] = $session_data['id'];
            $info_event['id_event'] = $id;
            $info_event['participation'] = get_participation_link($session_data['id'], $id, $info_event['event']->private);
			
            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/details_event_view', $info_event);
            $this->load->view('templates/footer');
        //if user is not logged in : redirection to welcome page
        } else {  
            redirect('welcome', 'refresh');
        }
    }
}

?>