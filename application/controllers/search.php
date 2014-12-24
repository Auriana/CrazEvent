<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search extends CI_Controller {

    function __construct() {
         parent::__construct();
         $this->load->model('user','',TRUE);
         $this->load->model('event','',TRUE);
    }

    function index()
    {}
    
    /**
    * Access to the functionnality to search a user.
    * Redirect to welcome page if not logged in.
    */
    function user()
    {
        //if user is not logged in : redirection to welcome page
        if($this->session->userdata('logged_in')) {
            $data['title'] = 'Rechercher utilisateur';
            $session_data = $this->session->userdata('logged_in');

            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/search_user_view', $data);
            $this->load->view('templates/footer');
        //if user is not logged in : redirection to welcome page
        } else {  
            redirect('welcome', 'refresh');
        }
    }
    
    /**
    * Search for a user by it's name and region.
    * This function prints it's result as a list and is therefore meant to be called asynchronously with AJAX.
    */
    function search_user() {
        $firstname = $_GET['f'];
        $surname = $_GET['s'];
        $region = $_GET['r'];
        
        $result = $this->user->search_user($firstname, $surname, $region);
        
        $session_data = $this->session->userdata('logged_in');
        $id_user = $session_data['id'];

        $resultTable = "";
		$resultTable .= "<h3>Résultat(s)</h3>";
        $resultTable .=  "<ul class='result_search'>";

        foreach($result as $row) {
          $resultTable .=  "<li>" . $row -> firstname . " " . $row -> surname . ", " . $row -> region;
            $friendship = $this->user->is_friend($id_user, $row -> id);
            if ($friendship == 2) {
                $resultTable .=  "";
            } else if ($friendship == 1) {
				 $resultTable .=  "<div class='list_contact'>Déjà un contact!</div>";
			} else {
                $resultTable .=  "<div class='list_contact' id='addContact" . $row -> id . "'><button class='btn btn-default btn-xs' onClick='addContact(" . $id_user . ", " . $row -> id . ")'>Ajouter</a></button>";
				$resultTable .=  "</div><div class='clearer'></div>";
            }
          $resultTable .=  "</li>";
        }
        $resultTable .=  "</ul";
        
        echo $resultTable;
    }
    
    function get_contacts() {        
        $session_data = $this->session->userdata('logged_in');
        $id_user = $session_data['id'];
        
        $result = $this->user->get_contacts($id_user);

        
        echo $resultTable;
    }
    
    /**
    * Access to the functionnality to search an event.
    * Redirect to welcome page if not logged in.
    */
    function event() {
        if($this->session->userdata('logged_in'))
        {
            $data['title'] = 'Rechercher évènement';

            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/search_event_view', $data);
            $this->load->view('templates/sticky-footer');
        //if user is not logged in : redirection to welcome page
        } else {  
            redirect('welcome', 'refresh');
        }
    }

    /**
    * Search for an event by using a list of keywords.
    * This function prints it's result as a list and is therefore meant to be called asynchronously with AJAX.
    */
    function search_event() {
        /*
        * The words used for research are separated by spaces
        */
        $searchString = $_GET['s'];
        $searchWords = explode(" ", $searchString);
        $result = $this->event->search_event($this->session->userdata('logged_in')['id'], $searchWords);

        $resultTable = "";
		$resultTable .= "<h3>Résultat(s)</h3>";
        $resultTable .= "<ul class='result_search'>";

        foreach($result as $row) {
          $resultTable .= '<li><a href="../details_event/index/'.$row -> eventId.'">'. $row -> name . '</li>';
        }
        $resultTable .= "</ul>";
        
        echo $resultTable;
    }

}

?>