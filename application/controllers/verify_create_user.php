<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Verify_Create_User extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
 }
 
 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('inputFirstName', 'inputFirstName', 'trim|required|xss_clean');
   $this->form_validation->set_rules('inputSurname', 'inputSurname', 'trim|required|xss_clean');
   $this->form_validation->set_rules('inputPassword', 'inputPassword', 'trim|required|xss_clean');
   $this->form_validation->set_rules('inputBirthdate', 'inputBirthdate', 'required|xss_clean');
   $this->form_validation->set_rules('inputRegion', 'inputRegion', 'xss_clean');
   $this->form_validation->set_rules('inputMail', 'inputMail', 'trim|required|xss_clean');
     
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to create_user page
     $this->load->view('create_user_view');
   }
   else
   {
     //Create new user
     $creation = $this -> create_user();
     //Go to private area
     if ($creation == TRUE) {
        redirect('welcome', 'refresh');
     } else {
        //TODO redirect to error page
         //redirect('user_guide', 'refresh');
     }
   }
 
 }
 
 function create_user()
 {
   //Field validation succeeded.  Validate against database
   $firstname = $this->input->post('inputFirstName');
   $surname = $this->input->post('inputSurname');
   $password = $this->input->post('inputPassword');
   $birthdate = $this->input->post('inputBirthdate');
   $region = $this->input->post('inputRegion');
   $email = $this->input->post('inputMail');
 
   //query the database
   $result = $this->user->create_user($firstname, $surname, $password, $birthdate, $region, $email);
 
   if($result)
   {
     return TRUE;
   }
   else
   {
     return false;
   }
 }
}
?>