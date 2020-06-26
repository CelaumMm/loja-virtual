<?php

require_once './app.php';

use App\Core\Template;
use App\Model\Produto;

$produto = new Produto();

$marcas = $produto->marcas();
$marcas = $marcas['dados'] ?? [];

$rams = $produto->rams();
$rams = $rams['dados'] ?? [];

$armazenamentos = $produto->armazenamentos();
$armazenamentos = $armazenamentos['dados'] ?? [];

// dd($_SESSION);
?>

<div class="banner dark-translucent-bg" style="background-image:url('<?= Template::templateUrl() . 'images/shop-banner.jpg'; ?>'); background-position:50% 32%;">
  
  <div class="container">
    <div class="row justify-content-lg-center">
      <div class="col-lg-8 text-center pv-20">
        <h2 class="title hc-element-invisible" data-animation-effect="fadeIn" data-effect-delay="100">Bem-vindo a <strong>Loja</strong></h2>
        <div class="separator hc-element-invisible mt-10" data-animation-effect="fadeIn" data-effect-delay="100"></div>
        <p class="text-center hc-element-invisible" data-animation-effect="fadeIn" data-effect-delay="100">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi perferendis magnam ea necessitatibus, officiis voluptas odit! Aperiam omnis, cupiditate laudantium velit nostrum, exercitationem accusamus, possimus soluta illo deserunt tempora qui.</p>
      </div>
    </div>
  </div>      
</div>

<section class="main-container">
  <div class="container">
    <div class="row">
      <side class="col-lg-3">
          <div class="sidebar">

            <div class="block clearfix">
              <div class="list-group">
                <h3>Preço</h3>
                <input type="hidden" id="hidden_minimum_price" value="0" />
                <input type="hidden" id="hidden_maximum_price" value="65000" />
                <p id="price_show">1000 - 65000</p>
                <div id="price_range"></div>
              </div>
            </div>

            <div class="block clearfix">
              <div class="list-group">
                <h3>Marca</h3>
                <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
                  <?php foreach($marcas as $marca): ?>
                    <div class="list-group-item checkbox">
                      <label>
                        <input type="checkbox" class="common_selector brand" value="<?php echo $marca['marca']; ?>"  > <?php echo $marca['marca']; ?>
                      </label>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

            <div class="block clearfix">
              <div class="list-group mb-2">
                <h3>RAM</h3>
                <?php foreach($rams as $ram): ?>
                  <div class="list-group-item checkbox">
                    <label><input type="checkbox" class="common_selector ram" value="<?php echo $ram['ram']; ?>" > <?php echo $ram['ram']; ?> GB</label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="block clearfix">
              <div class="list-group mb-2">
                <h3>Internal Storage</h3>
                <?php foreach($armazenamentos as $armazenamento): ?>
                  <div class="list-group-item checkbox">
                    <label>
                      <input type="checkbox" class="common_selector storage" value="<?php echo $armazenamento['armazenamento']; ?>"  >
                      <?php echo $armazenamento['armazenamento']; ?> GB
                    </label>
                  </div>
                <?php endforeach; ?> 
              </div>
            </div>
          </div>
      </side>

      <div class="main col-lg-9">
        <div class="row grid-space-10 filter_data">
          
        </div>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function(){
    filter_data();

    function filter_data(usuarios_id) {
      var load = new Load();

      var minimum_price = $('#hidden_minimum_price').val();
      var maximum_price = $('#hidden_maximum_price').val();
      var brand = get_filter('brand');
      var ram = get_filter('ram');
      var storage = get_filter('storage');

      $.ajax({
          type: "POST",
          url: "./ajax.php",
          dataType: "json",
          async: false,
          data:{
            action: "filter", 
            minimum_price: minimum_price, 
            maximum_price: maximum_price, 
            brand: brand, 
            ram: ram, 
            storage: storage
          },
          beforeSend: function () {
              load.exibir();
          },
          success: function (response) {
              load.remover();
              
              if(response.sucesso){
                $('.filter_data').html('');

                if(response.dados.length){
                  $.each(response.dados, function( key, value ) {
                    $('.filter_data').append(
                      '<div class="col-lg-4 col-md-6">' +
                        '<div class="listing-item white-bg bordered mb-20">' +
                          '<div class="overlay-container">' +
                            '<img src="<?= Template::url(); ?>' + value.imagem + '" alt="" style="max-width: 190px;">' +
                            '<a class="overlay-link popup-img-single" href="/produto?id=' + value.id + '"><i class="fa fa-search-plus"></i></a>' +
                          '</div>' +
                          '<div class="body">' +
                            '<h3><a href="/produto?id=' + value.id + '">' + value.nome + '</a></h3>' +
                            '<p>R$ ' + Number(value.preco).toFixed(2).replace('.', ',') + '</p>' +

                            '<input type="text" id="quantidade-' + value.id + '" class="form-control mb-2" value="1" style="text-align: center;"/>' +
                            '<input type="hidden" id="nome-' + value.id + '" value="' + value.nome + '" />' +
                            '<input type="hidden" id="preco-' + value.id + '" value="' + value.preco + '" />' +
                            '<input type="hidden" id="imagem-' + value.id + '" value="' + value.imagem + '" />' +

                            '<div class="elements-list clearfix">' +
                              '<button id="' + value.id + '"class="btn-block pull-center margin-clear btn btn-sm btn-default btn-animated add-carrinho">' +
                                'Adicionar ao carrinho<i class="fa fa-shopping-cart"></i>' +
                              '</button>' +
                            '</div>' +
                          '</div>' +
                        '</div>' +
                      '</div>'
                    );
                  });
                }
              }else{
                $('.filter_data').html('<h3>Nenhum Produto encontado</h3>');
              }
          },
          error: function (response) {
              load.remover();
              console.log("Erro de Ajax: " + response.statusText);
          }
      });
    }

    function get_filter(class_name){
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    $('#price_range').slider({
        range:true,
        min:1000,
        max:65000,
        values:[1000, 65000],
        step:500,
        stop:function(event, ui)
        {
            $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_price').val(ui.values[0]);
            $('#hidden_maximum_price').val(ui.values[1]);
            filter_data();
        }
    });

    $('.add-carrinho').click(function(){
      var load = new Load();
      
      var produto_id = $(this).attr("id");  
      var nome = $('#nome-' + produto_id).val();  
      var preco = $('#preco-' + produto_id).val();  
      var imagem = $('#imagem-' + produto_id).val();  
      var quantidade = $('#quantidade-' + produto_id).val();  

      if(quantidade > 0) {
        $.ajax({
          type: "POST",
          url: "./ajax.php",
          dataType: "json",
          async: false,
          data:{
            action: 'add-carrinho',
            produto_id: produto_id,   
            nome: nome,   
            preco: preco,   
            imagem: imagem,   
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
