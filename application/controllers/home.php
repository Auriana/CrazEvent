<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {

    function __construct()
    {
         parent::__construct();
    }

    function index()
    {
        //if user is not logged in : redirection to welcome page
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
            $data['title'] = 'Home';
            $session_data = $this->session->userdata('logged_in');
            $data['firstname'] = $session_data['firstname'];

            $this->load->helper(array('form'));
            $this->load->view('templates/header', $data);
            $this->load->view('pages/home_view', $data);
            $this->load->view('templates/footer');
        }
        else
        {  
            redirect('welcome', 'refresh');
        }
    }
    
    function logout()
    {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('welcome', 'refresh');
    }

}

?>