<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Create_Event extends CI_Controller {

    function __construct()
    {
         parent::__construct();
    }

    function index()
    {
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
            $data['title'] = 'Créer évènement';
            
            $data['regions'] = get_region_scrollbox();

            $this->load->helper(array('form'));
            $this->load->view('templates/header', $data);
            $this->load->view('pages/create_event_view');
            $this->load->view('templates/footer');
        }
        //if user is not logged in : redirection to login
        else
        {  
            redirect('home', 'refresh');
        }
    }

}

?>