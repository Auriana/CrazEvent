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
   $this->form_validation->set_rules('inputPassword', 'inputPassword', 'trim|required|xss_clean');
 
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
   $username = $this->input->post('inputFirstName');
   $password = $this->input->post('inputPassword');
 
   //query the database
   $result = $this->user->create_user($username, $password);
 
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