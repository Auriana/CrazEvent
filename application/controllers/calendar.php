<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendar extends CI_Controller {

    function __construct()
    {
         parent::__construct();
        $this->load->model('user','',TRUE);
    }
    
    function index()
    {
        //if user is not logged in : redirection to welcome page
        if($this->session->userdata('logged_in')) //TODO : moyen sûr de check login ?
        {
            $data['title'] = 'Agenda';
            if($this->input->post('inputMonth') != false && $this->input->post('inputYear') != false) {
                $data['selectedMonth'] = $this->input->post('inputMonth');
                $data['selectedYear'] = $this->input->post('inputYear'); 
            } else {
                $data['selectedMonth'] = date("n");
                $data['selectedYear'] = date("Y");
            }
            $data['calendar'] = $this->draw_calendar($data['selectedMonth'],$data['selectedYear']);

            $this->load->helper(array('form'));
            $this->load->view('templates/header_logged_in', $data);
            $this->load->view('pages/calendar_view', $data);
            $this->load->view('templates/footer');
        }
        else
        {  
            redirect('welcome', 'refresh');
        }
    }
    
        /* draws a calendar */
    function draw_calendar($month,$year){
        
        $currentYear = date("Y");
        $currentMonth = date("n");
        $currentDay = date("d");
        
        //get user's event for the month
        $events = $this->user->get_registered_event($this->session->userdata('logged_in')["id"],$month,$year);
        

        /* draw table */
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

        /* table headings */
        $headings = array('Dimance','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');
        $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

        /* days and weeks vars now ... */
        $running_day = date('w',mktime(0,0,0,$month,1,$year));
        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();

        /* row for week one */
        $calendar.= '<tr class="calendar-row">';

        /* print "blank" days until the first of the current week */
        for($x = 0; $x < $running_day; $x++):
            $calendar.= '<td class="calendar-day-np"> </td>';
            $days_in_this_week++;
        endfor;

        /* keep going with days.... */
        for($list_day = 1; $list_day <= $days_in_month; $list_day++):
            if($year == $currentYear && $month == $currentMonth && $list_day == $currentDay) {
                $calendar.= '<td class="calendar-day-current">';
            } else {
                $calendar.= '<td class="calendar-day">';
            }
                /* add in the day number */
                $calendar.= '<div class="day-number">'.$list_day.'</div>';

                //display user's event for the day
                foreach($events as $eventKey => $event) {
                    $eventDate = new DateTime($event->start_date);
                    $eventDay = intval(date_format($eventDate, 'd'));
                    if($eventDay > $list_day) {
                        break;
                    } else {
                        $eventTime = date_format($eventDate, 'H:i');
                        $calendar.= '<p><a href="details_event/index/'.$event->id.'">'.$eventTime.' : '.$event->name.'</a></p>';
                        unset($events[$eventKey]);
                    }
                }

            $calendar.= '</td>';
            if($running_day == 6):
                $calendar.= '</tr>';
                if(($day_counter+1) != $days_in_month):
                    $calendar.= '<tr class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++; $running_day++; $day_counter++;
        endfor;

        /* finish the rest of the days in the week */
        if($days_in_this_week < 8):
            for($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar.= '<td class="calendar-day-np"> </td>';
            endfor;
        endif;

        /* final row */
        $calendar.= '</tr>';

        /* end the table */
        $calendar.= '</table>';

        /* all done, return result */
        return $calendar;
    }
}

?>