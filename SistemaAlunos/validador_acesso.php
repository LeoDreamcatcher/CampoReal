<?php

session_start();

if (isset($_SESSION['usuario']) && is_object($_SESSION['usuario'])){
    $user = $_SESSION['usuario'];
    $_SESSION['perfil_id'] = $user->profile_id;
} else {
    $_SESSION['perfil_id'] = null;
}

if (!isset($_SESSION['autenticar']) || $_SESSION['autenticar'] != "SIM"){
    header('Location: index.php?login=erro2');
    exit;
}

?>