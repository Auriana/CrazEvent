<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Create_Event extends CI_Controller {

    function __construct()
    {
         parent::__construct();
    }

    function index()
    {
        //if user is logged in : redirection to home page
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
            redirect('home', 'refresh');
        }
        //else propose create user form
        else
        {  
            $data['title'] = 'Créer évènement';

            $this->load->helper(array('form'));
            $this->load->view('templates/header', $data);
            $this->load->view('pages/create_event_view');
            $this->load->view('templates/footer');
        }
    }

}

?>