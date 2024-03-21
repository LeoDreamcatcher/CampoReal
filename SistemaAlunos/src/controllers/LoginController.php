<?php

require_once 'C:\xampp\htdocs\atividadesPHP\SistemaAlunos\src\models\User.php';

class LoginController{
    private $users;

    public function __construct()
    {
        $this->users = [
            new User(1, 'professora@teste.com.br', '1234', 1),
            new User(2, 'diretora@teste.com.br', '1234', 2),
            new User(3, 'pedagoga@teste.com.br', '1234', 3)
        ];
    }

    public function autenticar($email, $password)
    {
        foreach($this->users as $user){
            if(($user->email == $email) && password_verify($password, $user->password)){
                $_SESSION['autenticar'] = 'SIM';
                $_SESSION['id'] = $user->id;
                $_SESSION['profile_id'] = $user->profile_id;
                header('Location: /atividadesPHP/SistemaAlunos/src/view/home.php');
                exit;
            }
        }
        $_SESSION['autenticar'] = 'NAO';
        header('Location: index.php?login=erro');
        exit;
    }
}

?>