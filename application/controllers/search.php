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

        echo "<table border='1'>
        <tr>
        <th>Prénom</th>
        <th>Nom de famille</th>
        <th>Région</th>
        <th></th>
        </tr>";

        foreach($result as $row) {
          echo "<tr>";
          echo "<td>" . $row -> firstname . "</td>";
          echo "<td>" . $row -> surname . "</td>";
          echo "<td>" . $row -> region . "</td>";
            $friendship = $this->user->is_friend($id_user, $row -> id);
            if ($friendship == 2) {
                echo "<td></td>";
            } else if ($friendship == 1) {
                echo "<td>Est un contact!</td>";
            } else {
                echo "<td id='addContact" . $row -> id . "'><button onClick='addContact(" . $id_user . ", " . $row -> id . ")'>Ajouter</a></button>";
            }
          echo "</tr>";
        }
        echo "</table>";
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