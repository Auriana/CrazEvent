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
			
			$info_event = $this -> details($id);
			
            $this->load->helper(array('form'));
            $this->load->view('templates/header', $data);
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
		
		$info_event = array();

        $result = $this->event->get_event($id);
		foreach($result as $row) {
			$info_event['name'] = $row -> name;
			$info_event['private'] = $row -> private;
			$info_event['invitation_suggestion_allowed'] = $row -> invitation_suggestion_allowed;
			$info_event['description'] = $row -> description;
			$info_event['start_date'] = $row -> start_date;
			$info_event['inscription_deadline'] = $row -> inscription_deadline;
			$info_event['duration'] = $row -> duration;
			$info_event['start_place'] = $row -> start_place;
			$info_event['participant_max_nbr'] = $row -> participant_max_nbr;
			$info_event['participant_minimum_age'] = $row -> participant_minimum_age;
			$info_event['organizer'] = $row -> organizer;
			$info_event['individual_proposition_suggestion_allowed'] = $row -> individual_proposition_suggestion_allowed;
			$info_event['region'] = $row -> region;
		}
		
		return $info_event;
		
    }

}

?>