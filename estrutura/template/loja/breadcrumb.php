<!-- breadcrumb start -->
<!-- ================ -->
<div class="breadcrumb-container">
    <div class="container">
        <ol class="breadcrumb">
            <?php
            foreach (App\Core\Template::$navegacao as $chave => $valor) {
                echo "<li class='breadcrumb-item'><i class='{$valor['icon']}'></i><a class='link-dark' href='{$valor['url']}'>{$valor['nome']}</a></li>";
            }
            ?>
        </ol>
    </div>
</div>
<!-- breadcrumb end -->