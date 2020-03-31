<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>RSS NEWS</title>

        <script type="text/javascript" src="jquery/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="jquery/jquery-ui.css">
        <script type="text/javascript" src="jquery/jquery-ui.js"></script>


        <style>
            .accordion {
                background-color: #eee;
                color: #444;
                cursor: pointer;
                padding: 18px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 15px;
                transition: 0.4s;
            }

            .active, .accordion:hover {
                background-color: #ccc; 
            }

            .panel {
                padding: 0 18px;
                display: none;
                background-color: white;
                overflow: hidden;
            }
        </style>

    </head>




    <body>
        <?php
        include("db.php");
        $db = new conexion();
        $conexion = $db->dbConexion();
        $resultado = $db->getAllTitles($conexion);
        $noticias = array();
        while ($fila = $resultado->fetch_assoc()) {
            array_push($noticias, $fila["Title"]);
        }
        ?>

        <div class="row">


            <div class="col- pt-4">

                <div class="container ">
                    <?php
                    include ('funciones.php');
                    $resultado = $db->getAllDates($conexion);
                    $year = array();
                    $month = array();
                    $day = array();
                    foreach ($resultado as $resul) {
                        array_push($year, date("Y", strtotime($resul['Date'])));
                        array_push($month, date("m", strtotime($resul['Date'])));
                        array_push($day, date("d", strtotime($resul['Date'])));
                    }
                    $year = array_unique($year);
                    $month = array_unique($month);
                    $day = array_unique($day);
                    sort($year);
                    sort($month);
                    sort($day);
                    ?>

                    <div id="menu">

                        <button class="accordion">fechas</button>

                        <div class="panel">
                            <?php
                            foreach ($year as $y) {
                                echo '
                         <button class="accordion" for="' . '">' . $y . '</button>
                              <div class="panel"> 
                           ';



                                foreach ($month as $m) {
                                    $resultado = $db->getNoticiaPorfecha($conexion, $y, $m);
                                    if (mysqli_num_rows($resultado) != 0) {
                                        echo '
                          
                          <form method="post">
                          
                              <input type="hidden" value="' . $y . '" name="anio">
                              <input type="hidden" value="' . $m . '" name="mes">

                              <input class="accordion" name="buscarFecha" value="' . obtenerMes($m) . '"/>
                                   
                            </form>
                                                 
                            ';
                                    }

                                    foreach ($day as $d) {
                                        $resultado = $db->getNoticiaPorDia($conexion, $y, $m, $d);
                                        if (mysqli_num_rows($resultado) != 0) {
                                            echo '
                              <form method="post">
                                <input type="hidden" value="' . $y . '" name="anio">
                                <input type="hidden" value="' . $m . '" name="mes">
                                <input type="hidden" value="' . $d . '" name="dia">
                                <input type="submit" class="accordion"  name="buscarDia" value="' . obtenerDia($d) . '"/>
                              </form>
                                                 ';
                                        }
                                    }
                                }
                                echo '
          </div>';
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>


            <script>
                var acc = document.getElementsByClassName("accordion");
                var i;

                for (i = 0; i < acc.length; i++) {
                    acc[i].addEventListener("click", function () {
                        this.classList.toggle("active");
                        var panel = this.nextElementSibling;
                        if (panel.style.display === "block") {
                            panel.style.display = "none";
                        } else {
                            panel.style.display = "block";
                        }
                    });
                }
            </script>



            <div class="col-lg">
                <div class="container">
                    <h1 class="text-center">Noticias recientes</h1>
                    <a href="indizador.php" class="btn btn-primary btn-lg btn-block">Indizar noticias</a>



                    <form class="pt-2" action="" method="post">
                        <div class="form-group mb-1">
                            <input id="tag" class="form-control" name="noticia" type="text" placeholder="Busca una buena noticia..." aria-label="Search"><br>

                        </div>
                        <input type="submit" class="btn btn-primary btn-block" name="buscar" value="Buscar">

                    </form>




                    <form  class="pt-2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input  class="form-control" name="url" type="text" placeholder="Agregar nuevas urls..." aria-label="Search"><br>

                        <input type="submit" name="boton" value="agregar" class="btn btn-primary btn-lg btn-block"> 

                    </form>



                    <?php
                    if (isset($_POST['boton'])) {
                        $urls = $_POST['url'];
                        $query = "INSERT INTO urls VALUES('$urls')";
                        $resultado = $conexion->query($query);
                    }
                    ?>



                    <?php
                    if (isset($_POST['buscar'])) {
                        $val = $_POST["noticia"];
                        if ($val == null) {
                            echo '
                  <br>
                  <div class="alert alert-danger" role="alert">
                    Escribe una noticia
                  </div>';
                            exit();
                        } else {
                            $resultado = $db->getNoticiasConcidentes($conexion, $val);
                            imprimirResultados($db, $resultado);
                        }
                    }

                    if (isset($_POST['buscarFecha'])) {
                        $val1 = $_POST["anio"];
                        $val2 = $_POST["mes"];


                        if ($val1 == null || $val2 == null) {
                            echo '
                      <br>
                      <div class="alert alert-danger" role="alert">
                          Escribe una noticia
                      </div>';
                            exit();
                        } else {
                            $resultado = $db->getNoticiaPorfecha($conexion, $val1, $val2);
                            imprimirResultados($db, $resultado);
                        }
                    }




                    if (isset($_POST['buscarDia'])) {
                        $val1 = $_POST["anio"];
                        $val2 = $_POST["mes"];
                        $val3 = $_POST["dia"];
                        if ($val1 == null || $val2 == null || $val3 == null) {
                            echo '
                      <br>
                      <div class="alert alert-danger" role="alert">
                          Escribe una noticia
                      </div>';
                            exit();
                        } else {
                            $resultado = $db->getNoticiaPorDia($conexion, $val1, $val2, $val3);
                            imprimirResultados($db, $resultado);
                        }
                    }

                    function imprimirResultados($db, $resultado) {

                        while ($fila = $resultado->fetch_assoc()) {
                            echo '
                  <form action="generarArchivoExcel.php" method="POST">
                    <br><div class="card">
                      <div class="card-header">
                        <h3><a href="' . $fila["Link"] . '">' . $fila["Title"] . '</a></h3>
                      </div>
                      <div class="card-body">
                        <p> ' . $fila["Description"] . '</p>
                      </div>
                      <div class="card-footer">
                        <p>Author: ' . $fila["Author"] . '</p><br>
                        <p>Date: ' . $fila["Date"] . '</p><br>
                        
                      </div>
                    </div><br>
                      ';
                        }
                    }
                    ?>








                    <script type="text/javascript">
                        $(document).ready(function () {
                            var items = <?= json_encode($noticias) ?>

                            $("#tag").autocomplete({
                                source: items
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </body>

</html>