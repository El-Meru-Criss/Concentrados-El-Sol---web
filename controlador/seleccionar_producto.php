<?php //llama a la base de datos con el modelo
    require_once '../modelo/mysql.php';
    $mysql = new MySQL();

    $mysql->conectar();

    //realiza la consulta MySQL deseada, y la guarda en una variable

    $productos = $mysql->efectuarConsulta("SELECT producto.idproducto, 
    producto.nombre_producto 
    FROM producto");
?>
<option value=""></option>
<?php //inicio del ciclo para ir colocando HTML 

while ($prod = mysqli_fetch_array($productos)) { ?>
    
    <option value="<?php echo $prod['idproducto'] ?>"><?php echo $prod['nombre_producto'] ?></option>

<?php } //fin del ciclo

?>

<option onclick="seleccionar_producto()">actualizar</option>

<?php //desconecta la base de datos

    $mysql->desconectar();

?>