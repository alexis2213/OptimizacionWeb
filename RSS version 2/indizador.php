<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include("db.php");
require_once 'PHP/simplepie-1.5/autoloader.php';
$db = new conexion();
$conexion = $db->dbConexion();


 $query =  "SELECT URLS FROM urls"; 
   $resultado = $conexion->query($query);
   
  $nConfig = mysqli_num_rows($resultado);  

  if ($nConfig > 0) {  
            for ($i=0; $i<$nConfig; $i++){  
                $verConfig = mysqli_fetch_array($resultado);  
                $CargaConfig[$i] = $verConfig["URLS"];      
                   $CargaConfigVal[$CargaConfig[$i]] = $verConfig["URLS"];
            }    
          
        }  
     
        indizar();

function indizar() {
    global $CargaConfigVal, $db, $conexion;
    foreach ($CargaConfigVal as $direccion) {
        $url = $direccion;
        $feed = new SimplePie();
        $feed->set_feed_url($url);
        $feed->init();
        foreach ($feed->get_items(0, 0) as $item) {
            
            if ($item->get_link() != null) {
                $link = $item->get_link();
            } else {
                $link = " ";
            }if ($item->get_title() != null) {
                $title = $item->get_title();
            } else {
                $title = " ";
            }if ($item->get_author() != null) {
                $author = $item->get_author()->get_name();
            } else {
                $author = " ";
            }if ($item->get_date('Y-m-d H:i:s') != null) {
                $date = $item->get_date('Y-m-d H:i:s');
            } else {
                $date = " ";
            }if ($item->get_description() != null) {
                $description = $item->get_description();
            } else {
                $description = " ";
            }if ($item->get_base() != null) {
                $base = $item->get_base();
            } else {
                $base = " ";
            }$db->savePagesContent($link, $title, $author, $date, $description, $base, $conexion);
        }
   }
}


header("Location: index.php"); ?>

