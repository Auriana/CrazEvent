<?php
Class Event extends CI_Model
{

   function create_event($name, $private, $description, $activities, $keywords, $checklistItems, $invitationSuggestionAllowed, $maxParticipant, $minAge, $inscriptionDeadline, $date, $place, $organizer, $duration, $individualPropositionSuggestionAllowed, $region) {
       //insertion of Event
       $data = array(
           'name' => $eventName,
           'private' => $eventPrivate,
           'invitation_suggestion_allowed' =>  $invitationSuggestionAllowed,
           'description' => $description,
           'start_date' => $date,
           'inscription_deadline' => $inscriptionDeadline,
           'duration' => $duration,
           'start_place' => $place,
           'participant_max_nbr' => $maxParticipant,
           'participant_minimumAge' => $minAge,
           'organizer' => $organizer,
           'individual_proposition_suggestion_allowed' => $individualPropositionSuggestionAllowed,
           'region' => $region
       );
       $insertionResult = $this -> db -> insert('event', $data);
       $eventId = $this->db->insert_id();
       
        //insertion of MandatoryCheckListItems
       if($insertionResult == true) {
           $data = array();
           foreach ($checklistItems as $checklistItem){
               $data[] = array(
                    'content' => $checklistItem,
                    'event_id' => $eventId
               );
           }
           $insertionResult = $this -> db -> insert_batch('mandatory_checklist_item', $data);

            //insertion of Activities
           if($insertionResult == true) {
               $data = array();
               foreach ($checklistItems as $checklistItem){
                   $data[] = array(
                        'activity_id' => ,
                        'event_id' => $eventId
                   );
               }
               $insertionResult = $this -> db -> insert_batch('activity_specification', $data) == FALSE) {
           }
       }
       
       return $insertionResult;
       //TODO : insertion activities, keywords, checklist
    }
    
}
?>