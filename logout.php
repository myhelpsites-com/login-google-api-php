<?php

include('configuration.php');

//Redefinir token de acesso OAuth
$google_client->revokeToken();

//Destrua todos os dados da sessão.
session_destroy();

//redirecionar a página para index.php
header('location:index.php');

?>