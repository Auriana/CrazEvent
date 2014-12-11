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
            $this->load->view('templates/sticky-footer');
        }
        else
        {  
            redirect('welcome', 'refresh');
        }
    }
    
    function contact()
    {
        //if user is not logged in : redirection to welcome page
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
            $data['title'] = 'Mes contacts';
            $session_data = $this->session->userdata('logged_in');
            $data['user'] = $session_data;

            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/manage_contact_view', $data);
            $this->load->view('templates/sticky-footer');
        }
        else
        {  
            redirect('welcome', 'refresh');
        }
    }
    
    function get_contacts()
    {
        $contacts = $this->user->get_contacts($session_data = $this->session->userdata('logged_in')['id']);
        
        $contactTable =  "<ul class='result_search'>";

        foreach($contacts as $row) {
          $contactTable .= "<div id='removeContact" . $row -> id . "'>";
          $contactTable .= "<li>" . $row -> firstname . " " . $row -> surname;
          $contactTable .= "<div class='list_contact'><button class='btn btn-default btn-xs' onClick='removeContact(" . $row -> id . ")'>Retirer</a></button>";
          $contactTable .= "</li></div>";
        }
        
        $contactTable .=  "</ul";
        
        echo $contactTable;
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
                   
                   if($this->user->is_friend($id_user, $id_contact) == 1) {
                       send_notification("Ajout de contact : " . $this->session->userdata('logged_in')['firstname'].' '.$this->session->userdata('logged_in')['surname'], '<p>'.$this->session->userdata('logged_in')['firstname'].' '.$this->session->userdata('logged_in')['surname'].' t\'as ajouté comme contact.</p>', $id_user, $id_contact, false);
                   }
                   
                   $aResult['result'] = 'success';
               }
        }

        echo json_encode($aResult);
    }
    
    function remove_contact()
    {
        $aResult = array();

        if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

        if( !isset($aResult['error']) ) {
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 1) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $id_contact = $_POST['arguments'][0];
                   $id_user = $session_data = $this->session->userdata('logged_in')['id'];
                
                   $result = $this->user->remove_contact($id_user, $id_contact);
                   
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
                   
                   if($private == 1) {
                        $result = $this->event->join_private_event($id_user, $id_event);
                   } else {
                       $result = $this->event->join_public_event($id_user, $id_event);
                   }
               
                   //sending a notification to the organizer
                   if($this->event->is_participation($id_user, $id_event) == 1) {
                       $event = $this->event->get_event($id_event);
                       send_notification("Inscription d'un participant : " . $event->name, '<p>'.$this->session->userdata('logged_in')['firstname'].' '.$this->session->userdata('logged_in')['surname'].' s\'est inscrit à ton événement!.</p><p><a href="'. base_url('details_event/index/' . $event->id) . '">Voir l\'évènement</a></p>', $id_user, $event->organizer, false);
                   }
                   
                   $aResult['result'] = get_participation_link($id_user, $id_event, $private);
               }
        }
        echo json_encode($aResult);
    }
    
    function quit_event()
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
                   
                   $result = $this->event->quit_event($id_user, $id_event);
                   
                   $aResult['result'] = get_participation_link($id_user, $id_event, $private);
               }
        }

        echo json_encode($aResult);
    }
    
    /**
    * Access to the functionnality to create a user (sign in).
    * Redirect to welcome page if not logged in.
    */
    function creation() {
        //if user is logged in : redirection to home page
        if($this->session->userdata('logged_in')) {
            redirect('home', 'refresh');
        //else propose siging in form
        } else {
            $data['title'] = 'Inscription';
            
            $data['regions'] = get_region_scrollbox();

            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_out', $data);
            $this->load->view('pages/create_user_view');
            $this->load->view('templates/footer');
        }
    }
    
    /**
    * Create a new user.
    * The user is automatically logged in.
    */
    function create() {
       //This method will have the credentials validation
       $this->load->library('form_validation');

       $this->form_validation->set_rules('inputFirstName', 'inputFirstName', 'trim|required|xss_clean');
       $this->form_validation->set_rules('inputSurname', 'inputSurname', 'trim|required|xss_clean');
       $this->form_validation->set_rules('inputPassword', 'inputPassword', 'trim|required|xss_clean');
       $this->form_validation->set_rules('inputRegion', 'inputRegion', 'xss_clean');
       $this->form_validation->set_rules('inputEmail', 'inputEmail', 'trim|required|xss_clean');

       if($this->form_validation->run() == FALSE) {
         //Field validation failed.  User redirected to create_user page
         redirect('create_user', 'refresh');
       } else {
         //Create new user
        $firstname = $this->input->post('inputFirstName');
        $surname = $this->input->post('inputSurname');
        $password = $this->input->post('inputPassword');
        $birthdate = $this->input->post('inputYear') . '-' . $this->input->post('inputMonth') . '-' . $this->input->post('inputDay');
        $region = $this->input->post('inputRegion');
        $email = $this->input->post('inputEmail');

        //query the database
        $result = $this->user->create_user($firstname, $surname, $password, $birthdate, $region, $email);

         //Go to private area
         if ($result) {
            login_utility($email = $this->input->post('inputEmail'), $password = $this->input->post('inputPassword'));
            redirect('home', 'refresh');
         } else {
            redirect('welcome', 'refresh');
         }
       }

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
    
    function change_birthdate()
    {
        $aResult = array();

        if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

        if( !isset($aResult['error']) ) {
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $idUser = $_POST['arguments'][0];
                   $newBirthdate = $_POST['arguments'][1];
                   
                   $success = $this->user->change_birthdate($idUser, $newBirthdate);
                   
                   if ($success == 1) {
                       $aResult['result'] = 'success';                       
                       $newSessionData = $this->session->userdata('logged_in');
                       $newSessionData['birthdate'] = $newBirthdate;
                       $this->session->set_userdata('logged_in', $newSessionData);
                       $aResult['newBirthdate'] = $newBirthdate;
                   } else {
                       $aResult['error'] = 'Error in update';
                   }
               }
        }

        echo json_encode($aResult);
    }
    
    function suppress_account()
    {
        $aResult = array();

        if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

        if( !isset($aResult['error']) ) {
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 1 ) ) {
                   $aResult['error'] = 'Error in arguments!';
               } else {
                   $idUser = $_POST['arguments'][0];
                   // The user id must be the same as the one in sessionData
                   if($idUser == $this->session->userdata('logged_in')['id']) {
                       $success = $this->user->suppress_account($idUser);
                       if ($success == 1) {
                           $aResult['result'] = 'success';
                       } else {
                           $aResult['error'] = 'Error in update';
                       }
                   } else {
                       $aResult['error'] = 'Error with the user id';
                   }
               }
        }

        echo json_encode($aResult);
    }
}

?>