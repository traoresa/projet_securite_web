<?php

function est_connecter(): bool{

    if (session_status() === PHP_SESSION_NONE){
        session_start();
    }
    return !empty($_SESSION["connecter"]);

}
function force_user_est_connecter():void {
if(!est_connecter()){
    header("Location: ./login.php");
    exit();

}
     
}

?>