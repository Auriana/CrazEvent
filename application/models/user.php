<?php
Class User extends CI_Model
{
 function login($email, $password)
 {
     $this->db->select('user.id, email, firstname, surname, region.content AS region, birthdate');
     $this->db->from('user');
     $this->db->join('region', 'region.id = user.region_id', 'inner');
     $this->db->where('email', $email);
     $this->db->where('password', MD5($password));
     $this->db->where('active', 1);
     $this->db->limit(1);

     $query = $this->db->get();

     if($query->num_rows() == 1)
     {
       return $query->result();
     }
     else
     {
       return false;
     }
   }

   function create_user($firstname, $surname, $password, $birthdate, $region, $email)
   {
       $data = array(
           'firstname' => $firstname,
           'surname' => $surname,
           'password' => MD5($password),
           'birthdate' => $birthdate,
           'region_id' => $region,
           'email' => $email
       );
       return $this->db->insert('user', $data);
    }

    function search_user($firstname, $surname, $region)
    {
        $this->db->select('user.id, email, firstname, surname, region.content AS region');
        $this->db->from('user');
        $this->db->join('region', 'region.id = user.region_id', 'inner');
        $this->db->like('firstname', $firstname);
        $this->db->like('surname', $surname);
        $this->db->like('region.content', $region);
        $this->db->where('active', 1);
        
        $query = $this->db->get();

        return $query->result();
    }
    
    function add_contact($id_user, $id_contact)
    {
        $query = $this->db->query("call add_friendship(" . $id_user . ", " . $id_contact . ")");

        return $query->result();
    }
    
    function is_friend($id_user, $id_contact)
    {
        $query = $this->db->query("select is_friendship(" . $id_user . ", " . $id_contact . ")");
        
        $row = $query->row_array();
        
        return $row["is_friendship(" . $id_user . ", " . $id_contact . ")"];

    }
    
    function change_firstname($id_user, $newFirstname)
    {
        $data = array(
            'firstname' => $newFirstname
        );
        $this->db->where('id', $id_user);
        $this->db->update('user', $data);
        // if the update is successful, return 1
        return $this->db->affected_rows();
    }
    
    function change_surname($id_user, $newSurname)
    {
        $data = array(
            'surname' => $newSurname
        );
        $this->db->where('id', $id_user);
        $this->db->update('user', $data);
        // if the update is successful, return 1
        return $this->db->affected_rows();
    }
    
    function change_password($id_user, $newPassword)
    {
        $data = array(
            'password' => MD5($newPassword)
        );
        $this->db->where('id', $id_user);
        $this->db->update('user', $data);
        // if the update is successful, return 1
        return $this->db->affected_rows();
    }
    
    function change_region($id_user, $newRegion)
    {
        $data = array(
            'region_id' => $newRegion
        );
        $this->db->where('id', $id_user);
        $this->db->update('user', $data);
        // if the update is successful, return 1
        return $this->db->affected_rows();
    }
    
    function change_birthdate($id_user, $newBirthdate)
    {
        $data = array(
            'birthdate' => $newBirthdate
        );
        $this->db->where('id', $id_user);
        $this->db->update('user', $data);
        // if the update is successful, return 1
        return $this->db->affected_rows();
    }
    
    function suppress_account($id_user)
    {
        $data = array(
            'active' => 0
        );
        $this->db->where('id', $id_user);
        $this->db->update('user', $data);
        // if the update is successful, return 1
        return $this->db->affected_rows();
    }
    
    /*
    * get events of a month where user is a participant
    */
    function get_registered_event_of_month($id_user, $month, $year) {
        $this->db->select('*');
        $this->db->from('participation');
        $this->db->join('event', 'participation.event_id = event.id', 'inner');
        $this->db->where('participation.user_id', $id_user);
        $this->db->where('MONTH(start_date)', $month);
        $this->db->where('YEAR(start_date)', $year);
        $this->db->order_by('start_date', 'asc');
        return $this->db->get()->result();
    }
    
    /*
    * get events where user is a participant and are not in the past
    */
    function get_registered_event($id_user, $limit) {
        $this->db->select('*');
        $this->db->from('participation');
        $this->db->join('event', 'participation.event_id = event.id', 'inner');
        $this->db->where('participation.user_id', $id_user);
        $this->db->where('start_date >= NOW()');
        $this->db->order_by('start_date', 'asc');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}
?>