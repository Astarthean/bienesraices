<?php

use App\Propiedad;

require '../../includes/app.php';

estaAutenticado();

//Recoger el ID de la propiedad por URL y validar que sea un número
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}

/*BASE DE DATOS*/

//Consulta para obtener los datos de la propiedad
$propiedad = Propiedad::find($id);

//Consulta para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Array con mensajes de errores
$errores = [];

//Ejecutar el código después de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    //Permite ver el contenido de los archivos FILE
    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    //Validacion para las variables para evitar inyecciones SQL, etc
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $parking = mysqli_real_escape_string($db, $_POST['parking']);
    $vendedores_id = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date('Y/m/d');

    //Asignar files a una variables
    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }

    if (!$precio) {
        $errores[] = "Debes añadir un precio";
    }

    if (strlen($descripcion) < 50) {
        $errores[] = "La descripción es obligatoria y tiene que contener al menos 50 caracteres";
    }

    if (!$habitaciones) {
        $errores[] = "Debes añadir el numero de habitaciones";
    }

    if (!$wc) {
        $errores[] = "Debes añadir el numero de baños";
    }

    if (!$parking) {
        $errores[] = "Debes añadir el numero de parking";
    }

    if (!$vendedores_id) {
        $errores[] = "Debes elegir el vendedor";
    }

    //Ya no es obligatorio, es opcional
    // if (!$imagen['name'] || $imagen['error']) {
    //     $errores[] = "La imagen es obligatoria";
    // }

    //Validar tamaño de la imagen para no cargar el servidor
    $medida = 1000 * 1000;
    if ($imagen['size'] > $medida) {
        $errores[] = "La imagen pesa mucho";
    }

    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";

    //Revisar que el array de errores esta vacio
    if (empty($errores)) {

        /* SUBIDA DE ARCHIVOS */

        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        if ($imagen['name']) {
            //Eliminar la imagen previa. Se usa unlink
            unlink($carpetaImagenes . $propiedad['imagen']);
            //Generar nombre único para la imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            //Subir imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        } else {
            $nombreImagen = $propiedad['imagen'];
        }

        //Insertar en la DB
        $query = "UPDATE propiedades SET 
        titulo = '$titulo', 
        precio = '$precio',
        imagen = '$nombreImagen',
        descripcion = '$descripcion', 
        habitaciones = $habitaciones, 
        wc = $wc, 
        parking = $parking, 
        vendedores_id = $vendedores_id 
        WHERE id = $id; ";

        // echo $query;

        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            //Redireccionar al usuario para evitar duplicar entradas y además pasarle mensaje por URL para poder mostrarlo en el redireccionamiento
            header('Location: /admin?resultado=2');
        }
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php' ?>
        <input type="submit" name="" id="" value="Actualizar Propiedad" class="boton boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');
?>