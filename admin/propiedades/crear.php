<?php

require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

estaAutenticado();

$db = conectarDB();

$propiedad = new Propiedad;

//Consulta para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Array con mensajes de errores
$errores = Propiedad::getErrores();

//Ejecutar el código después de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Crear una nueva instancia
    $propiedad = new Propiedad($_POST['propiedad']);

    //Generar nombre único para la imagen
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //Setear la imagen
    //Resize de la imagen con Intervention
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    //Validar
    $errores = $propiedad->validar();

    //Revisar que el array de errores esta vacio
    if (empty($errores)) {

        //Crear carpeta imagenes
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        //Guardar la imagen en el servidor
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        //Guardar en la base de datos
        $propiedad->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form action="/admin/propiedades/crear.php" class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php' ?>
        <input type="submit" name="" id="" value="Crear Propiedad" class="boton boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');
?>