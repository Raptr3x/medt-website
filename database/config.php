<?php

// $sub = explode(".", $_SERVER['HTTP_HOST'])[0];
// echo $sub;

global $servername, $username, $password, $dbname;



// // local
//  $servername = "127.0.0.1";
//  $username = "root";
//  $password = "";
//  $dbname = "lunibo";

// raspberry
$servername = "192.168.0.220";
$username = "pi";
$password = "raspberry";
$dbname = "lunibo";
// if($sub=="www"){
//     // hosting
//     $servername = "localhost";
//     $username = "u204111db1";
//     $password = "0kwzrpxsudr";
//     $dbname = "u204111db1";
// }    
// else if($sub=="dev"){
//     $servername = "localhost";
//     $username = "u204111db1";
//     $password = "0kwzrpxsudr";
//     $dbname = "u204111db1";
// }
// else{
//     // local
//     $servername = "127.0.0.1";
//     $username = "root";
//     $password = "";
//     $dbname = "lunibo";
//     // remote
//     // $servername = "e135456-phpmyadmin.services.easyname.eu";
//     // $username = "u204111db1";
//     // $password = "0kwzrpxsudr";
//     // $dbname = "u204111db1";
// }

// echo DBPREFIX;

?>