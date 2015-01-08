<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Details_Event extends CI_Controller {

    function __construct() {
         parent::__construct();
         $this->load->model('event','',TRUE);
		$this->load->model('user','',TRUE);
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
            $idUser = $this->session->userdata('logged_in')['id'];
			$data['nb_notifications'] = $this->user->count_unread_message($idUser);

			$info_event = $this->event->get_details($id, $idUser);
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
    
    /**
    * As a participant, invite another user to an event
    * params :
    *    idEvent : id of the event to invite someone to
    *    idGuest : id of the user to invite to the event
    */
    function invite($idEvent, $idGuest) {
        if($this->session->userdata('logged_in')) {
            $event = $this->event->get_event($idEvent);
            
            if($this->event->is_participation($idGuest, $idEvent) == 0) {
                //inviting the user
                if($event->organizer == $this->session->userdata('logged_in')['id']) {
                    $this->event->send_invitation($idGuest, $idEvent);
                    
                    $aResult['result'] = 'success';
                    
                   send_notification("Invitation : " . $event->name, 'Tu as reçu une invitation à '.$event->name.'<a class="list_contact" href="'. base_url('details_event/index/'.$idEvent) .'">Voir l\'évènement</a>', $this->session->userdata('logged_in')['id'], $idGuest, true);
                //sending a proposition of invitation to the organizer
                } else if($event->invitation_suggestion_allowed == 1 &&  $this->event->is_participation($this->session->userdata('logged_in')['id'], $idEvent) == 1) {
                    $this->load->model('user','',TRUE);
                    $guest = $this->user->get_user($idGuest);
                    
                    $aResult['result'] = 'success';
                    
                   send_notification("Suggestion d'invitation : ".$guest->firstname.' '.$guest->surname, $this->session->userdata('logged_in')['firstname'].' '.$this->session->userdata('logged_in')['surname'].' te propose d\'inviter '.$guest->firstname.' '.$guest->surname.' à ton évènement.</br><a href="'.base_url('details_event/invite/' . $idEvent . '/' . $idGuest).'">Inviter '.$guest->firstname.' '.$guest->surname.'</a><a class="list_contact" href="'. base_url('details_event/index/'.$idEvent) .'">Voir l\'évènement</a>', $this->session->userdata('logged_in')['id'], $event->organizer, true);
                } else {
                    $aResult['error'] = 'pas autorisé';
                }
           } else {
            $aResult['error'] = 'pas autorisé';
           }
        } else {
            $aResult['error'] = 'pas connecté';
        }
        echo json_encode($aResult);
    }
    
    /**
    * As a participant, take charge of the individual proposition.
    * params :
    *    idIndividualProposition : id of the individual proposition to take charge of
    */
    function deal_with_individual_proposition($idIndividualProposition) {
        if($this->session->userdata('logged_in')) {
            
            $individual_proposition = get_individual_proposition($idIndividualProposition);
            if($this->event->is_participation($this->session->userdata('logged_in')['id'], $individual_proposition->event_id) == 1) {
                if($this->event->is_individual_proposition_dealt_with($idIndividualProposition) == 0) {
                    $this->user->deal_with_individual_proposition($this->session->userdata('logged_in')['id'], $idIndividualProposition);
                    $aResult['result'] = 'success';
                } else {
                 $aResult['error'] = 'déjà pris en charge';
                }
           } else {
            $aResult['error'] = 'pas inscrit';
           }
        } else {
            $aResult['error'] = 'pas connecté';
        }
        echo json_encode($aResult);
    }
    
    /**
    * As a participant, give up the charge of the individual proposition.
    * params :
    *    idIndividualProposition : id of the individual proposition to give up
    */
    function give_up_individual_proposition($idIndividualProposition) {
        if($this->session->userdata('logged_in')) {
            
            $individual_proposition = get_individual_proposition($idIndividualProposition);
            if($this->event->is_participation($this->session->userdata('logged_in')['id'], $individual_proposition->event_id) == 1) {
                if($individual_proposition->user_dealing_with_it == $this->session->userdata('logged_in')['id']) {
                    $this->user->give_up_individual_proposition($idIndividualProposition);
                    $aResult['result'] = 'success';
                } else {
                 $aResult['error'] = 'pas pris en charge';
                }
           } else {
            $aResult['error'] = 'pas inscrit';
           }
        } else {
            $aResult['error'] = 'pas connecté';
        }
        echo json_encode($aResult);
    }
}

?>