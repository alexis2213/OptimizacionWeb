<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db
 *
 * @author alexg
 */

class conexion {

    function dbConexion() {
        $servidor = "localhost";
        $nombreUsuario = "root";
        $contraseña = "";
        $db = "pagecontent";
        $conexion = new mysqli($servidor, $nombreUsuario, $contraseña, $db);
        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }return $conexion;
    }

    function savePagesContent($link, $title, $author, $date, $description, $base, $conexion) {
        $query = "INSERT INTO page(Link, Title, Author, Date, Description, Base) " . "VALUES('$link', '$title', '$author', '$date', '$description', '$base')";
        $resultado = $conexion->query($query);
    }

    function getAllContent($conexion) {
        $query = "SELECT `ID`, `Link`, `Title`, `Author`, `Date`, `Description` FROM `page` WHERE";
        if ($resultado = $conexion->query($query)) {
            return $resultado;
        }
    }

    function getAllDates($conexion) {
        $query = "SELECT Date FROM page";
        if ($resultado = $conexion->query($query)) {
            return $resultado;
        }
    }

    function getAllContentDistinct($conexion) {
        $query = "SELECT `ID`, `Link`, `Title`, `Author`, `Date`, `Description` FROM `page` WHERE";
        if ($resultado = $conexion->query($query)) {
            return $resultado;
        }
    }

    function getAllTitles($conexion) {
        $query = "SELECT Title FROM page";
        if ($resultado = $conexion->query($query)) {
            return $resultado;
        }
    }

    function getSelectedContent($conexion, $id) {
        $query = "SELECT `ID`, `Link`, `Title`, `Author`, `Date`, `Description`, `Base` FROM `page` WHERE id = " . $id;
        if ($resultado = $conexion->query($query)) {
            return $resultado;
        }
    }

    function getNoticiasConcidentes($conexion, $noticia) {
        $query = "SELECT `ID`, `Link`, `Title`, `Author`, `Date`, `Description` FROM `page` WHERE Title LIKE '%" . $noticia . "%'";
        if ($resultado = $conexion->query($query)) {
            return $resultado;
        }
    }

    function getNoticiaPorfecha($conexion, $anio, $mes) {
        $currentYear = "YEAR(Date)";
        $currentMonth = "MONTH(Date)";
        $query = "SELECT `ID`, `Link`, `Title`, `Author`, `Date`, `Description` FROM `page` WHERE " . $currentYear . " = " . $anio . " AND " . $currentMonth . " = " . $mes;
        if ($resultado = $conexion->query($query)) {
            return $resultado;
        }
    }
}