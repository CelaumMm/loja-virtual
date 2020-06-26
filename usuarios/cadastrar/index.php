<?php
require_once '../app.php';

use App\Core\Template;

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
        'nome' => 'Página Cadastro',
        'url' => Template::url() . PROJETO . DS . 'cadastrar',
        'icon' => 'fa fa-user-plus pr-1'
    ]
]);


if (isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {
    header("Location: " . Template::url());
}
?>

<!-- main-container start -->
<!-- ================ -->
<div class="main-container dark-translucent-bg" style="background-image:url('<?= Template::templateUrl() . 'images/background-img-6.jpg'; ?>');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-auto">
                <!-- main start -->
                <!-- ================ -->
                <div class="main object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="100">
                    <div class="form-block p-30 light-gray-bg border-clear">
                        <h2 class="title">Cadastro</h2>
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" action='./post.php'>

                            <fieldset class="form-group">
                                <legend class="col-form-legend col-sm-2 col-md-4"><i class="fa fa-address-book pr-2"></i>Dados pessoais</legend>

                                <div class="form-group has-feedback row">
                                    <label for="nome" class="col-md-3 control-label text-md-right col-form-label">Nome <span class="text-danger small">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="nome" id="nome" value="<?= getPost('nome'); ?>" required>
                                        <i class="fa fa-user form-control-feedback pr-4"></i>
                                    </div>
                                </div>

                                <div class="form-group has-feedback row input-cpf">
                                    <label for="cpf" class="col-md-3 control-label text-md-right col-form-label">CPF <span class="text-danger small">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control cpf" name="cpf" id="cpf" value="<?= getPost('cpf'); ?>" required>
                                        <i class="fa fa-id-card form-control-feedback pr-4"></i>
                                    </div>
                                </div>

                                <div class="form-group has-feedback row input-passaporte" style="display:none;">
                                    <label for="cpf" class="col-md-3 control-label text-md-right col-form-label">Passaporte <span class="text-danger small">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="passaporte" id="passaporte" maxlength="20">
                                        <i class="fa fa-id-card form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="celular" class="col-md-3 control-label text-md-right col-form-label">Celular <span class="text-danger small">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control cel" name="celular" id="celular" value="<?= getPost('celular'); ?>" required>
                                        <i class="fa fa-mobile form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="telefone" class="col-md-3 control-label text-md-right col-form-label">Telefone </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control tel" name="telefone" id="telefone" value="<?= getPost('telefone'); ?>">
                                        <i class="fa fa-phone form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="email" class="col-md-3 control-label text-md-right col-form-label">Email <span class="text-danger small">*</span></label>
                                    <div class="col-md-8">
                                        <input type="email" class="form-control" name="email" id="email" value="<?= getPost('email'); ?>" required>
                                        <i class="fa fa-envelope form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="senha" class="col-md-3 control-label text-md-right col-form-label">Senha <span class="text-danger small">*</span></label>
                                    <div class="col-md-8">
                                        <input type="password" class="form-control" name="senha" id="senha" minlength="6" required>
                                        <i class="fa fa-key form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="csenha" class="col-md-3 control-label text-md-right col-form-label">Confirmar senha <span class="text-danger small">*</span></label>
                                    <div class="col-md-8">
                                        <input type="password" class="form-control" name="csenha" id="csenha" minlength="6" required>
                                        <i class="fa fa-key form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="foto" class="col-md-3 control-label text-md-right col-form-label">Foto </label>
                                    <div class="col-md-8">
                                        <input type="file" class="form-control" name="foto" id="foto">
                                        <i class="fa fa-image form-control-feedback pr-4"></i>
                                    </div>
                                </div>

                            </fieldset>

                            <fieldset class="form-group">
                                <legend class="col-form-legend col-sm-2 col-md-4"><i class="fa fa-map-marker pr-2"></i>Endereço</legend>

                                <div class="form-group has-feedback row">
                                    <label for="cep" class="col-md-3 control-label text-md-right col-form-label">CEP </label>
                                    <div class="col-md-8">
                                        <input class="form-control cep" name="cep" id="cep" value="<?= getPost('cep'); ?>">
                                        <i class="fa fa-map-marker form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="lagradouro" class="col-md-3 control-label text-md-right col-form-label">Lagradouro </label>
                                    <div class="col-md-8">
                                        <input class="form-control autocomplete-address" name="lagradouro" id="lagradouro" value="<?= getPost('lagradouro'); ?>">
                                        <i class="fa fa-map form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="numero" class="col-md-3 control-label text-md-right col-form-label">Número </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="numero" id="numero" value="<?= getPost('numero'); ?>">
                                        <i class="fa fa-map-pin form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="complemento" class="col-md-3 control-label text-md-right col-form-label">Complemento </label>
                                    <div class="col-md-8">
                                        <input class="form-control" name="complemento" id="complemento" value="<?= getPost('complemento'); ?>">
                                        <i class="fa fa-home form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <!-- <div class="form-group has-feedback row">
                                    <label for="bairro" class="col-md-3 control-label text-md-right col-form-label">Bairro </label>
                                    <div class="col-md-8">
                                        <input class="form-control autocomplete-neighborhood" name="bairro" id="bairro" value="<?= getPost('bairro'); ?>">
                                            <i class="fa fa-map-signs form-control-feedback pr-4"></i>
                                    </div>
                                </div> -->
                                <div class="form-group has-feedback row">
                                    <label for="cidade" class="col-md-3 control-label text-md-right col-form-label">Cidade </label>
                                    <div class="col-md-8">
                                        <input class="form-control autocomplete-city" name="cidade" id="cidade" value="<?= getPost('cidade'); ?>">
                                        <i class="fa fa-location-arrow form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="estado" class="col-md-3 control-label text-md-right col-form-label">Estado </label>
                                    <div class="col-md-8">
                                        <input class="form-control autocomplete-state" name="estado" id="estado" value="<?= getPost('estado'); ?>">
                                        <i class="fa fa-map-o form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                                <div class="form-group has-feedback row">
                                    <label for="pais" class="col-md-3 control-label text-md-right col-form-label">País </label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="pais" id="pais" value="<?= getPost('pais'); ?>">
                                        <i class="fa fa-globe form-control-feedback pr-4"></i>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group row">
                                <div class="ml-md-auto col-md-9">
                                    <button type="submit" class="btn btn-group btn-default btn-animated">Cadastrar <i class="fa fa-check"></i></button>
                                    <a class="btn btn-group btn-gray btn-animated" href="" style="color: #333;">Limpar <i class="fa fa-trash-o"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- main end -->
            </div>
        </div>
    </div>
</div>
<!-- main-container end -->

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

<?php Template::getFooter(); ?>
