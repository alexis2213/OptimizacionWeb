<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function obtenerDia($d) {
    switch ($d) {
        case 0:return "Domingo";
            break;
        case 1:return "Lunes";
            break;
        case 2:return "Martes";
            break;
        case 3:return "Miercoles";
            break;
        case 4:return "Jueves";
            break;
        case 5:return "Viernes";
            break;
        case 6:return "Sabado";
            break;
    }
}

function obtenerMes($m) {
    switch ($m) {
        case 1:return "Enero";
            break;
        case 2:return "Febrero";
            break;
        case 3:return "Marzo";
            break;
        case 4:return "Abril";
            break;
        case 5:return "Mayo";
            break;
        case 6:return "Junio";
            break;
        case 7:return "Julio";
            break;
        case 8:return "Agosto";
            break;
        case 9:return "Septiembre";
            break;
        case 10:return "Octubre";
            break;
        case 11:return "Noviembre";
            break;
        case 12:return "Diciembre";
            break;
    }
} ?>