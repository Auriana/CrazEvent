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
    
    function invite($idEvent, $idGuest) {
        if($this->session->userdata('logged_in')) {
            $event = $this->event->get_event($idEvent);
            
            if($this->event->is_participation($idGuest, $idEvent) == 0) {
                //inviting the user
                if($event->organizer == $this->session->userdata('logged_in')['id']) {
                    $this->event->send_invitation($idGuest, $idEvent);
                    
                   send_notification("Invitation : " . $event->name, '<p>Tu as reçu une invitation à '.$event->name.'.</p><p><a href="'. base_url('details_event/index/' . $idEvent).'">Voir l\'évènement</a></p>', $this->session->userdata('logged_in')['id'], $idGuest, true);
                //sending a proposition of invitation to the organizer
                } else if($event->invitation_suggestion_allowed == 1 &&  $this->event->is_participation($this->session->userdata('logged_in')['id'], $idEvent) == 1) {
                    $this->load->model('user','',TRUE);
                    $guest = $this->user->get_user($idGuest);
                    
                   send_notification("Suggestion d'invitation : ".$guest->firstname.' '.$guest->surname, '<p>'.$this->session->userdata('logged_in')['firstname'].' '.$this->session->userdata('logged_in')['surname'].' te propose d\'inviter '.$guest->firstname.' '.$guest->surname.' à ton évènement.</p><p><a href="'.base_url('details_event/invite/' . $idEvent . '/' . $idGuest).'">Inviter '.$guest->firstname.' '.$guest->surname.'</a></p><p><a href="'. base_url('details_event/index/' . $idEvent) . '">Voir l\'évènement</a></p>', $this->session->userdata('logged_in')['id'], $event->organizer, true);
                }
           }
        }
        redirect('home', 'refresh');
    }
}

?>