<?php

require_once '../app.php';

use App\Core\Tools;
use App\Core\Template;

use App\Model\Categoria;
$categoria = new Categoria();

$categorias = $categoria->findAll();
$categorias = $categorias['dados'] ?? [];
?>

<!-- section start -->
<!-- ================ -->
<section class="section light-gray-bg clearfix">
  <div class="container">
    <div class="row justify-content-lg-center">
      <div class="col-lg-8">
        <h2 class="text-center mt-4"><strong>Categorias</strong></h2>
        <div class="separator"></div>
        <p class="lead text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa unde sequi consectetur atque blanditiis rem sed porro ducimus, quidem inventore eum quis.</p>
      </div>
    </div>
  </div>
  <div class="slick-carousel carousel-autoplay pl-10 pr-10">

    <?php foreach ($categorias as $key => $value): ?>

    <div class="listing-item pl-10 pr-10 mb-20">
      <div class="overlay-container bordered overlay-visible">
        <img src="<?= Template::url() . $value['imagem']; ?>" alt="">
        <a class="overlay-link" href="#"><i class="fa fa-plus"></i></a>
        <div class="overlay-bottom">
          <div class="text">
            <h3 class="title"><?= $value['nome']; ?></h3>
            <div class="separator light"></div>
            <p class="small margin-clear"><em>Quia nostrum temporibus et, <br> velit debitis ab, eligendi totam.</em></p>
          </div>
        </div>
      </div>
    </div>

    <?php endforeach; ?>
  </div>
</section>
<!-- section end -->

<script>
$(document).ready(function(){
  
});
</script>

<?php Template::getFooter(); ?>
