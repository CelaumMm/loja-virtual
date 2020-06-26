<?php
require_once '../app.php';

use App\Core\Template;

// Inicio Breadcrumb - navegação da página
Template::getNavegacao([
    [
        'nome' => 'Home',
        'url' => Template::url(),
        'icon' => 'fa fa-home pr-1'
    ],
    [
        'nome' => 'Usuários',
        'url' => '',
        'icon' => 'fa fa-users pr-1'
    ],
    [
        'nome' => 'Página Login',
        'url' => Template::url() . PROJETO . DS . 'login',
        'icon' => 'fa fa-key pr-1'
    ]
]);
// Fim Breadcrumb - navegação da página

$location = isset($_GET["loc"]) ? $_GET["loc"] : Template::url();

if (isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])) {
    header("Location: $location");
    exit();
}

if (env('OAUTH2_GOOGLE', false)) {
    include_once 'google.php';
}

require_once 'post.php';
?>

<!-- main-container start -->
<!-- ================ -->
<div class="main-container dark-translucent-bg" style="background-image:url('<?= Template::templateUrl() . 'images/background-img-6.jpg';?>');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto">
                <!-- main start -->
                <!-- ================ -->
                <div class="main object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="100">
                    <div class="form-block p-30 light-gray-bg border-clear">
                        <h2 class="title">Login</h2>
                        
                        <form class="form-horizontal" method="POST">
                            <div class="form-group has-feedback row">
                                <label for="login" class="col-md-3 text-md-right control-label col-form-label">E-mail</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="email" name="login" id="login" placeholder="Digite o e-mail" required>
                                    <i class="fa fa-user form-control-feedback pr-4"></i>
                                </div>
                            </div>
                            
                            <div class="form-group has-feedback row">
                                <label for="senha" class="col-md-3 text-md-right control-label col-form-label">Senha</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite a senha" required>
                                    <i class="fa fa-lock form-control-feedback pr-4"></i>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="ml-md-auto col-md-9">
<!--                                    <div class="checkbox form-check">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">
                                            Mantenha-me conectado
                                        </label>
                                    </div>-->
                                    
                                    <button type="submit" name="acao" id="acao" value="Conectar" class="btn btn-group btn-default btn-animated">Entrar <i class="fa fa-user"></i></button>
                                    
                                    <ul class="space-top">
                                        <li><a href="javascript:void" onclick="location.href = '<?= Template::url() . env('PROJETO_USUARIO') . "/esqueci-minha-senha"; ?>'">Esqueci minha senha</a></li>
                                    </ul>
                                    
                                    <?php if (env('OAUTH2_GOOGLE')): ?>
                                    <span class="text-center text-muted">Login com</span>
                                    <ul class="social-links colored circle clearfix">
                                        <!-- <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li> -->
                                        <!-- <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li> -->
                                        
                                        <?php if (env('OAUTH2_GOOGLE', false)): ?>
                                            <li class="googleplus"><a href="<?php echo $authUrl; ?>"><i class="fa fa-google-plus"></i></a></li>
                                        <?php endif; ?>
                                    </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <p class="text-center space-top">Não tem uma conta? <a href="javascript:void" onclick="location.href = '<?= Template::url() . env('PROJETO_USUARIO') . "/cadastrar"; ?>'">Crie uma!</a></p>
                </div>
                <!-- main end -->
            </div>
        </div>
    </div>
</div>
<!-- main-container end -->

<?php Template::getFooter(); ?>
