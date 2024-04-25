<?php 

require 'includes/config/database.php';
$db = conectarDB();

//Autenticar el usuario
$errores = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if(!$email) {
        $errores[] = "El email es obligatorio o no es válido";
    }

    if(!$password) {
        $errores[] = "La contraseña es obligatoria o no es válida";
    }

    if (empty($errores)) {
        //Revisar si el usuario existe
        $query = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($db, $query);

        if ($resultado -> num_rows) {
            //Revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado); //Recoge los datos de la row donde se encuentra ese usuario con esa contraseña
            //Verificar si el password es correcto
            $auth = password_verify($password, $usuario['password']);

            if($auth) {
                //Usuario autenticado, crear una sesion
                session_start();
                //Llenar array de la sesion
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;
                header('Location: /admin');
            } else {
                $errores[] = "El password es incorrecto";
            }
        } else {
            $errores[] = "El usuario no existe";
        }
    }
}

//Include del header
require 'includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php foreach ($errores as $error) :?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form action="" class="formulario" method="POST">
    <fieldset>
        <legend>Email y Password</legend>

        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Tu Email" id="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Tu Password" id="password" required>
    </fieldset>

    <input type="submit" name="" id="" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>