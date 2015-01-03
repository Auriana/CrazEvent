<?php
Class Event extends CI_Model {

    /**
    * Creation of an event in the database
    * Return created event id.
    */
   function create_event($name, $private, $date, $duration, $place, $region, $activities, $description, $keywords, $checklistItems, $individualPropositions, $invitationSuggestionAllowed, $individualPropositionSuggestionAllowed, $maxParticipant, $minAge, $inscriptionDeadline, $organizer) {
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
       
      //insertion of individual propositions
       if(!empty($individualPropositions)) {
           $data = array();
           foreach ($individualPropositions as $individualProposition){
               $data[] = array(
                    'content' => $individualProposition,
                    'event_id' => $eventId
               );
           }       
           $insertionResult = $this->db->insert_batch('individual_proposition', $data);
       }

        //insertion of Activities
       foreach ($activities as $activity){
          $insertionResult = $this->db->query("call insert_activity(?,?)", array($eventId, $activity));
       }

       //insertion of Keywords
       foreach ($keywords as $keyword){
          $insertionResult = $this->db->query("call insert_keyword(?,?)", array($eventId, $keyword));
       }

       $this->db->trans_complete();
       
       return $eventId;
    }

    /**
    * Modification of an event in the database
    */
   function update_event($eventId, $name, $private, $date, $duration, $place, $region, $activities, $description, $keywords, $checklistItems,  $individualPropositions, $invitationSuggestionAllowed, $individualPropositionSuggestionAllowed, $maxParticipant, $minAge, $inscriptionDeadline) {
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
       $this->db->where('event_id', $eventId);
       $this->db->delete('mandatory_checklist_item');
       if(!empty($checklistItems)) {
           $data = array();
           foreach ($checklistItems as $checklistItem) {
               $data[] = array(
                    'content' => $checklistItem,
                    'event_id' => $eventId
               );
           }           
           $insertionResult = $this->db->insert_batch('mandatory_checklist_item', $data);
       }
       
        //insertion of individual propositions
       $this->db->where('event_id', $eventId);
       $this->db->delete('individual_proposition');
       
       if(!empty($individualPropositions)) {
           $data1 = array();
           $data2 = array();
           foreach ($individualPropositions as $individualProposition) {
               
               if(isset($individualProposition['user_dealing_with_it'])) {
                   $data1[] = array(
                    'content' => $individualProposition['content'],
                    'event_id' => $eventId,
                    'user_dealing_with_it' => $individualProposition['user_dealing_with_it']
                    );
               } else {
                   $data2[] = array(
                        'content' => $individualProposition['content'],
                        'event_id' => $eventId
                   );
               }
                  
           }
           if(!empty($data1)) {
            $insertionResult = $this->db->insert_batch('individual_proposition', $data1);
           }
           if(!empty($data2)) {
            $insertionResult = $this->db->insert_batch('individual_proposition', $data2);
           }
       }

        //insertion of Activities
       $this->db->where('event_id', $eventId);
       $this->db->delete('activity_specification');
       foreach ($activities as $activity) {
           $insertionResult = $this->db->query("call insert_activity(?,?)", array($eventId, $activity));
       }

       //insertion of Keywords
       $this->db->where('event_id', $eventId);
       $this->db->delete('keyword_specification');
       foreach ($keywords as $keyword) {
           $insertionResult = $this->db->query("call insert_keyword(?,?)", array($eventId, $keyword));
       }

       $this->db->trans_complete();
    }
	
    /**
    * Search an event in the database
    * parameters :
    *   id : event to find's id
    * Return the infos about the event or false.
    */
	function get_event($id) {
		$this -> db ->select('event.id AS id, name, private, invitation_suggestion_allowed, description, start_date, inscription_deadline, duration, start_place, participant_max_nbr, participant_minimum_age, organizer, individual_proposition_suggestion_allowed, region.content AS region');
		$this -> db -> from('event');
        $this->db->join('region', 'event.region_id = region.id', 'inner');
		$this -> db -> where('event.id', $id);
     	$this -> db -> limit(1);
		
		$query = $this -> db -> get();

		 if($query -> num_rows() == 1) {
		    return $query->result()[0];
		 } else {
		   return false;
		 }
	}
    
    /**
    * Search the activities of an event in the database
    * parameters :
    *   id : event's activities to find's id
    * Return the activities of the event.
    */
    function get_event_activities($id) {
		
        $this->db->select('content');
        $this->db->from('activity');
        $this->db->join('activity_specification', 'activity_specification.activity_id = activity.id', 'inner');
        $this->db->where('activity_specification.event_id', $id);

        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
    * Search the keywords of an event in the database
    * parameters :
    *   id : event's keywords to find's id
    * Return the keywords of the event.
    */
    function get_event_keywords($id) {
		
        $this->db->select('content');
        $this->db->from('keyword');
        $this->db->join('keyword_specification', 'keyword_specification.keyword_id = keyword.id', 'inner');
        $this->db->where('keyword_specification.event_id', $id);

        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
    * Search the participants of an event in the database
    * parameters :
    *   id : event's participants to find's id
    * Return the participants of the event.
    */
    function get_event_participants($id) {
        $this->db->select('id, firstname, surname');
        $this->db->from('user');
        $this->db->join('participation', 'participation.user_id = user.id', 'inner');
        $this->db->where('participation.event_id', $id);

        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
    * Search the guests of an event in the database
    * parameters :
    *   id : event's guests to find's id
    * Return the guests of the event.
    */
    function get_event_guests($id) {
        $this->db->select('id, firstname, surname');
        $this->db->from('user');
        $this->db->join('invitation', 'invitation.user_id = user.id', 'inner');
        $this->db->where('invitation.event_id', $id);

        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
    * Search the checklist items of an event in the database
    * parameters :
    *   id : event's checklist items to find's id
    * Return the checklist items of the event.
    */
    function get_event_checklist($id) {
		
        $this->db->select('content');
        $this->db->from('mandatory_checklist_item');
        $this->db->where('event_id', $id);

        $query = $this->db->get();
        
        return $query->result();
    }
        
    /**
    * Search the individual propositions of an event in the database
    * parameters :
    *   id : event's individual propositions to find's id
    * Return the individual propositions of the event.
    */
    function get_event_individual_propositions($id) {
		
        $this->db->select('individual_proposition.id as individual_proposition_id, content, user_dealing_with_it, firstname, surname');
        $this->db->from('individual_proposition');
        $this->db->join('user', 'individual_proposition.user_dealing_with_it = user.id', 'left');
        $this->db->where('event_id', $id);

        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
    * Join a public event.
    * parameters :
    *   id_user : id of the user that join the event
    *   $id_event : id of the event to join
    * Return result of the joining
    */
    function join_public_event($id_user, $id_event) {
        $query = $this->db->query("call join_public_event(?,?)", array($id_user, $id_event));
        $returnValue = $query->result();
        $this->db->freeDBResource($this->db->conn_id);
        return $returnValue;
    }
    
    /**
    * Join a private event.
    * parameters :
    *   id_user : id of the user that join the event
    *   $id_event : id of the event to join
    * Return result of the joining
    */
    function join_private_event($id_user, $id_event) {
        $query = $this->db->query("call join_private_event(?,?)", array($id_user, $id_event));
        $returnValue = $query->result();
        $this->db->freeDBResource($this->db->conn_id);
        return $returnValue;
    }
    
    /**
    * Quit an event
    * parameters :
    *   id_user : id of the user that quit the event
    *   $id_event : id of the event to quit
    */
    function quit_event($id_user, $id_event) {
       $this->db->where('event_id', $id_event);
       $this->db->where('user_id', $id_user);
       $this->db->delete('participation');
        print_r("event " . $id_event);
       $this->db->query('UPDATE individual_proposition SET user_dealing_with_it = NULL WHERE user_dealing_with_it = ? AND event_id = ?', array($id_user, $id_event));
    }
    
    function send_invitation($id_user, $id_event) {
       $data = array(
           'user_id' => $id_user,
           'event_id' => $id_event
       );
       $insertionResult = $this->db->insert('invitation', $data);
       return $insertionResult;
    }
    
    /**
    * Search the events visible by the connected user
    * parameters :
    *   id_user : id of the connected user
    * Return the events visible by the connected user
    */
    function get_visible_events($id_user) {
        $this->db->query("SET @connected_user_id := ?", array($id_user));
        
        $this -> db -> select("*");
        $this->db->from("visible_event");
        return $this->db->get()->result();
    }

    /**
    * Search the events participable by the connected user
    * parameters :
    *   id_user : id of the connected user
    *   limit : number of result to return
    * Return the events participable by the connected user
    */
    function get_participable_events($id_user, $limit) {
        $this->db->query("SET @connected_user_id := ?", array($id_user));
        
        $this -> db -> select("*");
        $this->db->from("participable_event");
        $this->db->order_by("eventId");
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    
    /**
    * parameters :
    *   id_user : id of the user
    *   id_event : id of the event
    * Return 1 if the user participate to the event, else 0
    */
    function is_participation($id_user, $id_event) {
        $query = $this->db->query("select is_participation(?,?)", array($id_user, $id_event));
        
        $row = $query->row_array();
        
        return $row["is_participation('" . $id_user . "','" . $id_event . "')"];

    }
    /*
    * Search for the keywords given in the : name, description, start_place, region, activities and keywords of events.
    * The searchKeywords can be a part of a word.
    * The research is done only on event you can view to.
    * parameters :
    *   id_user : id of the connected user
    *   searchKeywords : keywords used in the search
    * return events that have at least 1 searchKeyowrd in them
    */
    function search_event($id_user, $searchKeywords) {        
        $this->db->query("SET @connected_user_id := ?", array($id_user));
        
        $this -> db -> select('*');
        $this -> db -> from('visible_event');
        $this -> db -> join('region', 'visible_event.region_id = region.id', 'inner');
        $allEvents = $this -> db -> get() -> result();
        
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
                foreach($allEvents as $event) {
                    //search for events with their activities
                    $activities = $this->get_event_activities($event->eventId);
                    foreach($activities as $activity) {
                        if (strpos($activity->content, $searchKeyword) !== false && !in_array($event, $result)) {
                            $result[] = $event;
                            continue 2;
                        }
                    }

                    //search for events with their keywords
                    $keywords = $this->get_event_keywords($event->eventId);
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
    
    /**
    * Get all the details of an event.
    * parameters :
    *   id : id of the event
    * return : array with event basic infos from get_event() plus activities, checklist, individual propositions, keywords, participants, guests
    */
    function get_details($id) {
        $infoEvent['event'] = $this->event->get_event($id);
        
        $activities = $this->event->get_event_activities($id);
        foreach($activities as $activity) {
            $infoEvent['eventActivities'][] = $activity->content;
        }
        
        $checklist = $this->event->get_event_checklist($id);
        foreach($checklist as $checklistItem) {
            $infoEvent['eventChecklist'][] = $checklistItem->content;
        }
        
        $individualPropositions = $this->event->get_event_individual_propositions($id);
        foreach($individualPropositions as $individualProposition) {
            $infoEvent['eventIndividualPropositions'][] = $individualProposition;
        }
        
        $keywords = $this->event->get_event_keywords($id);
        foreach($keywords as $keyword) {
            $infoEvent['eventKeywords'][] = $keyword->content;
        }
                
        $infoEvent['eventParticipants'] = $this->event->get_event_participants($id);
        
        $infoEvent['eventGuests'] = $this->event->get_event_guests($id);

        return $infoEvent;
    }
    
    /**
    * Cancel an event
    *   id : id of the event
    */
    function cancel($id) {
        $this->db->where('id', $id);
        $this->db->delete('event');
    }
    
    /**
    * Return true if a user is in charge of the individual proposition.
    *   id : id of the IndividualProposition
    */
    function is_individual_proposition_dealt_with($id) {
        $this->db->from('individual_proposition');
        $this->db->where('id',$id);
        $this->db->where('user_dealing_with_it IS NOT NULL', null, false);
        
        $query = $this -> db -> get();

		return $query -> num_rows() == 1;
    }
    
    /**
    * Add an individual proposition to the event
    *   id : id of the event
    *   individualProposition : content to add
    * return : id of inserted individual proposition
    */
    function add_individual_proposition($id, $individualProposition) {
       $data = array(
           'content' => $individualProposition,
           'event_id' => $id
       );
       
       $this->db->trans_start();
       
       $insertionResult = $this->db->insert('individual_proposition', $data);
       $propositionId = $this->db->insert_id();
        
       $this->db->trans_complete();
        
       return $propositionId;
    }
}
?>