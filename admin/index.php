<?php
require_once './topo.php';

use App\Core\Template;

Template::getNavegacao([
    [
        'nome' => 'Home',
        'url' => Template::url(),
        'icon' => 'fa fa-home pr-1'
    ],
    [
        'nome' => 'Admin',
        'url' => '',
        'icon' => 'fa fa-cog pr-1'
    ],
    [
        'nome' => 'Lista de usuarios logados',
        'url' => Template::url() . PROJETO,
        'icon' => 'fa fa-users pr-1'
    ]
]);

//dd($_SESSION);
?>

<script src="<?= './logados/usuario.js?' . time(); ?>"></script>
<script src="<?= './logados/visitante.js?' . time(); ?>"></script>

<section class="main-container">

    <div class="container-fluid">
        <div class="row">
            
            <!-- sidebar -->
            <?php require_once('./links.php'); ?>
            
            <div class="main col-12 col-lg-10 order-lg-2"><!-- main start -->

                <h2 class="page-title text-center"><strong>Lista de Usuários Logados</strong></h2>
                <div class="separator-2"></div>

                <div class="row">
                    <div class="col-lg-6">            
                        <button id="deslogar-all-usuarios" class="btn btn-animated btn-gray" value="<?= $_SESSION['usuario']->id; ?>">Deslogar todos usuarios <i class="fa fa-user-times"></i></button>

                        <div id="grafico-usuario"></div>
                    </div>
                    <div class="col-lg-6">
                        <button id="deslogar-all-visitantes" class="btn btn-animated btn-gray float-md-right">Deslogar todos visitantes <i class="fa fa-user-times"></i></button>
                        <div id="grafico-visitante"></div>        
                    </div>
                </div>

                <table class="table table-colored table-striped table-hover table-bordered" id="tabela-logados">
                    <thead>
                        <tr>                        
                            <th>Nome</th>
                            <th>Localização</th>
                            <th>Ação</th>
                        </tr>
                    </thead>

                    <tbody id='tabela-logados-tbody'></tbody>
                </table>

            </div><!-- main end -->
        </div>
    </div>
</section>

<script>
    function deslogarUsuario(usuarios_id) {
        if (usuarios_id == <?= $_SESSION['usuario']->id; ?>) {
            BootstrapDialog.confirm({
                title: "<h4><span class='fa fa-warning'></span> Atenção</h4>",
                message: "Você será deslogado, desejá continuar?",
                closable: true,
                draggable: true,
                type: BootstrapDialog.TYPE_WARNING,
                btnCancelLabel: 'Cancelar',
                btnCancelClass: 'd-inline btn-gray',
                btnOKLabel: 'OK',
                btnOKClass: 'd-inline btn-warning',
                callback: function (result) {
                    if (result) {
                        $.ajax({
                            url: "./logados/ajax_deslogar_user.php",
                            type: "POST",
                            dataType: "json",
                            data: {"usuarios_id": usuarios_id}
                        }).done(function (data) {
                            if (data) {
                                location.reload(true);
                            }
                        });
                    }
                }
            });
        } else {
            $.ajax({
                url: "./logados/ajax_deslogar_user.php",
                type: "POST",
                dataType: "json",
                data: {"usuarios_id": usuarios_id}
            }).done(function (data) {

            });
        }
    }

    function bloquearUsuario(usuarios_id) {
        if (usuarios_id == <?= $_SESSION['usuario']->id; ?>) {
            alert_atencao('Você não pode se bloquear.', 4000);
        } else {
            $.ajax({
                url: "./logados/ajax_bloquear_user.php",
                type: "POST",
                dataType: "json",
                data: {"usuarios_id": usuarios_id}
            }).done(function (data) {

            });
        }
    }
</script>

<?php App\Core\Template::getFooter(); ?>