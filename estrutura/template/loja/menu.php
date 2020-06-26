<?php use App\Core\Template; ?>

<!-- header-container start -->
<div class="header-container">
    <!-- header-top start -->
    <!-- classes:  -->
    <!-- "dark": dark version of header top e.g. class="header-top dark" -->
    <!-- "colored": colored version of header top e.g. class="header-top colored" -->
    <!-- ================ -->
    <div class="header-top dark">
        <div class="container">
            <div class="row">
                <div class="col-3 col-sm-6 col-lg-8">
                    <!-- header-top-first start -->
                    <!-- ================ -->
                    <div class="header-top-first clearfix">
                        <ul class="social-links circle small clearfix hidden-sm-down">
                            <li class="facebook">
                                <a href="https://facebook.com" target="_blank"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li class="twitter">
                                <a href="https://twitter.com" target="_blank"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li class="linkedin">
                                <a href="https://linkedin.com" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </li>                            
                            <li class="instagram">
                                <a href="https://www.instagram.com" target="_blank"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li class="youtube"><a href="http://youtube.com"><i class="fa fa-youtube-play"></i></a></li>
                        </ul>
                        <div class="social-links hidden-md-up circle small">
                            <div class="btn-group dropdown">
                                <button id="header-top-drop-1" type="button"
                                        class="btn dropdown-toggle dropdown-toggle--no-caret" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"><i class="fa fa-share-alt"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-animation" aria-labelledby="header-top-drop-1">
                                    <li class="facebook">
                                        <a href="https://facebook.com" target="_blank"><i class="fa fa-facebook"></i></a>
                                    </li>
                                    <li class="twitter">
                                        <a href="https://twitter.com" target="_blank"><i class="fa fa-twitter"></i></a>
                                    </li>
                                    <li class="googleplus">
                                        <a href="https://plus.google.com" target="_blank"><i class="fa fa-google-plus"></i></a>
                                    </li>
                                    <li class="linkedin">
                                        <a href="https://linkedin.com" target="_blank"><i class="fa fa-linkedin"></i></a>
                                    </li>
                                    <li class="instagram">
                                        <a href="https://www.instagram.com" target="_blank"><i class="fa fa-instagram"></i></a>
                                    </li>                                    
                                    <li class="youtube">
                                        <a href="http://youtube.com" target="_blank"><i class="fa fa-youtube-play"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <ul class="list-inline hidden-md-down">
                            <li class="list-inline-item"><i class="fa fa-map-marker pr-1 pl-2"></i>R. Agulhas Negras,
                                398 - São Paulo - SP
                            </li>
                            <li class="list-inline-item"><i class="fa fa-phone pr-1 pl-2"></i>+55 11 1234-5678</li>
                            <li class="list-inline-item"><i class="fa fa-envelope-o pr-1 pl-2"></i>
                                email@exmplo.com.br
                            </li>
                        </ul>
                    </div>
                    <!-- header-top-first end -->
                </div>
                <div class="col-9 col-sm-6 col-lg-4">

                    <!-- header-top-second start -->
                    <!-- ================ -->
                    <div id="header-top-second" class="clearfix">

                        <!-- header top dropdowns start -->
                        <!-- ================ -->
                        <div class="header-top-dropdown text-right">
                            <?php if (isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])): ?>
                                <div class="btn-group">
                                    <a href=javascript:void" class="btn btn-default btn-sm"
                                        onclick="location.href = '<?= Template::url() . env('PROJETO_USUARIO') . "/meu-perfil/"; ?>'">
                                            <i class="fa fa-user pr-1"></i> <?= $_SESSION["usuario"]->nome; ?>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a href="javascript:void"
                                       onclick="location.href = '<?= Template::url() . env('PROJETO_USUARIO') . "/logoff/"; ?>'"
                                       title="Sair" class="btn btn-default btn-sm"><i class="fa fa-power-off pr-1"></i>
                                        Sair</a>
                                </div>

                            <?php else: ?>
                                <div class="btn-group">
                                    <a href="javascript:void"
                                       onclick="location.href = '<?= Template::url() . env('PROJETO_USUARIO') . "/cadastrar/"; ?>'"
                                       class="btn btn-default btn-sm" title="Fazer o cadastro"><i
                                                class="fa fa-user-plus pr-1"></i> Inscrever-se</a>
                                </div>
                                <div class="btn-group">
                                    <a href="javascript:void" onclick="setLogin()" title="Fazer o login"
                                       class="btn btn-default btn-sm"><i class="fa fa-key pr-1"></i> Acesse</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!--  header top dropdowns end -->
                    </div>
                    <!-- header-top-second end -->
                </div>
            </div>
        </div>
    </div>
    <!-- header-top end -->

    <!-- header start -->
    <!-- classes:  -->
    <!-- "fixed": enables fixed navigation mode (sticky menu) e.g. class="header fixed clearfix" -->
    <!-- "fixed-desktop": enables fixed navigation only for desktop devices e.g. class="header fixed fixed-desktop clearfix" -->
    <!-- "fixed-all": enables fixed navigation only for all devices desktop and mobile e.g. class="header fixed fixed-desktop clearfix" -->
    <!-- "dark": dark version of header e.g. class="header dark clearfix" -->
    <!-- "centered": mandatory class for the centered logo layout -->
    <!-- ================ -->

<!--    <header class="header fixed fixed-desktop clearfix" style="padding-top: 0px;">-->
    <header class="header clearfix" style="padding-top: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-md-auto hidden-md-down">
                    <!-- header-first start -->
                    <!-- ================ -->
                    <div class="header-first clearfix">
                        <!-- logo -->
                        <div id="logo" class="logo">
                            <a href="<?= Template::url(); ?>">
                                <img style="width: 140px; border: 0px;" id="logo_img"
                                     src="<?= Template::templateUrl() . 'images/logo_light_blue.png'; ?>"
                                     alt="Loja Virtual">
                            </a>
                        </div>

                        <!-- name-and-slogan -->
                        <div class="site-slogan">
                            Minha Loja Virtual
                        </div>
                    </div>
                    <!-- header-first end -->

                </div>
                <div class="col-lg-8 ml-lg-auto">

                    <!-- header-second start -->
                    <!-- ================ -->
                    <div class="header-second clearfix">

                        <!-- main-navigation start -->
                        <!-- classes: -->
                        <!-- "onclick": Makes the dropdowns open on click, this the default bootstrap behavior e.g. class="main-navigation onclick" -->
                        <!-- "animated": Enables animations on dropdowns opening e.g. class="main-navigation animated" -->
                        <!-- ================ -->
                        <div class="main-navigation main-navigation--mega-menu  animated">
                            <nav class="navbar navbar-expand-lg navbar-light p-0">
                                <div class="navbar-brand clearfix hidden-lg-up">

                                    <!-- logo -->
                                    <div id="logo-mobile" class="logo">
                                        <a href="<?= Template::url() . env('PROJETO_HOME'); ?>">
                                            <img id="logo-img-mobile"
                                                 src="<?= Template::templateUrl() . 'images/logo_light_blue.png'; ?>"
                                                 alt="Geth">
                                        </a>
                                    </div>

                                    <!-- name-and-slogan -->
                                    <div class="site-slogan">
                                        Minha Loja Virtual
                                    </div>
                                </div>

                                <!-- header dropdown buttons -->
                                <div class="header-dropdown-buttons hidden-lg-up p-0 ml-auto mr-3">
                                    <div class="btn-group">
                                        <button type="button" class="btn dropdown-toggle dropdown-toggle--no-caret"
                                                id="header-drop-3" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false"><i class="fa fa-search"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-right dropdown-animation"
                                            aria-labelledby="header-drop-3">
                                            <li>
                                                <form role="search" class="search-box margin-clear">
                                                    <div class="form-group has-feedback">
                                                        <input type="text" class="form-control" placeholder="Search">
                                                        <i class="fa fa-search form-control-feedback"></i>
                                                    </div>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- header dropdown buttons end -->

                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbar-collapse-1" aria-controls="navbar-collapse-1"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                                    <!-- main-menu -->
                                    <ul class="navbar-nav ml-xl-auto">
                                        <li class="nav-item"><a href="<?= Template::url(); ?>" class="nav-link" aria-haspopup="true" aria-expanded="false">Home</a></li>
                                        <li class="nav-item"><a href="/categorias" class="nav-link" aria-haspopup="true" aria-expanded="false">Categorias</a></li>
                                        <li class="nav-item"><a href="/pedidos" class="nav-link" aria-haspopup="true" aria-expanded="false">Pedidos</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <!-- main-navigation end -->
                    </div>
                    <!-- header-second end -->

                </div>
                <div class="col-auto hidden-md-down">
                    <!-- header dropdown buttons -->
                    <div class="header-dropdown-buttons">
                        <div class="btn-group">
                            <button type="button" class="btn dropdown-toggle dropdown-toggle--no-caret"
                                    id="header-drop-1" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="fa fa-search"></i></button>
                            <ul class="dropdown-menu dropdown-menu-right dropdown-animation"
                                aria-labelledby="header-drop-1">
                                <li>
                                    <form role="search" class="search-box margin-clear">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <i class="fa fa-search form-control-feedback"></i>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <a href="/carrinho" class="btn" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-shopping-basket"></i>
                                <span class="cart-count default-bg"><?= isset($_SESSION["carrinho"]) ? count($_SESSION["carrinho"]): 0 ?></span>
                            </a>
                        </div>
                    </div>
                    <!-- header dropdown buttons end -->
                </div>
            </div>
        </div>
    </header>
    <!-- header end -->
</div>
<!-- header-container end -->

