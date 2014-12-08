<?php
Class Event extends CI_Model
{

    /*
    * Return created event id.
    */
   function create_event($name, $private, $date, $duration, $place, $region, $activities, $description, $keywords, $checklistItems, $invitationSuggestionAllowed, $individualPropositionSuggestionAllowed, $maxParticipant, $minAge, $inscriptionDeadline, $organizer) {
       //insertion of Event
       $data = array(
           'name' => $name,
           'private' => $private,
           'invitation_suggestion_allowed' =>  $invitationSuggestionAllowed,
           'description' => $description,
           'start_date' => $date,
           'inscription_deadline' => $inscriptionDeadline,
           'duration' => $duration,
           'start_place' => $place,
           'participant_max_nbr' => $maxParticipant,
           'participant_minimum_age' => $minAge,
           'organizer' => $organizer,
           'individual_proposition_suggestion_allowed' => $individualPropositionSuggestionAllowed,
           'region_id' => $region
       );
       
       $this->db->trans_start();
       
       $insertionResult = $this->db->insert('event', $data);
       $eventId = $this->db->insert_id();
       
       //insertion of MandatoryCheckListItems
       if(!empty($checklistItems)) {
           $data = array();
           foreach ($checklistItems as $checklistItem){
               $data[] = array(
                    'content' => $checklistItem,
                    'event_id' => $eventId
               );
           }       
           $insertionResult = $this->db->insert_batch('mandatory_checklist_item', $data);
       }

        //insertion of Activities
       foreach ($activities as $activity){
           $insertionResult = $this->db->query("call insert_activity(" . $eventId . ", '" . $activity . "')");
       }

       //insertion of Keywords
       foreach ($keywords as $keyword){
           $insertionResult = $this->db->query("call insert_keyword(" . $eventId . ", '" . $keyword . "')");
       }

       $this->db->trans_complete();
       
       return $eventId;
    }
    
   function update_event($eventId, $name, $private, $date, $duration, $place, $region, $activities, $description, $keywords, $checklistItems, $invitationSuggestionAllowed, $individualPropositionSuggestionAllowed, $maxParticipant, $minAge, $inscriptionDeadline) {
       //insertion of Event
       $data = array(
           'name' => $name,
           'private' => $private,
           'invitation_suggestion_allowed' =>  $invitationSuggestionAllowed,
           'description' => $description,
           'start_date' => $date,
           'inscription_deadline' => $inscriptionDeadline,
           'duration' => $duration,
           'start_place' => $place,
           'participant_max_nbr' => $maxParticipant,
           'participant_minimum_age' => $minAge,
           'individual_proposition_suggestion_allowed' => $individualPropositionSuggestionAllowed,
           'region_id' => $region
       );
       
       $this->db->trans_start();
       
       $this->db->where('id', $eventId);
       $this->db->update('event', $data);
       
       //insertion of MandatoryCheckListItems
       if(!empty($checklistItems)) {
           $data = array();
           foreach ($checklistItems as $checklistItem){
               $data[] = array(
                    'content' => $checklistItem,
                    'event_id' => $eventId
               );
           }
           $this->db->where('event_id', $eventId);
           $this->db->delete('mandatory_checklist_item');
           
           $insertionResult = $this->db->insert_batch('mandatory_checklist_item', $data);
       }

        //insertion of Activities
       $this->db->where('event_id', $eventId);
       $this->db->delete('activity_specification');
       foreach ($activities as $activity){
           $insertionResult = $this->db->query("call insert_activity(" . $eventId . ", '" . $activity . "')");
       }

       //insertion of Keywords
       $this->db->where('event_id', $eventId);
       $this->db->delete('keyword_specification');
       foreach ($keywords as $keyword){
           $insertionResult = $this->db->query("call insert_keyword(" . $eventId . ", '" . $keyword . "')");
       }

       $this->db->trans_complete();
    }
	
	function get_event($id) {
		$this -> db ->select('event.id AS id, name, private, invitation_suggestion_allowed, description, start_date, inscription_deadline, duration, start_place, participant_max_nbr, participant_minimum_age, organizer, individual_proposition_suggestion_allowed, region.content AS region');
		$this -> db -> from('event');
        $this->db->join('region', 'event.region_id = region.id', 'inner');
		$this -> db -> where('event.id', $id);
     	$this -> db -> limit(1);
		
		$query = $this -> db -> get();

		 if($query -> num_rows() == 1)
		 {
		    return $query->result();
		 }
		 else
		 {
		   return false;
		 }
	}
    
    function get_event_activities($id) {
		
        $this->db->select('content');
        $this->db->from('activity');
        $this->db->join('activity_specification', 'activity_specification.activity_id = activity.id', 'inner');
        $this->db->where('activity_specification.event_id', $id);

        $query = $this->db->get();
        
        return $query->result();
    }
    
    function get_event_keywords($id) {
		
        $this->db->select('content');
        $this->db->from('keyword');
        $this->db->join('keyword_specification', 'keyword_specification.keyword_id = keyword.id', 'inner');
        $this->db->where('keyword_specification.event_id', $id);

        $query = $this->db->get();
        
        return $query->result();
    }
    
    function get_event_participants($id) {
        $this->db->select('firstname, surname');
        $this->db->from('user');
        $this->db->join('participation', 'participation.user_id = user.id', 'inner');
        $this->db->where('participation.event_id', $id);

        $query = $this->db->get();
        
        return $query->result();
    }
    
    function get_event_checklist($id) {
		
        $this->db->select('content');
        $this->db->from('mandatory_checklist_item');
        $this->db->where('event_id', $id);

        $query = $this->db->get();
        
        return $query->result();
    }
    
    function get_visible_events($id_user) {        
        $this->db->query("SET @connected_user_id := " . $id_user);
        
        $this -> db -> select("*");
        $this->db->from("visible_event");
        return $this->db->get()->result();
    }
    

    function join_public_event($id_user, $id_event)
    {
        $query = $this->db->query("call join_public_event(" . $id_user . ", " . $id_event . ")");
        $returnValue = $query->result();
        $this->db->freeDBResource($this->db->conn_id);
        return $returnValue;
    }
    
    function join_private_event($id_user, $id_event)
    {
        $query = $this->db->query("call join_private_event(" . $id_user . ", " . $id_event . ")");
        $returnValue = $query->result();
        $this->db->freeDBResource($this->db->conn_id);
        return $returnValue;
    }
    
    function quit_event($id_user, $id_event) {
       $this->db->where('event_id', $id_event);
       $this->db->where('user_id', $id_user);
       $this->db->delete('participation');
    }
    
    function get_participable_events($id_user, $limit) {
        
        $this->db->query("SET @connected_user_id := " . $id_user);
        
        $this -> db -> select("*");
        $this->db->from("participable_event");
        $this->db->order_by("eventId");
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    

    function is_participation($id_user, $id_event)
    {
        $query = $this->db->query("select is_participation(" . $id_user . ", " . $id_event . ")");
        
        $row = $query->row_array();
        
        return $row["is_participation(" . $id_user . ", " . $id_event . ")"];

    }
    /*
    * we search for the keywords given in the : name, description, start_place, region, activities and keywords of events
    * the searchKeywords can be a part of a word
    * The research is done only on event you can participate to.
    */
    function search_event($id_user, $searchKeywords)
    {        
        $this->db->query("SET @connected_user_id := " . $id_user);
        
        $events = $this->get_visible_events($id_user);
        
        foreach($searchKeywords as $searchKeyword) {
            
            //search for events with their simple attributes
            $this -> db -> select('*');
            $this -> db -> from('visible_event');
            $this -> db -> join('region', 'visible_event.region_id = region.id', 'inner');
            $this -> db -> or_like('name', $searchKeyword);
            $this -> db -> or_like('description', $searchKeyword);
            $this -> db -> or_like('start_place', $searchKeyword);
            $this -> db -> or_like('region.content', $searchKeyword);
            
            $result = $this -> db -> get() -> result();

            //strpos() doesn't like if search needle is empty
            if($searchKeyword != '') {
                foreach($events as $event) {
                    //search for events with their activities
                    $activities = $this->get_event_activities($event->id);
                    foreach($activities as $activity) {
                        if (strpos($activity->content, $searchKeyword) !== false && !in_array($event, $result)) {
                            $result[] = $event;
                            continue 2;
                        }
                    }

                    //search for events with their keywords
                    $keywords = $this->get_event_keywords($event->id);
                    foreach($keywords as $keyword) {
                        if (strpos($keyword->content, $searchKeyword) !== false && !in_array($event, $result)) {
                            $result[] = $event;
                            continue 2;
                        }
                    }
                }

            }        
        }

        return $result;
    }
    
    function get_details($id) {		
        $infoEvent['event'] = $this->event->get_event($id)[0];
        
        $activities = $this->event->get_event_activities($id);
        foreach($activities as $activity) {
            $infoEvent['eventActivities'][] = $activity->content;
        }
        
        $checklist = $this->event->get_event_checklist($id);
        foreach($checklist as $checklistItem) {
            $infoEvent['eventChecklist'][] = $checklistItem->content;
        }
        
        $keywords = $this->event->get_event_keywords($id);
        foreach($keywords as $keyword) {
            $infoEvent['eventKeywords'][] = $keyword->content;
        }
        
        $infoEvent['eventParticipants'] = $this->event->get_event_participants($id);

        return $infoEvent;
    }
    
    function cancel($id) {
        $this->db->where('id', $id);
        $this->db->delete('event');
    }
}
?>