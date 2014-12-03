<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manage_Event extends CI_Controller {

    function __construct()
    {
         parent::__construct();
         $this->load->model('event','',TRUE);
    }

    function index($id)
    {
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
			$data['title'] = 'Modifier l\évènement';
			
			$info_event = $this->event->get_details($id);
            
            $info_event['regions'] = get_region_scrollbox_with_selected($info_event['event']->region);
			
            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/manage_event_view', $info_event);
            $this->load->view('templates/footer');
        }
        //if user is not logged in : redirection to login
        else
        {  
            redirect('home', 'refresh');
        }
    }
}

?>