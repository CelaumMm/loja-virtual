<?php

require_once '../app.php';

use App\Core\Template;
use App\Model\Produto;

$produto = new Produto();

$produto = $produto->find($_GET['id']);
$produto = $produto['dados'] ?? [];
?>

<section class="main-container">
  <div class="container">
    <div class="row">
      <div class="main col-12">
        <h1 class="page-title">Produto</h1>
        <div class="separator-2"></div>
        <div class="row">
          <div class="col-lg-4">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#pill-1" data-toggle="tab" title="images"><i class="fa fa-camera pr-1"></i> Photo</a></li>
            </ul>

            <div class="tab-content clear-style">
              <div class="tab-pane active" id="pill-1">
                <div class="slick-carousel content-slider-with-large-controls">
                  <div class="overlay-container overlay-visible text-center">
                    <img src="<?= Template::url() . $produto['imagem']; ?>" alt="" style="margin:auto">
                    <a href="<?= Template::url() . $produto['imagem']; ?>" class="slick-carousel--popup-img overlay-link" title="<?= $produto['nome']; ?>"><i class="fa fa-plus"></i></a>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-8 pv-30">
            <h2 class="mt-4"><?= $produto['nome']; ?></h2>
            <p><?= $produto['descricao']; ?></p>
            
            <hr class="mb-10">
            <div class="clearfix mb-20">
              <span>
                <i class="fa fa-star text-default"></i>
                <i class="fa fa-star text-default"></i>
                <i class="fa fa-star text-default"></i>
                <i class="fa fa-star text-default"></i>
                <i class="fa fa-star"></i>
              </span>
              <a href="#" class="wishlist"><i class="fa fa-heart-o pl-10 pr-1"></i>Lista de Desejos</a>
              <ul class="pl-20 pull-right social-links circle small clearfix margin-clear animated-effect-1">
                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li class="googleplus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
              </ul>
            </div>
              <form class="clearfix row grid-space-10">
                  <div class="form-group col-lg-4">
                    <label>Quantity</label>
                    <input id="quantidade-<?= $produto["id"]; ?>" type="text" class="form-control" value="1">
                  </div>
              </form>
            <div class="light-gray-bg p-20 bordered clearfix">
              <span class="product price"><i class="fa fa-tag pr-10"></i>R$ <?= number_format($produto["preco"], 2, ',', '.'); ?></span>
              <div class="product elements-list pull-right clearfix">
                <!-- <input type="submit" value="Adicionar ao Carrinho" class="margin-clear btn btn-default"> -->

                <button id="<?= $produto["id"]; ?>" class="margin-clear btn btn-default btn-animated add-carrinho">
                  Adicionar ao carrinho<i class="fa fa-shopping-cart"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function(){
    $('.add-carrinho').click(function(){
      var load = new Load();
      
      var produto_id = $(this).attr("id");  
      var nome = '<?= $produto["nome"]; ?>';
      var preco = '<?= $produto["preco"]; ?>';
      var quantidade = $('#quantidade-' + produto_id).val();  

      if(quantidade > 0) {
        $.ajax({
          type: "POST",
          url: "../ajax.php",
          dataType: "json",
          async: false,
          data:{
            action: 'add-carrinho',
            produto_id: produto_id,   
            nome: nome,   
            preco: preco,   
            quantidade: quantidade,
          },
          beforeSend: function () {
              load.exibir();
          },
          success: function (response) {
            load.remover();

            if(response.dados.quantidade){
              $('.cart-count').html(response.dados.quantidade);
            }
          },
          error: function (response) {
              load.remover();
              console.log(response);
          }
        });  
      }  
    });
});
</script>

<?php Template::getFooter(); ?>
