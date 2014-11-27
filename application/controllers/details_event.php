<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Details_Event extends CI_Controller {

    function __construct()
    {
         parent::__construct();
         $this->load->model('event','',TRUE);
    }

    function index($id)
    {
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
			$data['title'] = 'Détails de l\évènement';
			

			$info_event = $this -> details($id);
            $session_data = $this->session->userdata('logged_in');
            
            $info_event['id_user'] = $session_data['id'];
            $info_event['id_event'] = $id;
            if ($this -> event -> is_participation($session_data['id'], $id) == 0) {
                if ($info_event['event']->private == 1) {
                    $info_event['participation'] = '<a id="joinEvent" href="#" onClick="joinEvent(' . $info_event['id_user'] . ', ' . $info_event['id_event'] . '1)" alt="">Répondre à l\'invitation</a>';
                } else {
                    $info_event['participation'] = '<a id="joinEvent" href="#" onClick="joinEvent(' . $info_event['id_user'] . ', ' . $info_event['id_event'] . '0)" alt="">S\'inscrire</a>';
                }
            } else {
                $info_event['participation'] = "<p>Vous êtes inscrits</p>";
            }
			
            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/details_event_view', $info_event);
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
        
        $infoEvent['eventParticipants'] = $this->event->get_event_participants($id);

        return $infoEvent;
		
    }

}

?>