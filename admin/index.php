<?php

require '../includes/app.php';

//Importar clases
use App\Propiedad;
use App\Vendedor;

estaAutenticado();

//Implementar un método para obtener todas las propiedades
$propiedades = Propiedad::all();
$vendedores = Vendedor::all();

//La doble interrogación con null asigna un valor NULL si la variable resultado no esta  definida
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tipo = $_POST['tipo'];

    if (validarTipoContenido($tipo)) {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($tipo === 'vendedor') {
            $vendedor = Vendedor::find($id);
            $vendedor->eliminar();
        } else if ($tipo === 'propiedad') {
            $propiedad = Propiedad::find($id);
            $propiedad->eliminar();
        }
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php
    $mensaje = mostrarNotificacion(intval($resultado));
    if ($mensaje) : ?>
        <p class="alerta exito"> <?php echo s($mensaje); ?> </p>
    <?php
    endif;
    ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>

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
        <tbody> <!-- Mostrar los resultados de la DB -->
            <?php foreach ($propiedades as $propiedad) : ?>
                <tr>
                    <td> <?php echo $propiedad->id; ?> </td>
                    <td> <?php echo $propiedad->titulo; ?> </td>
                    <td><img class="imagen-tabla" src="/imagenes/<?php echo $propiedad->imagen; ?>"></td>
                    <td><?php echo $propiedad->precio; ?>€</td>
                    <td>
                        <form action="" method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a class="boton-amarillo-block" href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>">Actualizar</a>
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
        <tbody> <!-- Mostrar los resultados de la DB -->
            <?php foreach ($vendedores as $vendedor) : ?>
                <tr>
                    <td> <?php echo $vendedor->id; ?> </td>
                    <td> <?php echo $vendedor->nombre .  " " . $vendedor->apellido; ?> </td>

                    <td> <?php echo $vendedor->telefono; ?> </td>
                    <td>
                        <form action="" method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a class="boton-amarillo-block" href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

<?php
//Cerrar la conexion. Cuando PHP no detecta conexion, la cierra automáticamente pero es opcional ponerlo
// mysqli_close($db);
incluirTemplate('footer');
?>