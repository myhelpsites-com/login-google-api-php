<?php

//Incluindo arquivo de conexão
include('configuration.php');

$login_button = '';

// Este valor da variável $_GET["code"] recebido depois que o usuário fez o login em sua conta do Google redirecionou para o script PHP, então este valor da variável foi recebido
if (isset($_GET["code"])) {
    // Ele tentará trocar um código por um token de autenticação válido.
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    // Esta condição verificará se há algum erro ocorrendo durante a obtenção do token de autenticação. Se nenhum erro ocorrer, ele será executado se o bloco de código /
    if (!isset($token['error'])) {
        // Defina o token de acesso usado para solicitações
        $google_client->setAccessToken($token['access_token']);

        // Armazena o valor "access_token" na variável $_SESSION para uso futuro.
        $_SESSION['access_token'] = $token['access_token'];

        // Criar objeto da classe OAuth 2 do serviço Google
        $google_service = new Google_Service_Oauth2($google_client);

        // Obtenha dados de perfil de usuário do google
        $dados = $google_service->userinfo->get();
        
        // Abaixo você pode encontrar Obter dados de perfil e armazenar na variável $_SESSION
        if (!empty($dados['id'])) {
            $oauthid = $dados['id'];
            // id do usuario
        }

        if (!empty($dados['given_name'])) {
            $_SESSION['primeiro_nome'] = $dados['given_name'];
            // primeiro nome
        }

        if (!empty($dados['family_name'])) {
            $_SESSION['sobrenome'] = $dados['family_name'];
            // sobrenome
        }

        if (!empty($dados['email'])) {
            $_SESSION['email'] = $dados['email'];
            // email do usuario
        }

        if (!empty($dados['gender'])) {
            $_SESSION['genero'] = $dados['gender'];
            // gereno do usuario
        }

        if (!empty($dados['picture'])) {
            $_SESSION['foto_perfil'] = $dados['picture'];
            // foto de perfil
        }
    }
}

// Isso é para verificar se o usuário fez login no sistema usando a conta do Google, 
// se o usuário não fizer login no sistema, ele executará o bloco de código e criará o código para exibir 
// o link de Login para fazer login usando a conta do Google.
if (!isset($_SESSION['access_token'])) {

    //Crie um URL para obter a autorização do usuário
    $login_button = '<a href="' . $google_client->createAuthUrl() . '">Login com google</a>';
}

?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login com Google API PHP</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body>
    <div class="container">
        <br />
        <h2 align="center">Login usando Google API PHP</h2>
        <br />
        <div class="panel panel-default">
            <?php
            if ($login_button == '') {
                echo '<div class="panel-heading">Olá' . $oauthid . '</div><div class="panel-body">';
                echo '<img src="' . $_SESSION["foto_perfil"] . '" class="img-responsive img-circle img-thumbnail" />';
                echo '<h3><b>Name :</b> ' . $_SESSION['primeiro_nome'] . ' ' . $_SESSION['sobrenome'] . '</h3>';
                echo '<h3><b>Email :</b> ' . $_SESSION['email'] . '</h3>';
                echo '<h3><a href="logout.php">Sair</h3></div>';
            } else {
                echo '<div align="center">' . $login_button . '</div>';
            }
            ?>
        </div>
    </div>
</body>

</html>