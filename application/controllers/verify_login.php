<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Verify_Login extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
 }
 
 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('inputMail', 'inputMail', 'trim|required|xss_clean');
   $this->form_validation->set_rules('inputPassword', 'inputPassword', 'trim|required|xss_clean');
 
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to welcome page
     $this->load->view('pages/welcome_view');
   }
   else
   {
     //Log in the user
     $login = $this->login();
     //Go to private area
     if ($login) {
        redirect('home', 'refresh');
     } else {
        $this->load->view('pages/welcome_view');
     }
   }
 
 }
 
 function login()
 {
   //Field validation succeeded.  Validate against database
   $email = $this->input->post('inputEmail');
   $password = $this->input->post('inputPassword');
 
   //query the database
   $result = $this->user->login($email, $password);
 
   if ($result) {
       //create the session variable
       $sess_array = array();
       foreach($result as $row) {
           $sess_array = array(
               'id' => $row->id,
               'email' => $row->email,
               'firstname' => $row->firstname,
               'surname' => $row->surname
           );
           $this->session->set_userdata('logged_in', $sess_array);
       }
   } else {
       $this->form_validation->set_message('login', 'Invalid email or password');
   }
     
   return $result;
 }
}
?>