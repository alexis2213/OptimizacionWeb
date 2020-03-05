
<html>

    <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        URL:<input type="text" name="asunto"><br><br>
        <input type="submit" name="boton" value="Guardar"> 
    </form>

</html>

<?php
require_once 'autoloader.php';

if (isset($_POST['boton'])) {
    $name = $_POST['asunto'];
    echo "User Has submitted the form and entered this name : <b> $name </b>";


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
    <table width="70%" border="1px" align="center">

        <tr align="center">
            <td>TITULO</td>
            <td>FEHCA</td>
            <td>DESCRIPCION</td>

        </tr>
        
        <?php
        foreach ($feed->get_items(0, 0) as $item) {
            ?>
            <tr>
                <td><?php echo '<p>Title: <a href="' . $item->get_link() . '">' . $item->get_title() . '</a></p>' ?></td>
                <td><?php echo '<p>Date: ' . $item->get_date('Y-m-d H:i:s') . '</p>'; ?></td>
                <td><?php echo '<p>Description: ' . $item->get_description() . '</p>' ?></td>

            </tr>
            <?php
        }
        ?>
    </table>


    <?php
}
?>




