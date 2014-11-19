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
               if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                   $aResult['error'] = 'Error in arguments!';
               }
               else {
                   $id_user = $_POST['arguments'][0];
                   $id_event = $_POST['arguments'][1];
                   
                   $result = $this->event->join_event($id_user, $id_event);
                   
                   $aResult['result'] = 'success';
               }
        }

        echo json_encode($aResult);
    }
}

?>