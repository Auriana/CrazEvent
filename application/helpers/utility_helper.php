<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if ( ! function_exists('asset_url')) {
	function asset_url()
	{
		return base_url().'assets/';
	}
}

if ( ! function_exists('login')) {
    function login($email, $password) {
         
        // Get a reference to the controller object
        $CI = get_instance();
        $CI->load->model('user','',TRUE);

        //query the database
        $result = $CI->user->login($email, $password);

        if ($result) {
            //create the session variable
            $sess_array = array();
            foreach($result as $row) {
                $sess_array = array(
                    'id' => $row->id,
                    'email' => $row->email,
                    'firstname' => $row->firstname,
                    'surname' => $row->surname
                );
                $CI->session->set_userdata('logged_in', $sess_array);
            }
        }

        //TODO return error if fails

        return $result;
	}
}

if ( ! function_exists('get_new_events')) {
    function get_new_events() {
         
        // Get a reference to the controller object
        $CI = get_instance();
        $CI->load->model('event','',TRUE);

        //query the database
        $result = $CI->event->get_new_events();
        $events_infos = "";
        if ($result) {
            foreach($result as $row) {
                $events_infos = $events_infos . "<li><a class='event-link' href='details_event/index/" . $row -> id . "'>" . $row -> name . "</a></li>";
            }
        }

        return $events_infos;
	}
}

?>