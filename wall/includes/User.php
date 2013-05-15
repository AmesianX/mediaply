<?php
//Srinivas Tamada http://9lessons.info
//User

class User 
{




      public function User_Login($username,$password) 
     {
     $username=mysql_real_escape_string($username);
     $password=mysql_real_escape_string($password);
     $md5_password=md5($password);
     $query=mysql_query("SELECT uid FROM users WHERE username='$username' and password='$md5_password' AND status='1'");
     if(mysql_num_rows($query)==1)
     {
     $row=mysql_fetch_array($query);
     return $row['uid'];
     }
     else
     {
     return false;
     }
     }

     public function User_Registration($username,$password,$email) 
     {
     $username=mysql_real_escape_string($username);
     $email=mysql_real_escape_string($email);
     $password=mysql_real_escape_string($password);
     $md5_password=md5($password);

     $q=mysql_query("SELECT uid FROM users WHERE username='$username' or email='$email' ");
     
     if(mysql_num_rows($q)==0)
     {

     $query=mysql_query("INSERT INTO users(username,password,email)VALUES('$username','$md5_password','$email')");
       
     $sql=mysql_query("SELECT uid FROM users WHERE username='$username'");
     $row=mysql_fetch_array($sql);
     $uid=$row['uid'];
     $friend_query=mysql_query("INSERT INTO friends(friend_one,friend_two,role)VALUES('$uid','$uid','me')");

     return $uid ;
    

     }
     else
     {
     return false;
     }



     }
    

	
     
    

}

?>
