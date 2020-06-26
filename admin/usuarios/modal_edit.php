<?php
use App\Core\Template;
?>

<style>
.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
.modal-open {
    overflow: hidden;
    overflow-y: scroll;
    padding-right: 0 !important;
}
</style>

<div id="edit_model" class="modal fade" tabindex="-1"> 
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Usuário</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <form id="frm_edit" name="frm_edit" class="form-horizontal my-0" method="POST">
                <div class="modal-body">
                    <input type="hidden" value="edit" name="action" id="edit_action">
                    <input type="hidden" value="0" name="usuarios_id" id="usuarios_id">

                    <div class="form-group text-md-center">
                        <h3>Dados pessoais</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="image-box team-member shadow mb-20">
                                <div class="overlay-container overlay-visible">
                                    <img style="max-height: 348px; margin: auto;" id="img-foto" src="<?= Template::templateUrl() . 'images/no-photo-user.jpg'; ?>" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group has-feedback row">
                                <label for="nome" class="col-md-3 control-label text-md-right col-form-label">Nome <span class="text-danger small">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="nome" id="nome" required>
                                    <i class="fa fa-user form-control-feedback pr-4"></i>
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="cpf" class="col-md-3 control-label text-md-right col-form-label">CPF <span class="text-danger small">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control cpf" name="cpf" id="cpf">
                                    <i class="fa fa-id-card form-control-feedback pr-4"></i>
                                </div>
                            </div>

                            <div class="form-group has-feedback row">
                                <label for="telefone" class="col-md-3 control-label text-md-right col-form-label">Telefone </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control tel" name="telefone" id="telefone">
                                    <i class="fa fa-phone form-control-feedback pr-4"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label for="celular" class="col-md-3 control-label text-md-right col-form-label">Celular </label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control cel" name="celular" id="celular">
                                    <i class="fa fa-mobile form-control-feedback pr-4"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback row">
                                <label for="email" class="col-md-3 control-label text-md-right col-form-label">Email <span class="text-danger small">*</span></label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control" name="email" id="email">
                                    <i class="fa fa-envelope form-control-feedback pr-4"></i>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Fechar</button>                    
                    <button type="button" id="btn_edit" class="btn btn-group btn-default btn-animated">Salvar <i class="fa fa-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function () {
        /*
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
        */
    });
</script>