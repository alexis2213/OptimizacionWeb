
<html>
    <head>
        <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
        <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>  
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">

        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Problema</title>
    </head>

    <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        URL:<input type="text" name="asunto"><br><br>
        <input type="submit" name="boton" value="Guardar"> 
    </form>

</html>

<?php
require_once 'php/simplepie-1.5/autoloader.php';

if (isset($_POST['boton'])) {
    $name = $_POST['asunto'];
    echo "usted esta En: <b> $name </b>";


    $archivo = 'archivo.txt';
    $ar = fopen($archivo, "w") or die("error al crear "); //se abre el archivo
    $asu = $_REQUEST['asunto'];
    fwrite($ar, $asu); //se escribe en el texto

    $fp = fopen($archivo, 'r');
    $texto = fread($fp, filesize($archivo)); //leemos el archivo

    fclose($fp);
    $feed = new SimplePie();
    $feed->set_feed_url($texto);
    $feed->init();
    ?>

    <h1 align="center">LISTADO DE NOTICIAS</h1>
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <table width="70%" border="1px" align="center" id="example" >

                    <thead>
                        <tr>
                            <th class="tg-031e">TITULO</th>
                            <th class="tg-031e">FEHCA</th>
                            <th class="tg-yw4l">DESCRIPCION</th>

                        </tr>
                    </thead>
                    <?php
                    foreach ($feed->get_items(0, 0) as $item) {
                        ?>
                        <tr>
                            <td class="tg-031e"><?php echo '<p> <a href="' . $item->get_link() . '">' . $item->get_title() . '</a></p>' ?></td>
                            <td class="tg-031e"><?php echo '<p> ' . $item->get_date('Y-m-d H:i:s') . '</p>'; ?></td>
                            <td class="tg-yw4l"><?php echo '<p> ' . $item->get_description() . '</p>' ?></td>

                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td class="tg-yw4l"></td>
                        <td class="tg-yw4l"></td>
                        <td class="tg-yw4l"></td>

                    </tr>  
                </table>
            </div>
        </div>
    </div>
    <?php
}
?>




