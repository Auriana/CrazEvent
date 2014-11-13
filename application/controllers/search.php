<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search extends CI_Controller {

    function __construct()
    {
         parent::__construct();
         $this->load->model('user','',TRUE);
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

        echo "<table border='1'>
        <tr>
        <th>Prénom</th>
        <th>Nom de famille</th>
        <th>Région</th>
        </tr>";

        foreach($result as $row) {
          echo "<tr>";
          echo "<td>" . $row -> firstname . "</td>";
          echo "<td>" . $row -> surname . "</td>";
          echo "<td>" . $row -> region . "</td>";
          echo "</tr>";
        }
        echo "</table>";
    }

}

?>