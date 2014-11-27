<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
        //if user is logged in : redirection to home page
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
            redirect('home', 'refresh');
        }
        //else propose login form
        else
        {         
            $data['title'] = "Bienvenue";
        
            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_out', $data);
            $this->load->view('pages/welcome_view');
            $this->load->view('templates/footer');
        }
	}
}