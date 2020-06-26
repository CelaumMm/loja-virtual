<?php
require_once '../topo.php';

use App\Core\Template;

Template::getNavegacao([
    [
        'nome' => 'Home',
        'url' => Template::url(),
        'icon' => 'fa fa-home pr-1'
    ],
    [
        'nome' => 'Admin',
        'url' => Template::url() . PROJETO,
        'icon' => 'fa fa-cog pr-1'
    ],
    [
        'nome' => 'Lista de Usuários',
        'url' => Template::url() . PROJETO . '/usuarios',
        'icon' => 'fa fa-users pr-1'
    ]
]);

//dd($_SESSION);
?>

<link href="jquery.bootgrid-1.3.1/jquery.bootgrid.custom.css" rel="stylesheet" />

<script src="jquery.bootgrid-1.3.1/jquery.bootgrid.js"></script>
<script src="jquery.bootgrid-1.3.1/jquery.bootgrid.custom.js"></script>

<section class="main-container">
    <div class="container-fluid">
        <div class="row">

            <!-- sidebar -->
            <?php require_once('../links.php'); ?>

            <div class="main col-12 col-lg-10 order-lg-2"><!-- main start -->
                <h2 class="page-title text-center"><strong>Lista de Usuários</strong></h2>
                <div class="separator-2"></div>

                <table id="employee_grid" class="table table-sm  table-colored table-striped table-hover table-bordered bootgrid-table" data-toggle="bootgrid">
                    <thead>
                        <tr>
                            <th data-column-id="id" data-visible="false" data-type="numeric" data-identifier="true">Id</th>
                            <th data-column-id="nome" data-order="asc">Nome</th>
                            <th data-column-id="email">E-mail</th>
                            <th data-column-id="data_cadastro" data-formatter="data_cadastro">Data cadastro</th>
                            <th data-column-id="data_alteracao" data-formatter="data_alteracao">Data alteração</th>
                            <th data-column-id="ativo" data-formatter="ativo">Ativo</th>
                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">Comandos</th>
                        </tr>
                    </thead>
                </table>

                <!-- Modal Add -->
                <?php require_once('./modal_add.php'); ?>

                <!-- Modal Edit -->
                <?php require_once('./modal_edit.php'); ?>

            </div> <!-- main end -->
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {

        // Dados são carregados e renderizados no grid
        var grid = $("#employee_grid").bootgrid({
            ajax: true,
            rowSelect: true,
            post: function () {
                /* To accumulate custom parameter with the request object */
                return {
                    id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
                };
            },
            url: "ajax.php",
            formatters: {
                "ativo": function (column, row) {
                    if (row.ativo == 1) {
                        return "Sim";
                    } else {
                        return "Não";
                    }
                },
                "data_cadastro": function (column, row) {
                    var data = new Date(row.data_cadastro);
                    return data.toLocaleString();
                },
                "data_alteracao": function (column, row) {
                    var data = new Date(row.data_alteracao);
                    return data.toLocaleString();
                },
                "commands": function (column, row) {
                    var botao = '';
                    if (row.ativo == 1) {
                        botao = "<button style='padding: 1px 5px; font-size: 12px;' type='button' class='btn btn-warning btn-sm command-block' data-row-id='" + row.id + "'><span class='fa fa-ban'></span></button> ";
                    } else {
                        botao = "<button style='padding: 1px 5px; font-size: 12px;' type='button' class='btn btn-success btn-sm command-active' data-row-id='" + row.id + "'><span class='fa fa-check'></span></button> ";
                    }

                    return "<button style='padding: 1px 5px; font-size: 12px;' type='button' class='btn btn-default btn-sm command-edit' data-row-id='" + row.id + "'><span class='fa fa-pencil'></span></button> " +
                            botao +
                            "<button style='padding: 1px 5px; font-size: 12px;' type='button' class='btn btn-danger btn-sm command-delete' data-row-id='" + row.id + "'><span class='fa fa-trash'></span></button>";
                }
            }
        });

        // Executa depois que os dados são carregados e renderizados
        grid.on("loaded.rs.jquery.bootgrid", function () {

            grid.find(".command-edit").on("click", function (e) {
                var id = $(this).data("row-id");

                if (id > 0) {
                    var dados = getUsuario(id);

                    if (!empty(dados)) {
                        $('#usuarios_id').val(dados.id);
                        $('#nome').val(dados.nome);
                        $('#telefone').val(dados.telefone);
                        $('#celular').val(dados.celular);
                        $('#email').val(dados.email);
                        $('#cpf').val(dados.cpf).attr("required", true);

                        // foto
                        if (empty(dados.foto)) {
                            $('#img-foto').attr('src', "<?php echo Template::templateUrl() . 'images/no-photo-user.jpg'; ?>");
                        }else{
                            $('#img-foto').attr('src', dados.foto);
                        }

                        $('#edit_model').modal('show');
                    }
                }
            });

            grid.find(".command-active").on("click", function (e) {
                var id = $(this).data("row-id");
                var nome = $(this).parent().siblings(':first').html();

                if (id > 0) {
                    BootstrapDialog.confirm({
                        title: "<h4><span class='fa fa-check'></span> Deseja ativar usuário?</h4>",
                        message: nome,
                        closable: true,
                        draggable: true,
                        type: BootstrapDialog.TYPE_SUCCESS,
                        btnCancelLabel: 'Cancelar',
                        btnCancelClass: 'd-inline btn-gray',
                        btnOKLabel: "<span class='fa fa-check'></span> Ativar",
                        btnOKClass: 'd-inline btn-success',
                        callback: function (conf) {
                            if (conf) {
                                acao(id, 'active');
                            }
                        }
                    });
                }
            });

            grid.find(".command-block").on("click", function (e) {
                var id = $(this).data("row-id");
                var nome = $(this).parent().siblings(':first').html();

                if (id > 0) {
                    if (id == <?= $_SESSION['usuario']->id; ?>) {
                        alert_atencao('Você não pode se bloquear.', 4000);
                    } else {
                        BootstrapDialog.confirm({
                            title: "<h4><span class='fa fa-ban'></span> Deseja bloquear usuário?</h4>",
                            message: nome,
                            closable: true,
                            draggable: true,
                            type: BootstrapDialog.TYPE_WARNING,
                            btnCancelLabel: 'Cancelar',
                            btnCancelClass: 'd-inline btn-gray',
                            btnOKLabel: "<span class='fa fa-ban'></span> Bloquear",
                            btnOKClass: 'd-inline btn-warning',
                            callback: function (conf) {
                                if (conf) {
                                    acao(id, 'block');
                                }
                            }
                        });
                    }
                }
            });

            grid.find(".command-delete").on("click", function (e) {
                var id = $(this).data("row-id");
                var nome = $(this).parent().siblings(':first').html();

                if (id > 0) {
                    if (id == <?= $_SESSION['usuario']->id; ?>) {
                        alert_atencao('Você não pode se deletar.', 4000);
                    } else {
                        BootstrapDialog.confirm({
                            title: "<h4><span class='fa fa-remove'></span> Deseja deletar usuário?</h4>",
                            message: nome,
                            closable: true,
                            draggable: true,
                            type: BootstrapDialog.TYPE_DANGER,
                            btnCancelLabel: 'Cancelar',
                            btnCancelClass: 'd-inline btn-gray',
                            btnOKLabel: "<span class='fa fa-trash'></span> Deletar",
                            btnOKClass: 'd-inline btn-danger',
                            callback: function (conf) {
                                if (conf) {
                                    acao(id, 'delete');
                                }
                            }
                        });
                    }
                }
            });
        });

        function acao(usuarios_id, action) {
            var load = new Load();

            var formData = new FormData();
            formData.append('usuarios_id', usuarios_id);
            formData.append('action', action);

            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    load.exibir();
                },
                success: function (response) {
                    load.remover();
                    $("#employee_grid").bootgrid('reload');
                    // console.log(response);
                },
                error: function (response) {
                    load.remover();
                    console.log("Erro de Ajax: " + response.statusText);
                }
            });
        }

        function ajaxAction(action) {
            var load = new Load();
            var formData = new FormData($("#frm_" + action)[0]);
            // formData.append('tax_file', $('input[type=file]')[0].files[0]);

            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    load.exibir();
                },
                success: function (response) {
                    load.remover();

                    if (response.sucesso == false) {
                        alert_atencao(response.msg, 4000);
                    } else {
                        $('#' + action + '_model').modal('hide');
                        document.getElementById("frm_" + action).reset();
                        $("#employee_grid").bootgrid('reload');
                    }

//                    console.log(response);
                },
                error: function (response) {
                    load.remover();
                    console.log("Erro de Ajax: " + response.statusText);
                }
            });
        }

        function getUsuario(usuarios_id) {
            var load = new Load();
            var dados;

            $.ajax({
                type: "POST",
                url: "./ajax.php",
                dataType: "json",
                async: false,
                data: {"usuarios_id": usuarios_id, "action": "get"},
                beforeSend: function () {
                    load.exibir();
                },
                success: function (response) {
                    load.remover();
                    dados = response;
                },
                error: function (response) {
                    load.remover();
                    console.log("Erro de Ajax: " + response.statusText);
                }
            });

            return dados;
        }
        
        // Removendo o botao add que nao foi implementado
        $("#command-add").parent().remove();

        $("#command-add").click(function () {
            // $('#add_model').modal('show');
        });

        $("#btn_add").click(function () {
            ajaxAction('add');
        });

        $("#btn_edit").click(function () {
            ajaxAction('edit');
        });
    });
</script>

<?php Template::getFooter(); ?>