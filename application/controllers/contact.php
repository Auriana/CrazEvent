<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contact extends CI_Controller {

    function __construct() {
         parent::__construct();
    }

    /**
    * Access to the contact page.
    * The contact page can always be accessed.
    */
    function index() {
		$data['title'] = 'Contact';

		//$this->load->helper(array('form'));
		
		if($this->session->userdata('logged_in')) {
            $this->load->view('templates/header_logged_in', $data);
        } else {         
            $this->load->view('templates/header_logged_out', $data);
			// due to the fixed-top navbar :
			$this->load->view('templates/space', $data);
        }
		$this->load->view('pages/contact_view', $data);
		$this->load->view('templates/footer');
		
		
    }
	
	// Does not work
	function sendEmail() {
		$this->load->library('email');

		$this->email->from('inputEmail','inputName');
		$this->email->to('auriana.hug@heig-vd.ch');
		//$this->email->to('crazevent.info@gmail.com');
		
		$this->email->subject('inputSubject');
		$this->email->message('inputMessage');

		$this->email->send();

		echo $this->email->print_debugger();
	
	}
}

?>