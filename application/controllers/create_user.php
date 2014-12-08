<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Create_User extends CI_Controller {

    function __construct() {
         parent::__construct();
        $this->load->model('user','',TRUE);
    }

    /**
    * Access to the functionnality to create a user (sign in).
    * Redirect to welcome page if not logged in.
    */
    function index() {
        //if user is logged in : redirection to home page
        if($this->session->userdata('logged_in')) {
            redirect('home', 'refresh');
        //else propose siging in form
        } else {
            $data['title'] = 'Inscription';
            
            $data['regions'] = get_region_scrollbox();

            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_out', $data);
            $this->load->view('pages/create_user_view');
            $this->load->view('templates/footer');
        }
    }
    
    /**
    * Create a new user.
    * The user is automatically logged in.
    */
    function create() {
       //This method will have the credentials validation
       $this->load->library('form_validation');

       $this->form_validation->set_rules('inputFirstName', 'inputFirstName', 'trim|required|xss_clean');
       $this->form_validation->set_rules('inputSurname', 'inputSurname', 'trim|required|xss_clean');
       $this->form_validation->set_rules('inputPassword', 'inputPassword', 'trim|required|xss_clean');
       $this->form_validation->set_rules('inputBirthdate', 'inputBirthdate', 'required|xss_clean');
       $this->form_validation->set_rules('inputRegion', 'inputRegion', 'xss_clean');
       $this->form_validation->set_rules('inputEmail', 'inputEmail', 'trim|required|xss_clean');

       if($this->form_validation->run() == FALSE) {
         //Field validation failed.  User redirected to create_user page
         redirect('create_user', 'refresh');
       } else {
         //Create new user
        $firstname = $this->input->post('inputFirstName');
        $surname = $this->input->post('inputSurname');
        $password = $this->input->post('inputPassword');
        $birthdate = $this->input->post('inputBirthdate');
        $region = $this->input->post('inputRegion');
        $email = $this->input->post('inputEmail');

        //query the database
        $result = $this->user->create_user($firstname, $surname, $password, $birthdate, $region, $email);

         //Go to private area
         if ($result) {
            login_utility($email = $this->input->post('inputEmail'), $password = $this->input->post('inputPassword'));
            redirect('home', 'refresh');
         } else {
            redirect('welcome', 'refresh');
         }
       }

     }
}

?>