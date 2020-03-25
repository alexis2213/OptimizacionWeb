<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>RSS NEWS</title>
        
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">

        
      <link rel="stylesheet" type="text/css" href="jquery/jquery-ui.css"> 
        

        <script type="text/javascript" src="jquery/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="jquery/jquery-ui.js"></script>


        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
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
            foreach($resultado as $resul) {
              array_push($year, date("Y", strtotime($resul['Date'])));
              array_push($month, date("m", strtotime($resul['Date'])));
            }
            $year = array_unique($year);
            $month = array_unique($month);
            sort($year);
            sort($month);
          ?>
          <ul id="menu">
              <li><input type="checkbox" name="list" id="nivel1-1"><label for="nivel1-1">AÑO</label>
                <ul class="interior">
                    <?php
                      foreach($year as $y) {
                        echo '
                          <li><input type="checkbox" name="list" id="' . $y . '"><label for="' . $y .'">' . $y . '</label>
                            <ul class="interior">';

                        foreach($month as $m) {
                          $resultado = $db->getNoticiaPorfecha($conexion, $y, $m);
                          if (mysqli_num_rows($resultado) != 0) {
                            echo '
                              <form method="post">
                                <input type="hidden" value="' . $y . '" name="anio">
                                <input type="hidden" value="' . $m . '" name="mes">
                                <input type="submit" class="btn btn-primary btn-small" name="buscarFecha" value="' . obtenerMes($m) .'"/>
                              </form>
                            ';
                          }
                        }

                        echo '
                            </ul>
                          </li>
                        ';
                      }
                    ?>
                </ul>
              </li>
            </ul>
        </div>
          
          
          
          
      </div>

      <div class="col-lg">
        <div class="container">
          <h1 class="text-center">Noticias recientes</h1>
          <a href="indizador.php" class="btn btn-primary btn-lg btn-block">Indizar noticias del dia</a>

          <form class="pt-2" action="" method="post">
              <div class="form-group mb-1">
                  <input id="tag" class="form-control" name="noticia" type="text" placeholder="Busca una buena noticia..." aria-label="Search"><br>
              </div>
              <input type="submit" class="btn btn-primary btn-block" name="buscar" value="Buscar"/>
          </form>

          <?php
            if(isset($_POST['buscar'])) {
              $val = $_POST["noticia"];
              if($val == null) {
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

            
            
            if(isset($_POST['buscarFecha'])) {
              $val1 = $_POST["anio"];
              $val2 = $_POST["mes"];
              if($val1 == null || $val2 == null) {
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

            
            
            
            
            function imprimirResultados($db, $resultado) {

              while ($fila = $resultado->fetch_assoc()) {
                  echo '
                  <form action="" method="POST">
                    <br><div class="card">
                      <div class="card-header">
                        <h3>Title: <a href="' . $fila["Link"] . '">' . $fila["Title"] . '</a></h3>
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
              $(document).ready(function (){
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