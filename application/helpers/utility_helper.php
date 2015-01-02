<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if ( ! function_exists('asset_url')) {
	function asset_url()
	{
		return base_url().'assets/';
	}
}

/**
* Log in a user.
* Create a codeIgniter session array containing the logged user's infos.
* return : success of logging in.
*/
if ( ! function_exists('login_utility')) {
    function login_utility($email, $password) {
         
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
                //$CI->db->query("SET @connected_user_id := " . $row->id);
                $CI->db->query("SET @connected_user_id := ?", array($row->id));
            }
        }

        //TODO return error if fails

        return $result;
	}
}



/**
* Select 10 last new events that a user can participate to.
* return : display list of the events.
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

/**
* Select 10 last events that a user participate to.
* return : display list of the events.
*/
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






/**
* Select the current events that a user organizes.
* return : display list of the events.
*/
if ( ! function_exists('get_my_created_events')) {
    function get_my_created_events($id_user) {
         
        // Get a reference to the controller object
        $CI = get_instance();
        $CI->load->model('user','',TRUE);

        //query the database
        $result = $CI->user->get_actual_organized_event($id_user, 10);
        $eventsInfos = "";
        if ($result) {
            foreach($result as $row) {
                $eventsInfos .= "<li><a class='event-link' href='details_event/index/" . $row->id . "'>" . $row->name . "</a></li>";
            }
        }

        return $eventsInfos;
	}
}





/**
* return : a link to handle user participation to an event.
*/
if ( ! function_exists('get_participation_link')) {
    function get_participation_link($id_user, $id_event, $private) {
         
        // Get a reference to the controller object
        $CI = get_instance();
        $CI->load->model('user','',TRUE);
        $CI->load->model('event','',TRUE);

        $participationLink = "";        
        if ($CI->event->is_participation($id_user, $id_event) == 0) {
            if ($private == 1) {
                $participationLink = '<a id="joinEvent" href="#" onClick="joinEvent(' . $id_event . ', 1)" alt="">Répondre à l\'invitation</a>';
            } else {
                $participationLink = '<a id="joinEvent" href="#" onClick="joinEvent(' . $id_event . ', 0)" alt="">S\'inscrire</a>';
            }
        } else {
            $participationLink = '<p>Vous êtes inscrit <a id="quitEvent" href="#" onClick="quitEvent(' . $id_user . ', ' . $id_event . ', ' . $private . ')" alt="">(se désinscrire)</a></p>';
        }
        return $participationLink;
    }
}

if ( ! function_exists('get_region_scrollbox')) {
    /**
    * return : a display scrollbox of the available regions
    */
    function get_region_scrollbox() {
        return get_region_scrollbox_with_selected("");
	}
    /**
    * parameters :
    *   selectedRegionContent : the value of the content to be selected by default by the scrollbox
    * return : a display scrollbox of the available regions. The default selected region is parametrize
    */
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

if ( ! function_exists('send_notification')) {
    function send_notification($subject, $message, $senderUserId, $recipientUserId, $emailRequired) {
        $CI = get_instance();
        $CI->load->model('user','',TRUE);
        
        $CI->user->send_message($subject, $message, $senderUserId, $recipientUserId);
            
        if($emailRequired == true) {
            $recipientUser = $CI->user->get_user($recipientUserId);
            
            $CI->load->library('email');

            // Get full html:
            $body =
            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>'.htmlspecialchars($subject, ENT_QUOTES, $CI->email->charset).'</title>
                <style type="text/css">
                    body {
                        font-family: Arial, Verdana, Helvetica, sans-serif;
                        font-size: 16px;
                    }
                </style>
            </head>
            <body>
            '.$message.'
            </body>
            </html>';

            $result = $CI->email
                ->from('crazevent.info@gmail.com')
                ->to($recipientUser->email)
                ->subject($subject)
                ->message($body)
                ->send();
        }
    }
}
?>