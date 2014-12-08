<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Details_Event extends CI_Controller {

    function __construct()
    {
         parent::__construct();
         $this->load->model('event','',TRUE);
    }

    function index($id)
    {
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
			$data['title'] = 'Détails de l\évènement';
			

			$info_event = $this->event->get_details($id);
            $session_data = $this->session->userdata('logged_in');
            
            $info_event['id_user'] = $session_data['id'];
            $info_event['id_event'] = $id;
            $info_event['participation'] = get_participation_link($session_data['id'], $id, $info_event['event']->private);
            /*
            if ($this -> event -> is_participation($session_data['id'], $id) == 0) {
                if ($info_event['event']->private == 1) {
                    $info_event['participation'] = '<a id="joinEvent" href="#" onClick="joinEvent(' . $info_event['id_user'] . ', ' . $info_event['id_event'] . ',1)" alt="">Répondre à l\'invitation</a>';
                } else {
                    $info_event['participation'] = '<a id="joinEvent" href="#" onClick="joinEvent(' . $info_event['id_user'] . ', ' . $info_event['id_event'] . ',0)" alt="">S\'inscrire</a>';
                }
            } else {
                $info_event['participation'] = '<p>Vous êtes inscrit <a id="quitEvent" href="#" onClick="quitEvent(' . $info_event['id_user'] . ', ' . $info_event['id_event'] . ')" alt="">(se désinscrire)</a></p>';
            }*/
			
            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/details_event_view', $info_event);
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