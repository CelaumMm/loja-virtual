<?php

namespace App\Core;

class Template {

    public static $scripts = array();
    public static $estilos = array();
    
    public static $idturma;
    public static $nivel;
    public static $sistema;
    public static $template = 'loja';
    
    private static $header = 'header.php';
    private static $footer = 'footer.php';
    private static $menu = true;
    private static $banner = false;
    public static $navegacao = array();
    private static $session = false;
        
    public static $assets = [
        'jquery' => FALSE,
        'bootstrap' => FALSE,
        'font-awesome' => FALSE,
        'jquery-ui' => FALSE,
        'jquery-maskedinput' => FALSE,
        'jquery-maskmoney' => FALSE,
        'bootstrap-dialog' => FALSE,
        'toastr' => FALSE,
        'owl-carousel' => FALSE,
        'bootstrap-select' => FALSE,
        'highcharts' => FALSE,
    ];

    public static function url() {
        $host = $_SERVER['HTTP_HOST'];
        $porta = ($_SERVER['SERVER_PORT'] == 80) ? '' : ':' . $_SERVER['SERVER_PORT'];

        return 'http' . '://' . $host . $porta . '/';
    }

    public static function estruturaUrl() {       
        return self::url() . ESTRUTURA . '/';
    }
    
    public static function templateUrl() {
        return self::estruturaUrl() . 'template/' . self::$template . '/';
    }
        
    public static function templatePath() {
        return ESTRUTURA_PATH . '/template' . DS . self::$template . DS;
    }
    
    public static function getHeader($file = null) {
        if ($file) {
            self::$header = $file;
        }        
        require_once(self::templatePath() . self::$header);
    }
    
    public static function getFooter($file = null) {
        if ($file) {
            self::$footer = $file;
        }
        require_once(self::templatePath() . self::$footer);        
    }
    
    public static function getNavegacao(Array $navegacao) {        
        if(isset($navegacao) && !empty($navegacao)){
            self::$navegacao = $navegacao;
            require_once(self::templatePath() . 'breadcrumb.php');
        }
    }
    
    public static function setSession($boo = TRUE) {
        self::$session = $boo;
    }

    public static function getSession() {
        return self::$session;
    }
    
    public static function setMenu($boo = TRUE) {
        self::$menu = $boo;
    }

    public static function getMenu() {
        return self::$menu;
    }
    
    public static function setBanner($boo = TRUE) {
        self::$banner = $boo;
    }

    public static function getBanner() {
        return self::$banner;
    }

    public static function insertCss($file) {
        if (strpos($file, ".css"))
            array_push(self::$estilos, $file);
    }
    
    /**
     * Carrega todas as folhas de estilo no Header.php
     */
    public static function loadCss() {
        $estilos = "";
        
        // CSS passado pelo Template::insertCss()
        foreach (self::$estilos as $estilo) {
            $estilos .= "<link rel='stylesheet' type='text/css' href='{$estilo}' />\n";
        }
        
        /*
        // monta os vetores com os itens encontrados na pasta
        $itens = array();  
        $ponteiro = opendir(self::publicPath() . 'css' . DS);
        while ($nome_itens = readdir($ponteiro)) {
            $file = explode(".", $nome_itens);
            if (!strcmp($file[count($file) - 1], "css")) {
                $itens[] = $nome_itens;
            }
        }

        if ($itens) {
            sort($itens);

            foreach ($itens as $estilo) {
                $file = self::publicUrl() . "css/$estilo";
                $estilos .= "<link rel='stylesheet' type='text/css' href='{$file}' />\n";
            }
        }
        */
        
        return $estilos;
    }
    
    /**
     * enfilera js no cab "js"
     */
    public static function insertJs($file) {
        if (strpos($file, ".js"))
            array_push(self::$scripts, $file);
    }

    /**
     * Carrega todos os arquivos de scripts no Header.php
     */
    public static function loadJs() {
        $time = time();
        $scripts = "";

        // JS passado pelo Template::insertJs()
        foreach (self::$scripts as $js) {
            $scripts .= "<script type='text/javascript' src='{$js}?{$time}' ></script>\n";
        }

        /*
        // monta os vetores com os itens encontrados na pasta
        $itens = array();        
        $ponteiro = opendir(self::publicPath() . 'js' . DS);
        while ($nome_itens = readdir($ponteiro)) {
            $file = explode(".", $nome_itens);
            if (!strcmp($file[count($file) - 1], "js")) {
                $itens[] = $nome_itens;
            }
        }

        if ($itens) {
            sort($itens);

            foreach ($itens as $js) {
                $file = self::publicUrl() . "js/$js";
                $time = time();
                $scripts .= "<script language=\"javascript\" type=\"text/javascript\" src=\"{$file}?{$time}\" ></script>\n";
            }
        }
        */
        return $scripts;
    }
    
    public static function loadAssets() {     
        
        foreach (self::$assets AS $key => $value){
            
            switch ($key) {
                case 'jquery':
                    if($value){
                        $js = self::estruturaUrl() . 'bower_components/jquery/dist/jquery.min.js';
                        self::insertJs($js);
                    }
                    
                    break;
                case 'bootstrap':
                    if($value){
                        $css = self::estruturaUrl() . 'bower_components/bootstrap/dist/css/bootstrap.min.css';
                        self::insertCss($css);
                        
                        $js = self::estruturaUrl() . 'bower_components/bootstrap/dist/js/bootstrap.min.js';
                        self::insertJs($js);
                    }
                    
                    break;
                case 'font-awesome':
                    if($value){
                        $css = self::estruturaUrl() . 'bower_components/font-awesome/css/font-awesome.min.css';
                        self::insertCss($css);
                    }
                    
                    break;
                case 'jquery-ui':
                    if($value){
                        $css = self::estruturaUrl() . 'bower_components/jquery-ui/themes/south-street/jquery-ui.min.css';
                        self::insertCss($css);

                        $js = self::estruturaUrl() . 'bower_components/jquery-ui/jquery-ui.min.js';
                        self::insertJs($js);

                        $js = self::estruturaUrl() . 'bower_components/jquery-ui/ui/i18n/datepicker-pt-BR.js';
                        self::insertJs($js);
                    }
                    
                    break;
                case 'jquery-maskedinput':
                    if($value){
                        $js = self::estruturaUrl() . 'bower_components/jquery.maskedinput/dist/jquery.maskedinput.min.js';
                        self::insertJs($js);
                    }
                    
                    break;
                case 'jquery-maskmoney':
                    if($value){
                        $js = self::estruturaUrl() . 'bower_components/jquery.maskmoney/dist/jquery.maskMoney.min.js';
                        self::insertJs($js);
                    }
                    
                    break;
                case 'bootstrap-dialog':
                    if($value){
                        $css = self::estruturaUrl() . 'bower_components/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css';
                        self::insertCss($css);

                        $js = self::estruturaUrl() . 'bower_components/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js';
                        self::insertJs($js);
                    }
                    
                    break;
                case 'toastr':
                    if($value){
                        $css = self::estruturaUrl() . 'bower_components/toastr/toastr.min.css';
                        self::insertCss($css);

                        $js = self::estruturaUrl() . 'bower_components/toastr/toastr.min.js';
                        self::insertJs($js);
                    }
                    
                    break;
                case 'owl-carousel':                    
                    if($value){
                        $css = self::estruturaUrl() . 'bower_components/owl.carousel/dist/assets/owl.carousel.min.css';
                        self::insertCss($css);
                        
                        $css = self::estruturaUrl() . 'bower_components/owl.carousel/dist/assets/owl.theme.default.css';
                        self::insertCss($css);

                        $js = self::estruturaUrl() . 'bower_components/owl.carousel/dist/owl.carousel.min.js';
                        self::insertJs($js);
                    }
                    
                    break;
                case 'bootstrap-select':                    
                    if($value){
                        $css = self::estruturaUrl() . 'bower_components/bootstrap-select/dist/css/bootstrap-select.min.css';
                        self::insertCss($css);
                        
                        $js = self::estruturaUrl() . 'bower_components/bootstrap-select/dist/js/bootstrap-select.min.js';
                        self::insertJs($js);
                    }
                    
                    break;
                case 'highcharts':
                    if($value){
                        $js = self::estruturaUrl() . 'bower_components/highcharts/highcharts.js';
                        self::insertJs($js);

                        $js = self::estruturaUrl() . 'bower_components/highcharts/modules/series-label.js';
                        self::insertJs($js);

                        $js = self::estruturaUrl() . 'bower_components/highcharts/modules/exporting.js';
                        self::insertJs($js);

                        $js = self::estruturaUrl() . 'bower_components/highcharts/modules/export-data.js';
                        self::insertJs($js);
                    }

                    break;
            }
        }        
    }

}

?>