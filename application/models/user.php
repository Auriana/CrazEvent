<?php
Class User extends CI_Model
{
 function login($email, $password)
 {
   $this -> db -> select('id, email, firstname, surname');
   $this -> db -> from('users');
   $this -> db -> where('email', $email);
   $this -> db -> where('password', $password);
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
  
    /*
 function creat_user($username, $password, $birthdate, $city, $email)
 {
     $data = array(
         'username' => $username,
         'password' => $password,
         'birthdate' => $birthdate,
         'city' => $city,
         'email' => $email
     );
     $query = $this -> db -> insert($data);
     
     if($query -> num_rows() == 1)
     {
        return $query->result();
     }
     else
     {
         return false;
     }
  } */
     
    function create_user($username, $password)
 {
     $data = array(
         'username' => $username,
         'password' => $password
     );
     $query = $this -> db -> insert('users', $data);
     
     if($query == TRUE)
     {
        return true;
     }
     else
     {
         return false;
     }
  }
}
?>