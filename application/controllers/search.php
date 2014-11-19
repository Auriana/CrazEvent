<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search extends CI_Controller {

    function __construct()
    {
         parent::__construct();
         $this->load->model('user','',TRUE);
         $this->load->model('event','',TRUE);
    }

    function index()
    {
        
    }
    
    function user()
    {
        //if user is not logged in : redirection to welcome page
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
            $data['title'] = 'Rechercher utilisateur';
            $session_data = $this->session->userdata('logged_in');

            $this->load->helper(array('form'));
            $this->load->view('templates/header', $data);
            $this->load->view('pages/search_user_view', $data);
            $this->load->view('templates/footer');
        }
        else
        {  
            redirect('welcome', 'refresh');
        }
    }
    
    function search_user()
    {
        $firstname = $_GET['f'];
        $surname = $_GET['s'];
        $region = $_GET['r'];
        
        $result = $this->user->search_user($firstname, $surname, $region);
        
        $session_data = $this->session->userdata('logged_in');
        $id_user = $session_data['id'];

		echo "<h3>Résultat(s)</h3>";
        echo "<ul class='result_search'>";

        foreach($result as $row) {
          echo "<li>" . $row -> firstname . " " . $row -> surname . ", " . $row -> region;
            $friendship = $this->user->is_friend($id_user, $row -> id);
            if ($friendship == 2) {
                echo "";
            } else if ($friendship == 1) {
				 echo "<div class='info_contact'>Déjà un contact!</div>";
			} else {
                echo "<div id='addContact" . $row -> id . "'><button class='btn btn-default btn-xs' onClick='addContact(" . $id_user . ", " . $row -> id . ")'>Ajouter</a></button>";
				echo "<div class='clearer'></div>";
				echo "<div class='clearer'></div>";
            }
          echo "</li>";
        }
        echo "</ul";
    }
    
    function add_user($id_user, $id_contact) {
    }
    
    function event()
    {
        //if user is not logged in : redirection to welcome page
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
            $data['title'] = 'Rechercher évènement';

            $this->load->helper(array('form'));
            $this->load->view('templates/header', $data);
            $this->load->view('pages/search_event_view', $data);
            $this->load->view('templates/footer');
        }
        else
        {  
            redirect('welcome', 'refresh');
        }
    }

    function search_event()
    {
        /*
        * The words used for research are separated by spaces
        */
        $searchString = $_GET['s'];
        $searchWords = explode(" ", $searchString);
        $result = $this->event->search_event($searchWords);

        $resultTable = "";
        $resultTable .= "<ul>";

        foreach($result as $row) {
          $resultTable .= '<li><a href="../details_event/index/'.$row -> id.'">'. $row -> name . '</li>';
        }
        $resultTable .= "</ul>";
        
        echo $resultTable;
    }

}

?>