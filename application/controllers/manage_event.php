<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manage_Event extends CI_Controller {

    function __construct()
    {
         parent::__construct();
         $this->load->model('event','',TRUE);
		 $this->load->model('user','',TRUE);
    }

    function index() {}
    
    /**
    * Access to the functionnality to manage an event.
    * Redirect to welcome page if not logged in.
    * Only the organizer can modifiy the event
    * params :
    *    id : id of the event to display in the managing forms
    */
    function management($id) {
        if($this->session->userdata('logged_in')) {
			$info_event = $this->event->get_details($id);
            
            if($info_event['event']->organizer == $this->session->userdata('logged_in')['id']) {
                $data['title'] = 'Modifier l\évènement';
                $data['nb_notifications'] = $this->user->count_unread_message($this->session->userdata('logged_in')['id']);
                $info_event['regions'] = get_region_scrollbox_with_selected($info_event['event']->region);

                $this->load->helper(array('form'));
                $this->load->view('templates/header_logged_in', $data);
                $this->load->view('pages/manage_event_view', $info_event);
                $this->load->view('templates/footer');
            } else {
                redirect('home', 'refresh');
            }
        //if user is not logged in : redirection to welcome page
        } else {  
            redirect('welcome', 'refresh');
        }
    }
    
    /**
    * Access to the functionnality to create an event.
    * Redirect to welcome page if not logged in.
    */
    function creation() {    
        if($this->session->userdata('logged_in')) {
            $data['title'] = 'Créer évènement';
            $data['nb_notifications'] = $this->user->count_unread_message($this->session->userdata('logged_in')['id']);
            $data['regions'] = get_region_scrollbox();

            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/create_event_view');
            $this->load->view('templates/footer');
        //if user is not logged in : redirection to welcome page
        } else {  
            redirect('welcome', 'refresh');
        }
    }

    /*
    * Retrieve an array from a form with an unkown number of input fields that give the same kind of data.
    * The input fields must be numbered starting with 1.
    * params :
    *    formInputName : the name of the input fields. (they are then numbered starting with 1)
    * return : array of the values of the input fields
    */
    function get_array_from_form($formInputName) {
        $array = array();
        $i = 1;
        while(($formValue = $this->input->post($formInputName.$i++, TRUE)) != false) {
           if($formValue != '') {
               $array[] = $formValue;
           }
        }
        return $array;
    }
    
    /**
    * Extract the event data from the form
    * return : array containing the event data
    */
    function extractEventDataFromForm() {
        $eventData = array();

        $eventData['eventName'] = $this->input->post('inputEventName', TRUE);

        if($this->input->post('privatePublic', TRUE) == 'private') {
           $eventData['eventPrivate'] = 1;
        } else {
           $eventData['eventPrivate'] = 0;
        }

        if($this->input->post('inputDate', TRUE) == '') {
           $eventData['eventDate'] = null;
        } else {
           $eventData['eventDate'] = $this->input->post('inputDate', TRUE);
        }

        if($this->input->post('inputDuration', TRUE) == '') {
           $eventData['eventDuration'] = 1;
        } else {
           $eventData['eventDuration'] = $this->input->post('inputDuration', TRUE);
        }

        $eventData['eventPlaces'] = $this->get_array_from_form('inputPlace');
        $eventData['eventRegion'] = $this->input->post('inputRegion', TRUE);       
        $eventData['eventActivities'] = $this->get_array_from_form('inputActivity');
        $eventData['eventDescription'] = $this->input->post('inputDescription', TRUE);
        $eventData['eventKeywords'] = $this->get_array_from_form('inputKeyword');
        $eventData['eventChecklistItems'] = $this->get_array_from_form('inputChecklistItem');
        
        $eventData['eventIndividualPropositions'] = array();
        $i = 1;
        while(($formValue = $this->input->post("inputIndividualProposition".$i++, TRUE)) != false) {
           if($formValue != '') {
               $array = array();
               $array['content']  = $formValue;
               if($this->input->post("inputIndividualPropositionUser".$i, TRUE) != false && $this->input->post("inputIndividualPropositionUser".$i, TRUE) != "") {
                  $array['user_dealing_with_it'] = $this->input->post("inputIndividualPropositionUser".$i, TRUE);
               }
               
               $eventData['eventIndividualPropositions'][] = $array;
           }
        }
                
        $eventData['eventInvitationSuggestionAllowed'] = isset($_POST['inputInvitationAllowed']);
        $eventData['eventIndividualPropositionSuggestionAllowed'] = isset($_POST['inputIndividualPropositionAllowed']);

        if($this->input->post('inputMaxParticipant', TRUE) == '') {
           $eventData['eventMaxParticipant'] = null;
        } else {
           $eventData['eventMaxParticipant'] = $this->input->post('inputMaxParticipant', TRUE);
        }

        if($this->input->post('inputMinAge', TRUE) == '') {
           $eventData['eventMinAge'] = 0;
        } else {
           $eventData['eventMinAge'] = $this->input->post('inputMinAge', TRUE);
        }

        if($this->input->post('inputJoinDate', TRUE) == '') {
           $eventData['eventInscriptionDeadline'] = null;
        } else {
           $eventData['eventInscriptionDeadline'] = $this->input->post('inputJoinDate', TRUE);
        }
        
        return $eventData;
    }
    
    /**
    * Create an event.
    */
    function create() {

        $eventData = $this->extractEventDataFromForm();
        
        //query the database              
        $eventId = $this->event->create_event($eventData['eventName'], $eventData['eventPrivate'], $eventData['eventDate'], $eventData['eventDuration'], $eventData['eventPlaces'], $eventData['eventRegion'], $eventData['eventActivities'], $eventData['eventDescription'], $eventData['eventKeywords'], $eventData['eventChecklistItems'], $eventData['eventIndividualPropositions'], $eventData['eventInvitationSuggestionAllowed'], $eventData['eventIndividualPropositionSuggestionAllowed'], $eventData['eventMaxParticipant'], $eventData['eventMinAge'], $eventData['eventInscriptionDeadline'], $this->session->userdata('logged_in')['id']);
        //join the event
        //there is no invitation to remove from us even if the event is private
        //therefor join_public_event is used
        $this->event->join_public_event($this->session->userdata('logged_in')['id'], $eventId);

        if ($eventId == TRUE) {
            redirect('home', 'refresh');
        } else {
            echo 'erreur à la création';
            redirect('create_event', 'refresh');
        }
    }

    /**
    * Update an event.
    * Only the organiser can update an event.
    * params :
    *   id : the event to update's id
    */
    function update($id) {
        if($this->session->userdata('logged_in')) {
			$event = $this->event->get_event($id);
            
            if($event->organizer == $this->session->userdata('logged_in')['id']) {

                $eventData = $this->extractEventDataFromForm();

                //query the database    
                $eventId = $this->event->update_event($id, $eventData['eventName'], $eventData['eventPrivate'], $eventData['eventDate'], $eventData['eventDuration'], $eventData['eventPlaces'], $eventData['eventRegion'], $eventData['eventActivities'], $eventData['eventDescription'], $eventData['eventKeywords'], $eventData['eventChecklistItems'], $eventData['eventIndividualPropositions'], $eventData['eventInvitationSuggestionAllowed'], $eventData['eventIndividualPropositionSuggestionAllowed'], $eventData['eventMaxParticipant'], $eventData['eventMinAge'], $eventData['eventInscriptionDeadline']);

                //sending a notification to participants
                $eventParticipants = $this->event->get_event_participants($id);
                foreach ($eventParticipants as $participant)
                {
                    send_notification("Modification d’un paramètre de l’évènement : " . $eventData['eventName'], 'L\'événement '.$eventData['eventName'].' a été modifié<a class="list_contact" href="'. base_url('details_event/index/'.$id) .'">Voir l\'évènement</a>', $this->session->userdata('logged_in')['id'], $participant->id, false);
                }
            }
        }

        redirect('home', 'refresh');
    }
    
    /**
    * Cancel an event.
    * Only the organiser can cancel an event.
    * params :
    *    id : id of the event to cancel
    */
    function cancel($id) {
        if($this->session->userdata('logged_in'))
        {
			$info_event = $this->event->get_details($id);
            if($info_event['event']->organizer == $this->session->userdata('logged_in')['id']) {
                
                $this->event->cancel($id);
                
                //sending a notification to participants
                foreach ($info_event['eventParticipants'] as $participant)
                {
                    send_notification("Annulation de l’évènement : " . $info_event['event']->name, 'L\'événement '.$info_event['event']->name.' a été annulé ', $info_event['event']->organizer, $participant->id, true);

                }
            }
        }
        redirect('home', 'refresh');
    }
    
    function change_choice_place($idEvent, $place) {
        $aResult = array();
        $idUser = $this->session->userdata('logged_in')['id'];
        $this->event->change_choice_place($idUser, $idEvent, $place);
        echo json_encode($aResult);
    }

    /**
    * Add an individual proposition to the event
    * params :
    *    id : id of the event
    */
    function add_individual_proposition($id) {
        $aResult = array();

        if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

        if( !isset($aResult['error']) ) {
           if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 1) ) {
               $aResult['error'] = 'Error in arguments!';
           }
           else {
               if($this->session->userdata('logged_in')) {
                    if($this->event->is_participation($this->session->userdata('logged_in')['id'], $id) == 1) {
                        $event = $this->event->get_event($id);
                        if($event->individual_proposition_suggestion_allowed == 1) {
                           $individualProposition = $_POST['arguments'][0];

                           $result = $this->event->add_individual_proposition($id, $individualProposition);

                           $aResult['result'] = $result;
                            
                            //sending a notification to the organizer
                            send_notification("Nouvelle proposition individuelle par un participant : " . $event->name, $this->session->userdata('logged_in')['firstname'].' '.$this->session->userdata('logged_in')['surname'].' a fait une proposition individuelle<a class="list_contact" href="'. base_url('details_event/index/'.$id) .'">Voir l\'évènement</a>', $this->session->userdata('logged_in')['id'], $event->organizer, false);
                        } else {
                            $aResult['error'] = 'non autorisé';
                        }
                    } else {
                        $aResult['error'] = 'pas inscrit';
                    }
               } else {
                   $aResult['error'] = 'pas connecté';
               }
           }
        }
        
        echo json_encode($aResult);
    }
}

?>