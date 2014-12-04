<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manage_User extends CI_Controller {

    function __construct()
    {
         parent::__construct();
         $this->load->model('user','',TRUE);
         $this->load->model('event','',TRUE);
    }

    function index()
    {
        //if user is not logged in : redirection to welcome page
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
            $data['title'] = 'Mon compte';
            $session_data = $this->session->userdata('logged_in');
            $data['user'] = $session_data;
            $data['regions'] = get_region_scrollbox();

            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/manage_user_view', $data);
            $this->load->view('templates/footer');
        }
        else
        {  
            redirect('welcome', 'refresh');
        }
    }
    
    function add_contact()
    {
        $aResult = array();

        if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

        if( !isset($aResult['error']) ) {
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $id_user = $_POST['arguments'][0];
                   $id_contact = $_POST['arguments'][1];
                   
                   $result = $this->user->add_contact($id_user, $id_contact);
                   
                   $aResult['result'] = 'success';
               }
        }

        echo json_encode($aResult);
    }

    function join_event()
    {
        $aResult = array();

        if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

        if( !isset($aResult['error']) ) {
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 3) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $id_user = $_POST['arguments'][0];
                   $id_event = $_POST['arguments'][1];
                   $private = $_POST['arguments'][2];
                   
                   $result = $this->event->join_event($id_user, $id_event);
                   
                   $aResult['result'] = 'success';
               }
        }

        echo json_encode($aResult);
    }
    
    function change_firstname()
    {
        $aResult = array();

        if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

        if( !isset($aResult['error']) ) {
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $idUser = $_POST['arguments'][0];
                   $newFirstname = $_POST['arguments'][1];
                   
                   $success = $this->user->change_firstname($idUser, $newFirstname);
                   
                   if ($success == 1) {
                       $aResult['result'] = 'success';
                       // update session data with the new firstname
                       $newSessionData = $this->session->userdata('logged_in');
                       $newSessionData['firstname'] = $newFirstname;
                       $this->session->set_userdata('logged_in', $newSessionData);
                   } else {
                       $aResult['error'] = 'Error in update';
                   }
               }
        }

        echo json_encode($aResult);
    }
    
    function change_surname()
    {
        $aResult = array();

        if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

        if( !isset($aResult['error']) ) {
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $idUser = $_POST['arguments'][0];
                   $newSurname = $_POST['arguments'][1];
                   
                   $success = $this->user->change_surname($idUser, $newSurname);
                   
                   if ($success == 1) {
                       $aResult['result'] = 'success';
                       // update session data with the new firstname
                       $newSessionData = $this->session->userdata('logged_in');
                       $newSessionData['surname'] = $newSurname;
                       $this->session->set_userdata('logged_in', $newSessionData);
                   } else {
                       $aResult['error'] = 'Error in update';
                   }
               }
        }

        echo json_encode($aResult);
    }
    
    function change_password()
    {
        $aResult = array();

        if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

        if( !isset($aResult['error']) ) {
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 3) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $idUser = $_POST['arguments'][0];
                   $oldPassword = $_POST['arguments'][1];
                   $newPassword = $_POST['arguments'][2];
                   
                   // test the old password
                   $this->db->select('password');
                   $this->db->from('user');
                   $this->db->where('id', $this->session->userdata('logged_in')['id']);
                   $query = $this->db->get();
                   $result = $query->result();
                   $realdOldPassword = $result[0]->password;
                   
                   if ($realdOldPassword != MD5($oldPassword)) {
                        $aResult['error'] = 'Error in update';
                   } else {
                       $success = $this->user->change_password($idUser, $newPassword);
                       if ($success == 1) {
                           $aResult['result'] = 'success';
                       } else {
                           $aResult['error'] = 'Error in update';
                       }
                   }
               }
        }

        echo json_encode($aResult);
    }
    
    function change_region()
    {
        $aResult = array();

        if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

        if( !isset($aResult['error']) ) {
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $idUser = $_POST['arguments'][0];
                   $newRegion = $_POST['arguments'][1];
                   
                   $success = $this->user->change_region($idUser, $newRegion);
                   
                   if ($success == 1) {
                       $aResult['result'] = 'success';
                       // update session data with the new region
                       $this->db->select('region.content AS region');
                       $this->db->from('user');
                       $this->db->join('region', 'region.id = user.region_id', 'inner');
                       $this->db->where('user.id', $this->session->userdata('logged_in')['id']);
                       $query = $this->db->get();
                       $result = $query->result();
                       $newRegion = $result[0]->region;
                       
                       $newSessionData = $this->session->userdata('logged_in');
                       $newSessionData['region'] = $newRegion;
                       $this->session->set_userdata('logged_in', $newSessionData);
                       $aResult['newRegion'] = $newRegion;
                   } else {
                       $aResult['error'] = 'Error in update';
                   }
               }
        }

        echo json_encode($aResult);
    }
}

?>