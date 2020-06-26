<?php

require_once '../app-sessao.php';

use App\Core\Template;

if (!isset($_SESSION["carrinho"]) || empty($_SESSION["carrinho"])){
  header('Location: /');
}
?>

<section class="main-container">
  <div class="container">
    <div class="row">
      <div class="main col-12">
        <h1 class="page-title">Carrinho de Compras</h1>
        <div class="separator-2"></div>

        <table class="table cart table-hover table-colored">
          <thead>
            <tr>
              <th></th>
              <th>Produto</th>
              <th>Preço</th>
              <th>Quantidade</th>
              <th>Remover </th>
              <th class="amount">Total </th>
            </tr>
          </thead>
          <tbody>
          <?php

          $count = 0;
          $total = 0;
          if (isset($_SESSION["carrinho"]) && !empty($_SESSION["carrinho"])):
            foreach ($_SESSION["carrinho"] as $keys => $values):

              $count +=$values["quantidade"];
              $total = $total + ($values["quantidade"] * $values["preco"]);
          ?>
            <tr class="remove-data">
              <td style="width: 60px;">
                <img src="<?= Template::url() . $values["imagem"]; ?>" alt="" style="max-width: 80px;">
              </td>
              <td class="product">
                <a href="/produto?id=<?= $values["produto_id"]; ?>"><?= $values["nome"]; ?></a> 
                <!-- <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas inventore modi.</!-->
              </td>
              
              <td class="price">R$ <?= number_format($values["preco"], 2, ',', '.'); ?></td>
              
              <td class="quantity">
                <div class="form-group">
                  <input type="text" class="form-control quantidade" id="quantidade-<?= $values["produto_id"]; ?>" 
                      value="<?= $values["quantidade"]; ?>" data-produto_id="<?= $values["produto_id"]; ?>" class="form-control quantidade" />
                </div>
              </td>
              
              <td class="remove">
                <button name="delete" class="btn btn-sm btn-default delete" id="<?= $values["produto_id"]; ?>">Remover</button>
              </td>
              
              <td class="amount">R$ <?= number_format($values["quantidade"] * $values["preco"], 2, ',', '.'); ?></td>
            </tr>
            <?php
              endforeach;
              endif;
            ?>
            <tr>
              <td colspan="4">Cupom de desconto</td>
              <td colspan="2">
                <div class="form-group">
                  <input type="text" class="form-control">
                </div>
              </td>
            </tr>
            <tr>
              <td class="total-quantity" colspan="4">Total <?= $count; ?> Items</td>
              <td class="total-amount" colspan="2">R$ <?= number_format($total, 2, ',', '.'); ?></td>
            </tr>
          </tbody>
        </table>
        <div class="text-right">
          <a href="#" class="btn btn-group btn-default cancelar">Cancelar</a>
          <button class="btn btn-group btn-default salvar">Savar Pedido</button>
        </div>

      </div>
      <!-- main end -->

    </div>
  </div>
</section>

<script>
$(document).ready(function(){

  $('.salvar').click(function(){
    var load = new Load();

    $.ajax({
      type: "POST",
      url: "../ajax.php",
      dataType: "json",
      async: false,
      data:{
        action: 'salvar-pedido'
      },
      beforeSend: function () {
          load.exibir();
      },
      success: function (response) {
        load.remover();
        
        if(response.sucesso){
          alert_sucesso_redirecionar(response.msg, 5000, '/');
        }
      },
      error: function (response) {
          load.remover();
          console.log('erro');
          console.log(response);
      }
    });
  });
    
  $('.delete').click(function(){
    var load = new Load();
    var produto_id = $(this).attr("id");  

    if(confirm("Tem certeza de que deseja remover este produto?")) {
      $.ajax({
        type: "POST",
        url: "../ajax.php",
        dataType: "json",
        async: false,
        data:{
          action: 'remover-carrinho',
          produto_id: produto_id
        },
        beforeSend: function () {
            load.exibir();
        },
        success: function (response) {
          load.remover();
          
          if(response.sucesso){

            if(response.redirect){
              location.href = '/';
            }else{
              location.reload();
            }

          }
        },
        error: function (response) {
            load.remover();
            console.log('erro');
            console.log(response);
        }
      });  
    }  
  });  

  $('.cancelar').click(function(){
    var load = new Load();

    if(confirm("Tem certeza de que deseja remover todos itens do carrinho?")) {
      $.ajax({
        type: "POST",
        url: "../ajax.php",
        dataType: "json",
        async: false,
        data:{
          action: 'cancelar-carrinho'
        },
        beforeSend: function () {
            load.exibir();
        },
        success: function (response) {
          load.remover();
          
          if(response.sucesso){
            location.href = '/';
          }
        },
        error: function (response) {
            load.remover();
            console.log('erro');
            console.log(response);
        }
      });  
    }  
  });  

  $(document).on('keyup', '.quantidade', function(){
    var load = new Load();
    var produto_id = $(this).data("produto_id");  
    var quantidade = $(this).val();
    if(quantidade > 0) {
      $.ajax({
        type: "POST",
        url: "../ajax.php",
        dataType: "json",
        async: false,
        data:{
          action: 'alerar-quantidade-carrinho',
          produto_id: produto_id,
          quantidade: quantidade
        },
        beforeSend: function () {
            load.exibir();
        },
        success: function (response) {
          load.remover();
          
          if(response.sucesso){
            location.reload();
          }
        },
        error: function (response) {
            load.remover();
            console.log('erro');
            console.log(response);
        }
      });  
    }
  });
});
</script>

<?php App\Core\Template::getFooter(); ?>
