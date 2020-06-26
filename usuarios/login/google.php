<?php

use App\Core\Template;
use App\Model\UsuarioBanco;

// Para redirecionamento apos receber a resposta do google
if (isset($_GET["loc"]) && !empty($_GET["loc"])) {
    $cookie_loc = (string) $_GET["loc"];
    setcookie('redirect', $cookie_loc, (time() + (60)), $_SERVER['SERVER_NAME']);
}

if (!empty($_COOKIE['redirect'])) {
    $redirect = $_COOKIE['redirect'];
} else {
    $redirect = Template::url(). ESTRUTURA;
}

$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/' . PROJETO . '/login';

$client = new Google_Client();

$client->setClientId(env('OAUTH2_GOOGLE_CLIENTE_ID'));
$client->setClientSecret(env('OAUTH2_GOOGLE_CLIENTE_SECRET'));

$client->setRedirectUri($redirect_uri);

$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);

    $_SESSION['google'] = new \stdClass();
    $_SESSION['google']->access_token = $client->getAccessToken();
    
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    return;
}

if (isset($_SESSION['google']->access_token) && $_SESSION['google']->access_token) {
    $client->setAccessToken($_SESSION['google']->access_token);
    $user = $service->userinfo->get();
} else {
    $authUrl = $client->createAuthUrl();
}

if (!isset($authUrl)) {        
    $usuarioBanco = new UsuarioBanco();    
    $dados = $usuarioBanco->getByEmail($user->email);
                        
    if ($dados) {  
        $usuarioBanco->setSession($dados['dados']);
    } else {
        unset($_SESSION['google']->access_token);

        $mensagem = 'Não foi possível acessar com o e-mail google';

        echo "
            <script>
            if (typeof BootstrapDialog == 'function') {

                var dialog = BootstrapDialog.show({
                    title: \"<h4><span class='glyphicons glyphicons-remove-2'></span> Ops! Algo deu errado.</h4>\",
                    message: '$mensagem',
                    draggable: true,
                    type: BootstrapDialog.TYPE_DANGER,
                    onhide: function(dialogRef){
                        location='$redirect_uri?loc=$redirect';
                    }
                });
            } else {
                alert('$mensagem');
                location.href ='$redirect_uri?loc=$redirect';
            }
            </script>";

        Template::getFooter();
        exit;
    }

    $_SESSION['google']->id = $user->id;
    $_SESSION['google']->nome = $user->name;
    $_SESSION['google']->email = $user->email;
    $_SESSION['google']->link = $user->link;
    $_SESSION['google']->picture = $user->picture;

    header("Location: $redirect");
    exit;
}