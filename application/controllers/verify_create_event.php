<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Verify_Create_User extends CI_Controller {
 
 function __construct() {
   parent::__construct();
   $this->load->model('user','',TRUE);
 }
 
 function index() {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
     //TODO : useless car javascript validation
     /*
   $this->form_validation->set_rules('inputFirstName', 'inputFirstName', 'trim|required|xss_clean');
   $this->form_validation->set_rules('inputSurname', 'inputSurname', 'trim|required|xss_clean');
   $this->form_validation->set_rules('inputPassword', 'inputPassword', 'trim|required|xss_clean');
   $this->form_validation->set_rules('inputBirthdate', 'inputBirthdate', 'required|xss_clean');
   $this->form_validation->set_rules('inputRegion', 'inputRegion', 'xss_clean');
   $this->form_validation->set_rules('inputEmail', 'inputEmail', 'trim|required|xss_clean');
   */
     
   if($this->form_validation->run() == FALSE) {
     //Field validation failed.  User redirected to create_user page
     //redirect('create_user', 'refresh'); //TODO
   }
   else {
     //Create new event
     $creation = $this->create_event();
     
     if ($creation == TRUE) {
        redirect('welcome', 'refresh');
     } else {
        //TODO redirect to error page
         //redirect('user_guide', 'refresh');
     }
   }
 
 }
    
    /*
    * retrieve an array from a form with an unkown number of input field that give the same kind of data
    * The input fields must be numbered stating with 1.
    */
 function get_array_from_form($formInputName) {
   $array = array();
   $i = 1;
   while(($formValue = $this->input->post($formInputName + $i++, TRUE)) != false) {
       if($formValue != '') {
           $array[$i] = $formValue;
       }
   }
   return $array;
 }
 
 function create_event() {
     
     /*
     * extract the event data from the form
     */
   
     //TODO : en passant true, on fait du XSS check
   $eventName = $this->input->post('inputEventName', TRUE);
     
   if($this->input->post('privatePublic', TRUE) == 'private') {
       $eventPrivate = 1;
   else {
       $eventPrivate = 0;
   }
       
   $eventDescription = $this->input->post('inputDescription', TRUE);
   $eventActivities = get_array_from_form('inputActivity');
   $eventKeywords = get_array_from_form('inputKeyword');
   $eventChecklistItems = get_array_from_form('inputChecklistItem');
   $eventInvitationSuggestionAllowed = $this->input->post('inputInvitationAllowed', TRUE);
   $eventIndividualPropositionSuggestionAllowed = $this->input->post('inputIndividualPropositionAllowed', TRUE);
       
   if($this->input->post('inputMaxParticipant', TRUE)) == '') {
       $eventMaxParticipant = null;
   } else {
       $eventMaxParticipant = $this->input->post('inputMaxParticipant', TRUE);
   }
    
   if($this->input->post('inputMinAge', TRUE)) == '') {
       $eventMinAge = null;
   } else {
       $eventMinAge = $this->input->post('inputMinAge', TRUE);
   }
       
   if($this->input->post('inputJoinDate', TRUE)) == '') {
       $eventInscriptionDeadline = null;
   } else {
       $eventInscriptionDeadline = $this->input->post('inputJoinDate', TRUE);
   }
       
   if($this->input->post('inputDate') == '', TRUE)) {
       $eventDate = null;
   } else {
       $eventDate = $this->input->post('inputDate', TRUE);
   }
       
   if($this->input->post('inputDuration') == '', TRUE)) {
       $eventDuration = null;
   } else {
       $eventDuration = $this->input->post('inputDuration', TRUE);
   }
       
   if($this->input->post('inputPlace') == '', TRUE)) {
       $eventPlace = null;
   } else {
       $eventPlace = $this->input->post('inputPlace', TRUE);
   }
       
   $eventRegion = $this->input->post('inputRegion', TRUE);
   
   //query the database              
   return $this->event->create_event($eventName, $eventPrivate, $eventDescription, $eventActivities, $eventKeywords, $eventChecklistItems, $eventInvitationSuggestionAllowed, $eventMaxParticipant, $eventMinAge, $eventInscriptionDeadline, $eventDate, $eventPlace, $this->session->userdata('logged_in')['id'], $eventDuration, $eventIndividualPropositionSuggestionAllowed, $eventRegion);
 }
}
?>