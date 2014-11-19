<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Details_Event extends CI_Controller {

    function __construct()
    {
         parent::__construct();
    }

    function index($id)
    {
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
			$data['title'] = 'Détails de l\évènement';
			
			$infoEvent = $this -> details($id);
			
            $this->load->helper(array('form'));
            $this->load->view('templates/header', $data);
            $this->load->view('pages/details_event_view', $infoEvent);
            $this->load->view('templates/footer');
        }
        //if user is not logged in : redirection to login
        else
        {  
            redirect('home', 'refresh');
        }
    }
	
	function details($id) {
      	$this->load->model('event','',TRUE);
		
        $infoEvent['event'] = $this->event->get_event($id)[0];
        
        $activities = $this->event->get_event_activities($id);
        foreach($activities as $activity) {
            $infoEvent['eventActivities'][] = $activity->content;
        }
        
        $checklist = $this->event->get_event_checklist($id);
        foreach($checklist as $checklistItem) {
            $infoEvent['eventChecklist'][] = $checklistItem->content;
        }
        
        $keywords = $this->event->get_event_keywords($id);
        foreach($keywords as $keyword) {
            $infoEvent['eventKeywords'][] = $keyword->content;
        }

        return $infoEvent;
		
    }

}

?>