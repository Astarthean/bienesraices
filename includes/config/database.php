<?php

function conectarDB () : mysqli {
    $db = mysqli_connect('localhost', 'root', '', 'bienesraices_crud');
    
    if(!$db) {
        echo "No se conecto la DB";
        exit;
    }

    return $db;
}