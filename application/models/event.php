<?php
Class Event extends CI_Model
{

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
           'region' => $region
       );
       
       $this->db->trans_start();
       
       $insertionResult = $this->db->insert('event', $data);
       $eventId = $this->db->insert_id();
       
       //insertion of MandatoryCheckListItems
       $data = array();
       foreach ($checklistItems as $checklistItem){
           $data[] = array(
                'content' => $checklistItem,
                'event_id' => $eventId
           );
       }       
       $insertionResult = $this->db->insert_batch('mandatory_checklist_item', $data);

        //insertion of Activities
       foreach ($activities as $activity){
           $insertionResult = $this->db->query("call insert_activity(" . $eventId . ", '" . $activity . "')");
       }

       //insertion of Keywords
       foreach ($keywords as $keyword){
           $insertionResult = $this->db->query("call insert_keyword(" . $eventId . ", '" . $keyword . "')");
       }

       $this->db->trans_complete();
       
       return $insertionResult; //TODO : je sais pas si on retourne true ou false
    }
    
    function get_new_events() {
        $this -> db -> select('id, name');
        $this -> db -> from('event');
        
        $query = $this -> db -> get();

        return $query->result();
    }
}
?>