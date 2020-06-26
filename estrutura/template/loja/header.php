<?php

use App\Core\Template;
use App\Core\Tools;
use App\Model\Sessao;
use App\Core\Auth;

// Iniciando a sessao
session_set_save_handler(new Sessao(), true);
session_start();

global $session;
$session = Tools::associateToObject($_SESSION);

global $post;
$post = Tools::associateToObject($_POST);

global $get;
$get = Tools::associateToObject($_GET);

// Verificando o acesso se a sessao for verdadeiro
if (Template::getSession()) {
    $auth = new Auth();
    $auth->verificar();
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="pt-br">
    <head>
        <meta charset="utf-8" />

        <title><?= Template::$sistema; ?></title>

        <meta name="description" content="Projeto desenvolvido pela Cod1green">
        <meta name="author" content="Marcelo Vaz de Camargo">
        <meta name="robots" content="noimageindex">

        <!-- Mobile Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?= Template::templateUrl() . 'images/favicon.ico'; ?>">

        <!-- Web Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=PT+Serif" rel="stylesheet">

        <script type="text/javascript">
            site = "<?= Template::url(); ?>";
            estrutura = "<?= Template::estruturaUrl(); ?>";
            projeto = "<?= PROJETO; ?>";
            template = "<?= Template::templateUrl(); ?>";
        </script>

        <!-- Jquery -->
        <script src="<?= Template::estruturaUrl() . 'node_modules/jquery/dist/jquery.min.js?' . time(); ?>"></script>        

        <!-- Bootstrap core CSS -->
        <link href="<?= Template::estruturaUrl() . 'node_modules/bootstrap/dist/css/bootstrap.min.css'; ?>" rel="stylesheet">
        <script src="<?= Template::estruturaUrl() . 'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js?' . time(); ?>"></script>        

        <!-- Font Awesome CSS -->
        <link href="<?= Template::estruturaUrl() . 'node_modules/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">

        <!-- Plugins -->
        <link href="<?= Template::templateUrl() . '../plugins/magnific-popup/magnific-popup.css'; ?>" rel="stylesheet">

        <!-- jQuery Revolution Slider  -->
        <link href="<?= Template::templateUrl() . '../plugins/rs-plugin-5/css/settings.css'; ?>" rel="stylesheet">        
        <link href="<?= Template::templateUrl() . '../plugins/rs-plugin-5/css/layers.css'; ?>" rel="stylesheet">        
        <link href="<?= Template::templateUrl() . '../plugins/rs-plugin-5/css/navigation.css'; ?>" rel="stylesheet">
        <script src="<?= Template::templateUrl() . '../plugins/rs-plugin-5/js/jquery.themepunch.tools.min.js?' . time(); ?>"></script>
        <script src="<?= Template::templateUrl() . '../plugins/rs-plugin-5/js/jquery.themepunch.revolution.min.js?' . time(); ?>"></script>       

        <?php if (TRUE): ?>
            <!-- Jquery-ui -->
            <link href="<?= Template::templateUrl() . '../plugins/jquery-ui/themes/south-street/jquery-ui.min.css'; ?>" rel="stylesheet">
            <script src="<?= Template::templateUrl() . '../plugins/jquery-ui/jquery-ui.min.js?' . time(); ?>"></script>
            <script src="<?= Template::templateUrl() . '../plugins/jquery-ui/ui/i18n/datepicker-pt-BR.js?' . time(); ?>"></script>       
        <?php endif; ?>

        <!-- Slick carousel javascript -->
        <link href="<?= Template::templateUrl() . '../plugins/slick/slick.css'; ?>" rel="stylesheet">
        <script src="<?= Template::templateUrl() . '../plugins/slick/slick.min.js?' . time(); ?>"></script>

        <?php if (TRUE): ?>
            <!-- Bootstrap4 dialog -->
            <link href="<?= Template::templateUrl() . '../plugins/bootstrap4-dialog/dist/css/bootstrap-dialog.min.css'; ?>" rel="stylesheet">
            <script src="<?= Template::templateUrl() . '../plugins/bootstrap4-dialog/dist/js/bootstrap-dialog.min.js?' . time(); ?>"></script>
        <?php endif; ?>

        <?php if (TRUE): ?>
            <!-- Toastr -->
            <link href="<?= Template::estruturaUrl() . 'node_modules/toastr/build/toastr.min.css'; ?>" rel="stylesheet">
            <script src="<?= Template::estruturaUrl() . 'node_modules/toastr/build/toastr.min.js?' . time(); ?>"></script>
        <?php endif; ?>

        <?php if (TRUE): ?>
            <!-- Owl-carousel -->
            <link href="<?= Template::estruturaUrl() . 'node_modules/owl.carousel/dist/assets/owl.carousel.min.css'; ?>" rel="stylesheet">
            <link href="<?= Template::estruturaUrl() . 'node_modules/owl.carousel/dist/assets/owl.theme.default.css'; ?>" rel="stylesheet">
            <script src="<?= Template::estruturaUrl() . 'node_modules/owl.carousel/dist/owl.carousel.min.js?' . time(); ?>"></script>                              
        <?php endif; ?>

        <?php if (TRUE): ?>
            <!-- Highcharts -->
            <script src="<?= Template::estruturaUrl() . 'node_modules/highcharts/highcharts.js?' . time(); ?>"></script>
            <script src="<?= Template::estruturaUrl() . 'node_modules/highcharts/modules/series-label.js?' . time(); ?>"></script>
            <script src="<?= Template::estruturaUrl() . 'node_modules/highcharts/modules/exporting.js?' . time(); ?>"></script>
            <script src="<?= Template::estruturaUrl() . 'node_modules/highcharts/modules/export-data.js?' . time(); ?>"></script>
        <?php endif; ?>

        <!-- Bootstrap-select -->

        <link href="<?= Template::templateUrl() . 'css/animations.css'; ?>" rel="stylesheet">        

        <!-- The Project's core CSS file -->
        <!-- Use css/rtl_style.css for RTL version -->
        <link href="<?= Template::templateUrl() . 'css/style.css'; ?>" rel="stylesheet" >

        <!-- The Project's Typography CSS file, includes used fonts -->
        <!-- Used font for body: Roboto -->
        <!-- Used font for headings: Raleway -->
        <!-- Use css/rtl_typography-default.css for RTL version -->
        <link href="<?= Template::templateUrl() . 'css/typography-default.css'; ?>" rel="stylesheet" >

        <!-- Color Scheme -->
        <link href="<?= Template::templateUrl() . 'css/skins/light_blue.css'; ?>" data-style="styles-no-cookie" rel="stylesheet">

        <?php if (FALSE): ?>
            <!-- Color Switcher -->
            <link href="<?= Template::templateUrl() . 'css/style-switcher.css'; ?>" rel="stylesheet">
            <script src="<?= Template::templateUrl() . 'js/style-switcher.js?' . time(); ?>"></script>
        <?php endif; ?>

        <!-- Custom css -->
        <link href="<?= Template::templateUrl() . 'css/custom.css'; ?>" rel="stylesheet">

        <!-- Isotope javascript -->
        <script src="<?= Template::templateUrl() . '../plugins/isotope/imagesloaded.pkgd.min.js?' . time(); ?>"></script>
        <script src="<?= Template::templateUrl() . '../plugins/isotope/isotope.pkgd.min.js?' . time(); ?>"></script>

        <!-- Magnific Popup javascript -->
        <script src="<?= Template::templateUrl() . '../plugins/magnific-popup/jquery.magnific-popup.min.js?' . time(); ?>"></script>

        <!-- Appear javascript -->
        <script src="<?= Template::templateUrl() . '../plugins/waypoints/jquery.waypoints.min.js?' . time(); ?>"></script>
        <script src="<?= Template::templateUrl() . '../plugins/waypoints/sticky.min.js?' . time(); ?>"></script>

        <!-- Count To javascript -->
        <script src="<?= Template::templateUrl() . '../plugins/countTo/jquery.countTo.js?' . time(); ?>"></script>

        <!-- Morphext -->
        <script src="<?= Template::templateUrl() . '../plugins/typed/typed.min.js?' . time(); ?>"></script>

        <!-- Pace javascript -->
        <script src="<?= Template::templateUrl() . '../plugins/pace/pace.min.js?' . time(); ?>"></script>

        <?php if (TRUE): ?>
            <!-- jQuery-Mask-Plugin -->
            <script src="<?= Template::estruturaUrl() . 'node_modules/jquery-mask-plugin/dist/jquery.mask.min.js?' . time(); ?>"></script>
        <?php endif; ?>

        <?php if (TRUE): ?>
            <!-- Jquery-maskmoney -->
            <script src="<?= Template::estruturaUrl() . 'node_modules/jquery-maskmoney/dist/jquery.maskMoney.min.js?' . time(); ?>"></script>
        <?php endif; ?>

        <?php if (TRUE): ?>
            <!-- Auto complete address -->
            <script src="<?= Template::templateUrl() . '../plugins/auto-complete-address/src/jquery.autocomplete-address.js?' . time(); ?>"></script>
        <?php endif; ?>

        <!-- Loading... -->
        <script src="<?= Template::templateUrl() . '../plugins/load.js?' . time(); ?>"></script>

        <!-- Initialization of Plugins -->
        <script src="<?= Template::templateUrl() . 'js/template.js?' . time(); ?>"></script>

        <!-- Custom Scripts -->
        <script src="<?= Template::templateUrl() . 'js/custom.js?' . time(); ?>"></script>

        <!-- Google Maps -->        
        <script type="text/javascript" src="<?= 'https://maps.googleapis.com/maps/api/js?' . time() ?>"></script>

        <script type="text/javascript">
            function setLogin() {
                var s = String(window.location);
                if (s.indexOf("?loc=") > -1) {
                    var s2 = s.split("?loc=");
                    s = s2[1];
                }
                window.location.href = "<?= Template::url() . env('PROJETO_USUARIO') . '/login/?loc='; ?>" + s;
            }
        </script>        
    </head>

    <!-- body classes:  -->
    <!-- "boxed": boxed layout mode e.g. <body class="boxed"> -->
    <!-- "pattern-1 ... pattern-9": background patterns for boxed layout mode e.g. <body class="boxed pattern-1"> -->
    <!-- "transparent-header": makes the header transparent and pulls the banner to top -->
    <!-- "gradient-background-header": applies gradient background to header -->
    <!-- "page-loader-1 ... page-loader-6": add a page loader to the page (more info @components-page-loaders.html) -->
    <!--    <body class="front-page page-loader-4">-->
    <body class=" ">

        <!-- scrollToTop -->
        <!-- ================ -->
        <div class="scrollToTop circle"><i class="fa fa-angle-up"></i></div>

        <!-- page wrapper start -->
        <!-- ================ -->
        <div class="page-wrapper">
            <?php
            if (Template::getMenu()) {
                require_once(Template::templatePath() . 'menu.php');
            }

            if (Template::getBanner()) {
                require_once(Template::templatePath() . 'banner.php');
            }
            ?>

            <div id="page-start"></div>
