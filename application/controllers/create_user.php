<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Create_User extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

 function index()
 {
   $this->load->helper(array('form'));
   $this->load->view('create_user_view');
 }

}

?>