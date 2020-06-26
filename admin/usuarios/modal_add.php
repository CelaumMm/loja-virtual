<div id="add_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Funcionário</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <form method="post" id="frm_add">
                <div class="modal-body">                                
                    <input type="hidden" value="add" name="action" id="add_action">
                    <div class="form-group">
                        <label for="name" class="control-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name"/>
                    </div>
                    <div class="form-group">
                        <label for="salary" class="control-label">Salary:</label>
                        <input type="text" class="form-control" id="salary" name="salary"/>
                    </div>
                    <div class="form-group">
                        <label for="salary" class="control-label">Age:</label>
                        <input type="text" class="form-control" id="age" name="age"/>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-gray" data-dismiss="modal">Fechar</button>
                    <button type="button" id="btn_add" class="btn btn-sm btn-default">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>