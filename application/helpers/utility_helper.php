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
                    'surname' => $row->surname,
                    'region' => $row->region,
                    'birthdate' => $row->birthdate
                );
                $CI->session->set_userdata('logged_in', $sess_array);
                
                //parametrize database
                $CI->db->query("SET @connected_user_id := " . $row->id);
            }
        }

        //TODO return error if fails

        return $result;
	}
}



/*
* Sélectionner les 10 derniers nouveaux évènements 
*/
if ( ! function_exists('get_new_events')) {
    function get_new_events($id_user) {
         
        // Get a reference to the controller object
        $CI = get_instance();
        $CI->load->model('event','',TRUE);

        //query the database
        $result = $CI->event->get_participable_events($id_user, 10);
        $eventsInfos = "";
        if ($result) {
            foreach($result as $row) {
                $eventsInfos .= "<li><a class='event-link' href='details_event/index/" . $row->eventId . "'>" . $row->name . "</a></li>";
            }
        }

        return $eventsInfos;
	}
}

if ( ! function_exists('get_my_events')) {
    function get_my_events($id_user) {
         
        // Get a reference to the controller object
        $CI = get_instance();
        $CI->load->model('user','',TRUE);

        //query the database
        $result = $CI->user->get_registered_event($id_user, 10);
        $eventsInfos = "";
        if ($result) {
            foreach($result as $row) {
                $eventsInfos .= "<li><a class='event-link' href='details_event/index/" . $row->id . "'>" . $row->name . "</a></li>";
            }
        }

        return $eventsInfos;
	}
}

if ( ! function_exists('get_region_scrollbox')) {
    function get_region_scrollbox() {
        return get_region_scrollbox_with_selected("");
	}
    function get_region_scrollbox_with_selected($selectedRegionContent) {
                 
        // Get a reference to the controller object
        $CI = get_instance();
        
        //query the database
        $CI->db->select('*');
        $CI->db->from('region');
        $result = $CI->db->get()->result();
        $regionList = "";
        if ($result) {
            foreach($result as $row) {
                if(strcmp($row->content,$selectedRegionContent) == 0) {
                    $regionList .= '<option value="'.$row->id .'" selected>'. $row->content .'</option>';
                } else {
                    $regionList .= '<option value="'.$row->id .'">'. $row->content .'</option>';
                }
            }
        }
        return $regionList;
    }
}
?>