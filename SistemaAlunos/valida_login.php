<?php

session_start();

require_once 'C:\xampp\htdocs\atividadesPHP\SistemaAlunos\src\controllers\LoginController.php';

$loginController = new LoginController();
$loginController->autenticar($_POST['email'], $_POST['senha']);

?>