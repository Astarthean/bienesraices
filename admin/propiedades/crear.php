<?php

/*BASE DE DATOS*/
require '../../includes/config/database.php';
$db = conectarDB();

//Consulta para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Array con mensajes de errores
$errores = [];

$titulo = '';
$precio = '';
$imagen = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$parking = '';
$vendedores_id = '';

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

    if (!$imagen['name'] || $imagen['error']) {
        $errores[] = "La imagen es obligatoria";
    }

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

        //Generar nombre único para la imagen
        $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg" ;

        //Subir imagen
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

        //Insertar en la DB
        $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, parking, creado, vendedores_id) VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$parking', '$creado', '$vendedores_id')";

        // echo $query;

        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            //Redireccionar al usuario para evitar duplicar entradas y además pasarle mensaje por URL para poder mostrarlo en el redireccionamiento
            header('Location: /admin?resultado=1');
        }
    }
}

require '../../includes/funciones.php';
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
        <fieldset>
            <legend>Información General</legend>
            <label for="titutlo">Titulo:</label>
            <input type="text" name="titulo" id="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png" value="<?php echo $imagen; ?>">

            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>
            <label for="habitaciones">Habitaciones:</label>
            <input type="number" name="habitaciones" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños:</label>
            <input type="number" name="wc" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="parking">Parking:</label>
            <input type="number" name="parking" id="parking" placeholder="Ej: 3" min="1" max="9" value="<?php echo $parking; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select name="vendedor" id="vendedor">
                <option value=""> -- Seleccione -- </option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> value=" <?php echo $vendedor['id'] ?> "> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido'];  ?> </option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" name="" id="" value="Crear Propiedad" class="boton boton-verde">

    </form>

</main>

<?php
incluirTemplate('footer');
?>