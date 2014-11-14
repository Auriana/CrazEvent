<?php
Class Event extends CI_Model
{

   function create_event($name, $private, $description, $activities, $keywords, $checklistItems, $invitationSuggestionAllowed, $maxParticipant, $minAge, $inscriptionDeadline, $date, $place, $organizer, $duration, $individualPropositionSuggestionAllowed, $region) {
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
       return $this -> db -> insert('event', $data);
       
       //TODO : insertion activities, keywords, checklist
    }
    
}
?>