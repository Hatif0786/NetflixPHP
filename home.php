<?php
require "backend/init.php";
if(isset($_SESSION['userLoggedIn'])){
     $user_id=$_SESSION['userLoggedIn'];
} else if(Login::isLoggedIn()){
     $user_id=Login::isLoggedIn();
     $status=$loadFromUser->get("token",["status"],['user_id'=>$user_id]);
     if($status['status']==1){
          $user_id=Login::isLoggedIn();
     }
     else{
          redirect_to(url_for("verification"));
     }
} else{
    redirect_to(url_for('index'));
 }
