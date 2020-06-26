<?php

function formatarDataHora($value, $format = 'd/m/Y') {
    return Carbon\Carbon::parse($value)->format($format);
}

if (!function_exists('env')) {

    /**
     * Obtém o valor de uma variável de ambiente. Suporta boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null) {
        $value = getenv($key);
        if ($value === false) {
            return value($default);
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }
        if (strlen($value) > 1 && starts_with($value, '"') && ends_with($value, '"')) {
            return substr($value, 1, -1);
        }
        return $value;
    }

}

if (!function_exists('value')) {

    /**
     * Retorna o valor padrão do valor dado.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value) {
        return $value instanceof Closure ? $value() : $value;
    }

}

if (!function_exists('starts_with')) {

    /**
     * Determine se uma determinada string começa com uma determinada substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    function starts_with($haystack, $needles) {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
                return true;
            }
        }
        return false;
    }

}

if (!function_exists('ends_with')) {

    /**
     * Determine se uma determinada string termina com uma determinada substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    function ends_with($haystack, $needles) {
        foreach ((array) $needles as $needle) {
            if (substr($haystack, -strlen($needle)) === (string) $needle) {
                return true;
            }
        }
        return false;
    }

}

/**
 * Exibe os dados
 * @param  mist $data Variável que será "debugada"
 */
function dd($data, $dump = false) {
    echo '<pre>';
    ($dump) ? var_dump($data) : print_r($data);
    echo '</pre>';
}

/**
 * Exibe os dados
 * @param  mist $data Variável que será "debugada"
 */
function debug($data, $dump = false) {
    echo '<pre>';
    ($dump) ? var_dump($data) : print_r($data);
    echo '</pre>';
}

/**
 * Processo de tratamento para o mecanismo MVC
 * 
 * @param string $input     String que será convertida
 * @return string           String convertida
 */
function filteredName($input) {
    $input = explode('?', $input);
    $input = $input[0];

    $find = [
        '-',
        '_'
    ];
    $replace = [
        ' ',
        ' '
    ];
    return str_replace(' ', '', ucwords(str_replace($find, $replace, $input)));
}

function filteredFileName($input) {
    $input = trim($input);

    //Remove " caso exista
    $new = str_replace('&#34;', '', $input);

    $find = [
        '  ', '"', 'á', 'ã', 'à', 'â', 'ª', 'é', 'è', 'ê', 'ë',
        'í', 'ì', 'î', 'ï', 'ó', 'ò', 'õ', 'ô', '°', 'º', 'ö',
        'ú', 'ù', 'û', 'ü', 'ç', 'ñ', 'Á', 'Ã', 'À', 'Â', 'É',
        'È', 'Ê', 'Ë', 'Í', 'Ì', 'Î', 'Ï', 'Ó', 'Ò', 'Õ', 'Ô',
        'Ö', 'Ú', 'Ù', 'Û', 'Ü', 'Ç', 'Ñ'
    ];

    $replace = [
        '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i',
        'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u',
        'u', 'u', 'c', 'n', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E',
        'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U',
        'U', 'C', 'N'
    ];

    return strtolower(str_replace(' ', '_', str_replace($find, $replace, $new)));
}

function decamelize($cameled, $sep = '-') {
    return implode(
            $sep, array_map(
                    'strtolower', preg_split('/([A-Z]{1}[^A-Z]*)/', $cameled, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY)
            )
    );
}

function associateToObject($ass) {
    if (!is_array($ass))
        return $ass;

    $obj = new \stdClass();

    foreach ($ass as $k => $v) {
        $obj->$k = $v;
    }

    return $obj;
}

/**
 * Verifica se o usuário esta logado.
 * 
 * @return Boolean      Booleano informando se está logado.
 */
function estaLogado() {
    return isset($_SESSION['usuario']);
}

/**
 * Obtem o login da sessão.
 * 
 * @return String       String com o login da sessão
 * */
function getLogin() {
    if (estaLogado()) {
        return $_SESSION['usuario']->email;
    }
    return NULL;
}

/**
 * Obtem os dados da sessao do usuário logado.
 * @return Object
 * */
function getDadosSessao() {
    if (estaLogado()) {
        $dados = associateToObject($_SESSION['info']);
        $dados->login = getLogin();
        return $dados;
    }
    return NULL;
}

/**
 * Obtem uma string com a numeração dos grupos do sistema.
 * @return String
 * */
function getGrupoSistema() {
    $temp = str_replace("[", "", Template::$idturma);
    $temp = str_replace("]", "", $temp);

    return $temp;
}

function padronizaNome($str) {
    $search = array(
        "Á", "À", "Â", 'Ä', "Ã",
        "É", "È", "Ê", "Ë",
        "Í", "Ì", "Î", "Ï",
        "Ó", "Ò", "Ô", "Ö", "Õ",
        "Ú", "Ù", "Û", "Ü",
        "Ç", "\'"
    );

    $searchmin = array(
        "á", "à", "â", 'ä', "ã",
        "é", "è", "ê", "ë",
        "í", "ì", "î", "ï",
        "ó", "ò", "ô", "ö", "õ",
        "ú", "ù", "û", "ü",
        "ç", "\""
    );

    $replace = array(
        "A", "A", "A", "A", "A",
        "E", "E", "E", "E",
        "I", "I", "I", "I",
        "O", "O", "O", "O", "O",
        "U", "U", "U", "U",
        "C", " ");

    $replacemin = array(
        "a", "a", "a", "a", "a",
        "e", "e", "e", "e",
        "i", "i", "i", "i",
        "o", "o", "o", "o", "o",
        "u", "u", "u", "u",
        "c", " ");

    $nomeP = str_replace($search, $replace, $str);
    $nomeP = str_replace($searchmin, $replacemin, $nomeP);

    //return(strtoupper($nomeP));
    return $nomeP;
}

/**
 * Obtem informações do visitante como IP, Navegador, Versão do Navegador, Sistema Operacional, Dispositivo, Linguagem
 *
 * @return Array
 */
function getDadosVisitante() {
    $browser = new Sinergi\BrowserDetector\Browser();
    $os = new Sinergi\BrowserDetector\Os();
    $device = new Sinergi\BrowserDetector\Device();
    $language = new Sinergi\BrowserDetector\Language();

    $ip = getIp();

    return [
        "navegador" => $browser->getName(),
        "navegador_versao" => $browser->getVersion(),
        "ip" => $ip,
        "so" => $os->getName(),
        "so_versao" => $os->getVersion(),
        "linguagem" => $language->getLanguage(),
        "mobile" => $os->isMobile(),
        "dispositivo" => $device->getName()
    ];
}

/**
 * Obtem a localização pelo IP informado
 * 
 * @param type $ip
 * @return type
 */
function getLocalizacao($ip) {
    $localizacao = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
    return getValue($localizacao);
}

/**
 * Obtem uma string com o Navegador e a versao do usuario
 * @return String
 * */
function getNavegador() {
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    if (preg_match('|MSIE ([0-9].[0-9]{1,2})|', $useragent, $matched)) {
        $browser_version = $matched[1];
        $browser = 'IE';
    } elseif (preg_match('|Trident/([0-9].[0-9]{1,2})|', $useragent, $matched)) {
        $browser_version = $matched[1];
        $browser = 'IE';
    } elseif (preg_match('|Opera/([0-9].[0-9]{1,2})|', $useragent, $matched)) {
        $browser_version = $matched[1];
        $browser = 'Opera';
    } elseif (preg_match('|Opera Mini/([0-9].[0-9]{1,2})|', $useragent, $matched)) {
        $browser_version = $matched[1];
        $browser = 'Opera Mini';
    } elseif (preg_match('|Firefox/([0-9\.]+)|', $useragent, $matched)) {
        $browser_version = $matched[1];
        $browser = 'Firefox';
    } elseif (preg_match('|Chrome/([0-9\.]+)|', $useragent, $matched)) {
        $browser_version = $matched[1];
        $browser = 'Chrome';
    } elseif (preg_match('|Safari/([0-9\.]+)|', $useragent, $matched)) {
        $browser_version = $matched[1];
        $browser = 'Safari';
    } else {
        // browser not recognized!
        $browser_version = 0;
        $browser = 'other';
    }

    return "$browser $browser_version";
}

/**
 * Obtem o número ip do usuário.
 * @return String
 * */
function getIp() {
    return getenv("REMOTE_ADDR");
}

/**
 * Obtem a data atual no formato yyyy-mm-dd.
 * @return String
 * */
/* function getDate() {
  return date("Y-m-d");
  } */

/**
 * Obtem a data atual no formato dd/mm/yyyy.
 * @return String
 * */
function getDateBr() {
    return date("d/m/Y");
}

/**
 * Obtem a hora atual no formato hh:mm:ss.
 * @return String
 * */
function getTime() {
    return date("H:i:s");
}

/**
 * Obtem a data e hora atual no formato yyyy-mm-dd hh:mm:ss.
 * @return String
 * */
function getDateTime() {
    return date("Y-m-d H:i:s");
}

/**
 * Obtem a data e hora atual no formato dd-mm-yyyy hh:mm:ss.
 * @return String
 * */
function getDateTimeBr() {
    return date("d/m/Y H:i:s");
}

/**
 * Tirando a mascara do cpf e completando com zero a esquerda
 * @return String
 * */
function cpfSemMascara($cpf) {
    if (empty($cpf)) {
        return $cpf;
    }

    $novoCpf = str_replace(".", "", $cpf);
    $novoCpf = str_replace("-", "", $novoCpf);
    while (strlen($novoCpf) < 11) {
        $novoCpf = "0" . $novoCpf;
    }

    return $novoCpf;
}

/**
 * Colocando a mascara do cpf e completando com zero a esquerda
 * @return String
 * */
function cpfComMascara($cpf) {
    if (empty($cpf)) {
        return $cpf;
    }

    while (strlen($cpf) < 11) {
        $cpf = "0" . $cpf;
    }
    $cpf = substr($cpf, 0, 3) . "." . substr($cpf, 3, 3) . "." . substr($cpf, 6, 3) . "-" . substr($cpf, 9);

    return $cpf;
}

/**
 * Colocando a mascara do cpf e completando com zero a esquerda
 * 
 * @return Boolean
 * */
function validarCpf($cpf) {
    return Respect\Validation\Validator::cpf()->validate($cpf);
}

/**
 * Colocando a mascara (00) 0000-0000 no telefone ou (00) 0000-00000 para celular
 *
 * @return String
 * */
function telefoneComMascara($telefone) {
    switch (strlen($telefone)) {
        case 8:
            $a = substr($telefone, 0, 4);
            $b = substr($telefone, 4);

            $telefone = '(11) ' . $a . '-' . $b;

            break;
        case 9:
            $a = substr($telefone, 0, 4);
            $b = substr($telefone, 4);

            $telefone = '(11) ' . $a . '-' . $b;

            break;
        case 0:
            $telefone = '(00) 0000-0000';

            break;
    }

    return $telefone;
}

/**
 * Colocando a data no FORMATA YYYY-MM-DD
 * @return String
 * */
function dataBanco($data) {
    if (empty($data)) {
        return $data;
    }

    $dia = substr($data, 0, 2);
    $mes = substr($data, 3, 2);
    $ano = substr($data, 6);
    $datafinal = $ano . "-" . $mes . "-" . $dia;
    return $datafinal;
}

/**
 * Colocando a data no FORMATA YYYY-MM-DD hh:mm:ss.
 * @return String
 * */
function dataHoraBanco($data) {
    if (empty($data)) {
        return $data;
    }

    $dia = substr($data, 0, 2);
    $mes = substr($data, 3, 2);
    $ano = substr($data, 6, 4);
    $hora = substr($data, 10);
    $datafinal = $ano . "-" . $mes . "-" . $dia . " " . $hora;
    return $datafinal;
}

/**
 * Colocando a data no FORMATO DD/MM/YYYY
 * @return String
 * */
function dataBr($data) {
    if (empty($data)) {
        return $data;
    }
    $dia = substr($data, 8, 2);
    $mes = substr($data, 5, 2);
    $ano = substr($data, 0, 4);
    $datafinal = $dia . "/" . $mes . "/" . $ano;
    return $datafinal;
}

/**
 * DateTime para Date
 * @return String
 * */
function dateTimeToDate($data) {
    if (empty($data)) {
        return $data;
    }

    if (strlen($data) == 10) {
        return $data;
    }

    $data = explode(" ", $data);

    return $data[0];
}

/**
 * DateTime para Time
 * @return String
 * */
function dateTimeToTime($data) {
    if (empty($data)) {
        return $data;
    }

    $data = explode(" ", $data);

    return $data[1];
}

/**
 * Colocando a data no FORMATO DD/MM/YYYY hh:mm:ss.
 * @return String
 * */
function dataHoraBr($data) {
    if (empty($data)) {
        return $data;
    }
    $ano = substr($data, 0, 4);
    $mes = substr($data, 5, 2);
    $dia = substr($data, 8, 2);
    $hora = substr($data, 10);

    $datafinal = $dia . "/" . $mes . "/" . $ano . " " . $hora;
    return $datafinal;
}

/**
 * Comparando as datas Assumido que $dataEntrada e $dataSaida estao em formato DD/MM/YYYY.
 *
 * @param String $dataEntrada Espeara a string no formato DD/MM/YYYY.
 * @param String $dataSaida Espeara a string no formato DD/MM/YYYY.
 *
 * @return String
 * */
function comparaDatas($dataEntrada, $dataSaida) {

    if (is_null($dataEntrada) AND is_null($dataSaida)) {
        return 'igual';
    }

    $timeZone = new \DateTimeZone('UTC');

    /** Assumido que $dataEntrada e $dataSaida estao em formato dia/mes/ano */
    $data1 = \DateTime::createFromFormat('d/m/Y', $dataEntrada, $timeZone);
    $data2 = \DateTime::createFromFormat('d/m/Y', $dataSaida, $timeZone);

    /** Testa se sao validas */
    if (!($data1 instanceof \DateTime)) {
        return -1;
    }

    if (!($data2 instanceof \DateTime)) {
        return -1;
    }

    if ($data1 > $data2) {
        return 'maior';
    }

    if ($data1 == $data2) {
        return 'igual';
    }

    if ($data1 < $data2) {
        return 'menor';
    }
}

/**
 * Converte uma string em Data assumido que a string $stringData esteja no formato DD/MM/YYYY.
 *
 * @param String $stringData Espera a string no formato DD/MM/YYYY.
 *
 * @return DateTime
 * */
function stringToDate($stringData) {
    $timeZone = new \DateTimeZone('UTC');

    $data = \DateTime::createFromFormat('d/m/Y', $stringData, $timeZone);

    return $data;
}

/**
 * Converte uma string em DataTime assumido que a string $stringDataTime esteja no formato DD/MM/YYYY 00:00:00.
 *
 * @param String $stringDataTime Espera a string no formato DD/MM/YYYY 00:00:00.
 *
 * @return DateTime
 * */
function stringToDateTime($stringDataTime) {
    $timeZone = new \DateTimeZone('UTC');

    $data = \DateTime::createFromFormat('d/m/Y H:i:s', $stringDataTime, $timeZone);

    return $data;
}

/**
 * Get script url
 *
 * @return array Retorno o array com a url e get
 * @author Marcelo Vaz de Camargo, Ildo Gomes de Lima, Gleyson Eduardo Oliveira
 */
function getUrlAtual() {
    $protocolo = 'http://';
    if(env('APP_HTTPS')){
        $protocolo = 'https://';
    }
    
    $url = $protocolo .
            $_SERVER['SERVER_NAME'] .
            ($_SERVER['SERVER_PORT'] == 80 ? '' : ':' .
            $_SERVER['SERVER_PORT']) .
            $_SERVER['REQUEST_URI'];

    $get = '';
    if (!strpos($url, '?') === false) {
        list($url, $get) = explode('?', $url);
    }

    return ['url' => $url, 'get' => $get];
}

/**
 * 
 * @param type $string_cifrada
 * @param String $data_hora_string no formato 'YYYY-MM-DD HH:MM'
 * @return string
 */
function decifra($string_cifrada, $data_hora_string) {

    $datetime_expression_array = explode(' ', $data_hora_string);
    $data_string = $datetime_expression_array[0];    // no formato 'YYYY-MM-DD'
    $hora_string = $datetime_expression_array[1];    // no formato 'HH:MM:SS'


    $data_string_array = explode('-', $data_string);
    $mes = $data_string_array[1];    // formato 'MM'
    $dia = $data_string_array[2];    // formato 'DD'

    $hora_string_array = explode(':', $hora_string);
    $hora = $hora_string_array[0];    //formato 'HH'
    $minuto = $hora_string_array[1];   //formato 'MM'
    // Elimina os zeros iniciais (Ex: '02' vai ser alterado para '2')
    $mes = (int) $mes;
    $mes = (string) $mes;
    $dia = (int) $dia;
    $dia = (string) $dia;
    $hora = (int) $hora;
    $hora = (string) $hora;
    $minuto = (int) $minuto;
    $minuto = (string) $minuto;

    //
    //  chaverLI
    //
        //  chaverLI é uma chave gerada em função da data de criação da conta
    //  armazenada na coluna dtcria da tabela CONTA_C.
    //
        //  É constituída por dia, mês, hora e minuto da data de criação, sendo
    //  valores numéricos no formato de um ou dois dígitos (ex: 10, 6, 0, etc).
    //  Sendo assim, não contem valores como "01", "00", "06", etc, para dia,
    //  mês, hora e minuto.
    //
        $chave_rLI = $dia . $mes . $hora . $minuto;

    $pos_LI = $chave_rLI[1];
    $pos_LI = (int) $pos_LI;

    $giro_LI = $string_cifrada[$pos_LI];
    $giro_LI = (int) $giro_LI;

    $decifrando = mb_substr($string_cifrada, 0, $pos_LI) . // ler pos_LI caracteres a partir do início
            mb_substr($string_cifrada, ($pos_LI + 1), 30);

    //echo '<br> decriptando etapa 1: '. $decifrando . '<br>';

    $decifrando = mb_substr($decifrando, (mb_strlen($decifrando) - $giro_LI), 30) .
            mb_substr($decifrando, 0, (mb_strlen($decifrando) - $giro_LI));

    // echo '<br> decriptando etapa 2: '. $decifrando . '<br>';

    $chave_LA = mb_substr($decifrando, 16, 2) .
            $decifrando[19];


    $chave_dorgLI = ((int) $chave_LA) - 99;


    $tam_La = $decifrando[22] .
            $decifrando[24];

    $tam_LI = ((int) $tam_La) - 57;

    $decifrando = mb_substr($decifrando, 0, 16) .
            $decifrando[18] .
            mb_substr($decifrando, 20, 2) .
            $decifrando[23];


    $chave_dLI = $chave_dorgLI; // int
    $string_decifrada = '';


    $cLI = 0;
    for ($i = 0; $i < $tam_LI; $i++) {
        $caractere_atual = $decifrando[$i];
        //echo '<br> caracter atual: '.$caractere_atual. '<br>';
        $cLI = ord($caractere_atual);
        $cLI = $cLI - $chave_dLI;
        while ($cLI < 32) {
            $cLI = $cLI + 95;
        }
        $string_decifrada = $string_decifrada . chr($cLI);
        $chave_dLI = $chave_dLI + $cLI;
        while ($chave_dLI > 900) {
            $chave_dLI = $chave_dLI - 900;
        }
    }
    return $string_decifrada;
}

function getDriversPDO() {
    return \PDO::getAvailableDrivers();
}

function fotoUpload($nome, $pasta) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //$pasta = ESTRUTURA_PATH . '..' . DS . 'docs' . DS . 'informes' . DS;

        $handle = new \Verot\Upload\Upload($_FILES['foto'], 'pt_BR');
        if ($handle->uploaded) {
            $handle->file_new_name_body = $nome;
            $handle->file_overwrite = true;
            $handle->file_max_size = '5M';
            $handle->allowed = array('image/*');
            $handle->file_new_name_ext = 'jpg';

//            $handle->image_resize = true;
//            $handle->image_x = 500;
//            $handle->image_ratio_y = true;

            $handle->process($pasta);
            if ($handle->processed) {
                $handle->clean();

                return [
                    "sucesso" => TRUE,
                    "msg" => '<li>Upload realizado com sucesso.</li>'
                ];
            } else {
                return [
                    "sucesso" => FALSE,
                    "msg" => "<li>$handle->error</li>"
                ];
            }
        }
    }
}

/**
 * crypt AES 256
 *
 * @param data $data
 * @param string $password
 * @return base64 criptografado data
 */
function encrypt($data, $password) {
    // Definir um salt aleatório
    $salt = openssl_random_pseudo_bytes(16);

    $salted = '';
    $dx = '';
    // Salt the key(32) and iv(16) = 48
    while (strlen($salted) < 48) {
        $dx = hash('sha256', $dx . $password . $salt, true);
        $salted .= $dx;
    }

    $key = substr($salted, 0, 32);
    $iv = substr($salted, 32, 16);

    $encrypted_data = openssl_encrypt($data, 'AES-256-CBC', $key, true, $iv);
    return base64_encode($salt . $encrypted_data);
}

/**
 * decrypt AES 256
 *
 * @param data $edata
 * @param string $password
 * @return descriptografado data
 */
function decrypt($edata, $password) {
    $data = base64_decode($edata);
    $salt = substr($data, 0, 16);
    $ct = substr($data, 16);

    $rounds = 3; // depende do tamanho da chave
    $data00 = $password . $salt;
    $hash = array();
    $hash[0] = hash('sha256', $data00, true);
    $result = $hash[0];
    for ($i = 1; $i < $rounds; $i++) {
        $hash[$i] = hash('sha256', $hash[$i - 1] . $data00, true);
        $result .= $hash[$i];
    }
    $key = substr($result, 0, 32);
    $iv = substr($result, 32, 16);

    return openssl_decrypt($ct, 'AES-256-CBC', $key, true, $iv);
}

/**
 *  Converte a string para letras minusculas
 * 
 * @param string $string
 * @return string 
 */
function minuscula($string) {
    return strtolower($string);
}

/**
 * Converte a string para letras maiusculas
 * 
 * @param string $string
 * @return string
 */
function maiuscula($string) {
    return strtoupper($string);
}

/**
 * Retorno o $_POST do campo informado 
 * 
 * @param string $campo
 * @return string
 */
function getPost($campo) {
    return (isset($_POST[$campo])) ? $_POST[$campo] : NULL;
}

/**
 * Retorna o $_GET do compo informado
 * 
 * @param string $campo
 * @return string
 */
function getGet($campo) {
    return (isset($_GET[$campo])) ? $_GET[$campo] : NULL;
}

/**
 * Retorna o valor informado se existir
 * 
 * @param string $campo
 * @return string
 */
function getValue($campo) {
    return (isset($campo) && !empty($campo)) ? $campo : NULL;
}

/**
 * Cria um identificador de 32 caracteres(a 128 bit hex number) que é extremamente dificil de prever.
 * 
 * @return string 32 caracteres
 */
function gerarToken() {
    return md5(uniqid(rand(), true));
}

/**
 * Verifica se é um E-mail válido
 * 
 * @return string 32 caracteres
 */
function validarEmail($email) {
    $email = strip_tags(trim($email));

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Função simples para ordenar uma matriz[][] por uma chave específica. Mantém associação de índice.
 * 
 * @param type $array para Ordenar
 * @param type $on Campo para Ordenar
 * @param type $order SORT_ASC ou SORT_DESC
 * @return type
 */
function array_sort($array, $on, $order = SORT_ASC) {
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

/*
 * EXEMPLO de COMO USAR O a funcao array_sort()
 * 
  $people = array(
  12345 => array(
  'id' => 12345,
  'first_name' => 'Joe',
  'surname' => 'Bloggs',
  'age' => 23,
  'sex' => 'm'
  ),
  12346 => array(
  'id' => 12346,
  'first_name' => 'Adam',
  'surname' => 'Smith',
  'age' => 18,
  'sex' => 'm'
  ),
  12347 => array(
  'id' => 12347,
  'first_name' => 'Amy',
  'surname' => 'Jones',
  'age' => 21,
  'sex' => 'f'
  )
  );

  print_r(array_sort($people, 'age', SORT_DESC)); // Sort by oldest first
  print_r(array_sort($people, 'surname', SORT_ASC)); // Sort by surname
 */

/**
 * Função que elimina as linhas duplicadas de um array[][] por uma chave específica.
 * 
 * @param Array $array
 * @param String $campo
 * 
 * @return Array
 */
function array_unique_multidimensional($array, $campo) {
    $tempArr = array_unique(array_column($array, $campo));
    return array_intersect_key($array, $tempArr);
}

/**
 * Função que verifica se o usuario pertence ao grupo administradores master do sistema
 * 
 * @return Boolean
 */
function isAdminMaster() {
    $grupo = new App\Model\Grupo();    
    
    if(isset($_SESSION['usuario']->id)){
        $grupo_master = $grupo->getUsuarioFromGrupo($_SESSION['usuario']->id, 1);
        if (isset($grupo_master->usuarios_id) && !empty($grupo_master->usuarios_id)) {
            return TRUE;
        }
    }

    return FALSE;
}

//   function email(Array $dados)
//   {
//
//   //use \PHPMailer\src\PHPMailer;
//  // use PHPMailer\PHPMailer\Exception;
//      require 'vendor/phpmailer/phpmailer/src/Exception.php';
//      require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
//      require 'vendor/phpmailer/phpmailer/src/SMTP.php';
//
//      $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
//      try {
//         //Server settings
//         $mail->SMTPDebug = 2;                                 // Enable verbose debug output
//         $mail->isSMTP();                                      // Set mailer to use SMTP
//         $mail->Host = env('MAIL_HOST');                       // Specify main and backup SMTP servers
//         $mail->SMTPAuth = true;                               // Enable SMTP authentication
//         $mail->Username = env('MAIL_USUARIO');                 // SMTP username
//         $mail->Password = env('Geth@2018!');                           // SMTP password
//         $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
//         $mail->Port = 587;   // 465 or 587                                 // TCP port to connect to
//
//         //Recipients
//         $mail->setFrom(env('MAIL_USUARIO') , 'Mailer');
//         $mail->addAddress($dados['para']);     // Add a recipient
//         // $mail->addReplyTo('info@example.com', 'Information');
//         //$mail->addCC('cc@example.com');
//         // $mail->addBCC('bcc@example.com');
//
//         //Attachments
//         // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//         //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//
//         //Content
//         $mail->isHTML(true);                                  // Set email format to HTML
//         $mail->Subject = $dados['titulo'];
//         $mail->Body = $dados['mensagem'];
//         //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//
//         $mail->send();
//         echo 'Mensagem enviada';
//      } catch (Exception $e) {
//         echo 'A mensagem não pôde ser enviada.  Mailer Error: ' , $mail->ErrorInfo;
//      }
//   }
