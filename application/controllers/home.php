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
            $data['title'] = 'Accueil';
            $session_data = $this->session->userdata('logged_in');
            $data['firstname'] = $session_data['firstname'];
            $data['new_events'] = get_new_events($session_data['id']);
            $data['my_events'] = get_my_events($session_data['id']);

            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
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