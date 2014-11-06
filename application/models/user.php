<?php
Class User extends CI_Model
{
 function login($email, $password)
 {
   $this -> db -> select('id, email, first_name, surname');
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
         'first_name' => $firstname,
         'surname' => $surname,
         'password' => MD5($password),
         'birthdate' => $birthdate,
         'region' => $region,
         'email' => $email,
         'is_admin' => false
     );
     $query = $this -> db -> insert('user', $data);
     
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