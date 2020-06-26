<?php
require_once '../app-session.php';

use App\Core\Template;
use App\Model\UsuarioBanco;

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
        'nome' => 'Meu perfil',
        'url' => Template::url() . PROJETO . DS . 'meu-perfil',
        'icon' => 'fa fa-user pr-1'
    ]
]);

$usuarioBanco = new UsuarioBanco();
$usuario = $usuarioBanco->getById($_SESSION['usuario']->id);
$usuario = (Object) $usuario['dados'];

$endereco = $usuarioBanco->getEndereco($usuario->id);
$endereco = $endereco['dados'];

?>

<section class="main-container">
    <div class="container">
        <div class="row">
            <div class="main col-12">
                <h1 class="page-title">Meu perfil</h1><div class="separator-2"></div>

                <ul class="nav nav-tabs style-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#htab1" role="tab" data-toggle="tab"><i class="fa fa-address-book pr-2"></i>Dados pessoais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#htab2" role="tab" data-toggle="tab"><i class="fa fa-map-marker pr-2"></i>Endereço</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Dados pessoais -->
                    <div class="tab-pane fade show active" id="htab1" role="tabpanel">
                        <form name="form-dados-pessoais" class="form-horizontal" method="POST" enctype="multipart/form-data" action='./post.php'>
                            <h3 class="mt-4">Dados pessoais</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="image-box team-member shadow mb-20">
                                        <div class="overlay-container overlay-visible">
                                            <img src="<?= (isset($usuario->foto) && !empty($usuario->foto)) ? $usuario->foto : Template::templateUrl() . 'images/no-photo-user.jpg'; ?>" alt="">
                                            <a href="<?= (isset($usuario->foto) && !empty($usuario->foto)) ? $usuario->foto : Template::templateUrl() . 'images/no-photo-user.jpg'; ?>" class="popup-img overlay-link" title="<?= $usuario->nome; ?>">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            <div class="overlay-bottom">
                                                <div class="text">
                                                    <h3 class="title margin-clear"><?= $usuario->nome; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <div class="col-md-11">
                                            <input type="file" class="form-control" name="foto" id="foto">
                                            <i class="fa fa-image form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">

                                    <div class="form-group has-feedback row">
                                        <label for="nome" class="col-md-3 control-label text-md-right col-form-label">Nome <span class="text-danger small">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nome" id="nome" value="<?= $usuario->nome; ?>" required>
                                            <i class="fa fa-user form-control-feedback pr-4"></i>
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback row">
                                        <label for="cpf" class="col-md-3 control-label text-md-right col-form-label">CPF <span class="text-danger small">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control cpf" name="cpf" id="cpf" value="<?= $usuario->cpf; ?>" required>
                                            <i class="fa fa-id-card form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group has-feedback row">
                                        <label for="celular" class="col-md-3 control-label text-md-right col-form-label">Celular <span class="text-danger small">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control cel" name="celular" id="celular" value="<?= $usuario->celular; ?>">
                                            <i class="fa fa-mobile form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="telefone" class="col-md-3 control-label text-md-right col-form-label">Telefone </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control tel" name="telefone" id="telefone" value="<?= $usuario->telefone; ?>">
                                            <i class="fa fa-phone form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="email" class="col-md-3 control-label text-md-right col-form-label">Email <span class="text-danger small">*</span></label>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control" name="email" id="email" value="<?= $usuario->email; ?>">
                                            <i class="fa fa-envelope form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="senha" class="col-md-3 control-label text-md-right col-form-label">Senha atual</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="osenha" id="osenha" minlength="6">
                                            <i class="fa fa-key form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="senha" class="col-md-3 control-label text-md-right col-form-label">Nova senha</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="senha" id="senha" minlength="6">
                                            <i class="fa fa-key form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="csenha" class="col-md-3 control-label text-md-right col-form-label">Confirmar senha</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="csenha" id="csenha" minlength="6">
                                            <i class="fa fa-key form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="separator-2"></div>

                            <div class="form-group text-md-center">
                                <button name="submit" type="submit" class="btn btn-group btn-default btn-animated" value="form-dados-pessoais">Salvar <i class="fa fa-check"></i></button>
                            </div>
                        </form>
                    </div>

                    <!-- Endereço -->
                    <div class="tab-pane fade" id="htab2" role="tabpanel">
                        <form name="form-endereco" class="form-horizontal" method="POST">
                            <div class="form-group text-md-center">
                                <h3 class="mt-4">Endereço</h3>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="form-group has-feedback row">
                                        <label for="cep" class="col-md-3 control-label text-md-right col-form-label">CEP </label>
                                        <div class="col-md-8">
                                            <input class="form-control cep" name="cep" id="cep" value="<?= $endereco->cep; ?>">
                                            <i class="fa fa-map-marker form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="lagradouro" class="col-md-3 control-label text-md-right col-form-label">Lagradouro </label>
                                        <div class="col-md-8">
                                            <input class="form-control autocomplete-address" name="lagradouro" id="lagradouro" value="<?= $endereco->lagradouro; ?>">
                                            <i class="fa fa-map form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="numero" class="col-md-3 control-label text-md-right col-form-label">Número </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="numero" id="numero" value="<?= $endereco->numero; ?>">
                                            <i class="fa fa-map-pin form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="complemento" class="col-md-3 control-label text-md-right col-form-label">Complemento </label>
                                        <div class="col-md-8">
                                            <input class="form-control" name="complemento" id="complemento" value="<?= $endereco->complemento; ?>">
                                            <i class="fa fa-home form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group has-feedback row">
                                        <label for="bairro" class="col-md-3 control-label text-md-right col-form-label">Bairro </label>
                                        <div class="col-md-8">
                                            <input class="form-control autocomplete-neighborhood" name="bairro" id="bairro" value="<?= $endereco->bairro; ?>">
                                            <i class="fa fa-map-signs form-control-feedback pr-4"></i>
                                        </div>
                                    </div> -->
                                    <div class="form-group has-feedback row">
                                        <label for="cidade" class="col-md-3 control-label text-md-right col-form-label">Cidade <span class="text-danger small">*</span></label>
                                        <div class="col-md-8">
                                            <input class="form-control autocomplete-city" name="cidade" id="cidade" value="<?= $endereco->cidade; ?>" required>
                                            <i class="fa fa-location-arrow form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="estado" class="col-md-3 control-label text-md-right col-form-label">Estado </label>
                                        <div class="col-md-8">
                                            <input class="form-control autocomplete-state" name="estado" id="estado" value="<?= $endereco->estado; ?>">
                                            <i class="fa fa-map-o form-control-feedback pr-4"></i>
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback row">
                                        <label for="pais" class="col-md-3 control-label text-md-right col-form-label">País <span class="text-danger small">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="pais" id="pais" value="<?= $endereco->pais; ?>" required>
                                            <i class="fa fa-globe form-control-feedback pr-4"></i>
                                        </div>
                                    </div>

                                </div>                            
                            </div>

                            <div class="separator-2"></div>

                            <div class="form-group text-md-center">
                                <button name="submit" type="submit" class="btn btn-group btn-default btn-animated" value="form-endereco">Salvar <i class="fa fa-check"></i></button>                            
                            </div>
                        </form>
                    </div>
                </div>
                <!-- tabs end -->
            </div>
        </div>
    </div>
</section>


<script>
    $(function () {
        $('#senha').focusout(function () {
            var senha = $('#senha').val();
            var csenha = $('#csenha').val();

            if (!empty(senha) && !empty(csenha)) {
                if (senha != csenha) {
                    $('#senha').val('');
                    $('#csenha').val('');

                    alert_atencao('As senhas informadas estão diferentes', 4000);
                }
            }
        });

        $('#csenha').focusout(function () {
            var senha = $('#senha').val();
            var csenha = $('#csenha').val();

            if (!empty(senha) && !empty(csenha)) {
                if (senha != csenha) {
                    $('#senha').val('');
                    $('#csenha').val('');

                    alert_atencao('As senhas informadas estão diferentes', 4000);
                }
            }
        });
    });
</script>
<?php App\Core\Template::getFooter(); ?>