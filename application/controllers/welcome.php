<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    function __construct() {
       parent::__construct();
       $this->load->model('user','',TRUE);
    }

    /**
    * Access to the welcome page.
    * The welcome page is accessed only when logged out.
    */
	public function index() {
        //if user is logged in : redirection to home page
        if($this->session->userdata('logged_in')) {
            redirect('home', 'refresh');
        //else propose login form
        } else {         
            $data['title'] = "Bienvenue";
        
            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_out', $data);
            $this->load->view('pages/welcome_view');
            $this->load->view('templates/footer');
        }
	}
    
    function login() {
       //This method will have the credentials validation
       $this->load->library('form_validation');

       $this->form_validation->set_rules('inputEmail', 'inputEmail', 'trim|required|xss_clean');
       $this->form_validation->set_rules('inputPassword', 'inputPassword', 'trim|required|xss_clean');

       if($this->form_validation->run() == FALSE) {
         //Field validation failed.  User redirected to create_user page
        redirect('welcome', 'refresh');
       } else {
         //Log in the user
         $login = login_utility($this->input->post('inputEmail'), $this->input->post('inputPassword'));

         //Go to private area
         if ($login) {
            redirect('home', 'refresh');
         } else {
            redirect('welcome', 'refresh');
         }
       }

     }
}