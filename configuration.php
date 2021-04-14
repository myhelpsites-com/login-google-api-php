<?php

//Incluindo biblioteca do google API para autoload
require_once 'vendor/autoload.php';

//Faça o objeto do cliente API do Google para chamar a API do Google
$google_client = new Google_Client();

//Coloque seu ID Cliente
$google_client->setClientId('seu-id-client');

//Coloque sua Chave secreta OAuth 2.0
$google_client->setClientSecret('chave-secreta');

//Coloque url que vai fazer o redirecionamento OAuth 2.0 URI
$google_client->setRedirectUri('http://localhost:9876/testegoogle/teste3/index.php');

//Escopo de email
$google_client->addScope('email');

//Escopo de perfil
$google_client->addScope('profile');

//Iniciar a sessão
session_start();

?>
