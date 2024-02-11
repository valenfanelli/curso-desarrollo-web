<?php 
    require '../includes/app.php';
    estaAutenticado();
    use App\Propiedad;
    use App\Vendedor;
    //metodo para obtener propiedades con active record
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();
    incluirTemplate('header');
    $resultado = $_GET['resultado'] ?? null; //si no esta lo pone en null
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id) {
            $tipo = $_POST['tipo'];
            if(validarTipoContenido($tipo)) {
                //eliminar archivo
                if( $tipo == 'propiedad') {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();   
                }elseif ($tipo == 'propiedad') {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();   
                }        
            }
            
        }
    }
?>
<main class="contenedor seccion">
    <h1>Administrador de bienes raices</h1>
    <?php $mensaje = mostrarNotificacion(intval($resultado)); 
          if($mensaje) { ?>
          <p class="alerta exito"><?php echo s($mensaje); ?></p>
    <?php } ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-verde">Nuevo Vendedor</a>
    <h2>Propiedades</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($propiedades as $propiedad): ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="" class="imagen-tabla"></td>
                    <td><?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="post" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Vendedores</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($vendedores as $vendedor): ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="post" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">
                        </form>
                        <a href="admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php 
    mysqli_close($db);
    incluirTemplate('footer');
?>