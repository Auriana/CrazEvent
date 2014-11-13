<?php
Class User extends CI_Model
{
 function login($email, $password)
 {
     $this -> db -> select('id, email, firstname, surname');
     $this -> db -> from('user');
     $this -> db -> where('email', $email);
     $this -> db -> where('password', MD5($password));
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

   function create_user($firstname, $surname, $password, $birthdate, $region, $email)
   {
       $data = array(
           'firstname' => $firstname,
           'surname' => $surname,
           'password' => MD5($password),
           'birthdate' => $birthdate,
           'region' => $region,
           'email' => $email,
           'is_admin' => false
       );
       return $this -> db -> insert('user', $data);
    }

    function search_user($firstname, $surname, $region)
    {
        $this -> db -> select('id, email, firstname, surname, region');
        $this -> db -> from('user');
        $this -> db -> like('firstname', $firstname);
        $this -> db -> like('surname', $surname);
        $this -> db -> like('region', $region);
        
        $query = $this -> db -> get();

        return $query->result();
    }
    
}
?>