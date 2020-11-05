<?php

    require_once 'AdminProductos.php';

    function formatearDinero($dinero) {
        $dinero = floatval($dinero);
        return '$' . money_format('%i', $dinero) . ' M.X.N';
    }

    class ChatBot
    {
        private const ERRORS = ['Debe preguntar algo.', 'No entiendo esa pregunta, comunicate a Cazadores GYM para resolver tus dudas.', 'no conozco el producto.', 'no tengo esa información.'];
        private const SCHEDULE = 'Lunes a Viernes 6am - 10pm.<br>Sabados 7am - 5pm<br>Domigos Cerrado.';
        private const MIN_AGE = 'Podran asisitr personas con una edad mayor a los 16 años.';
        private const PROTEIN_BRANDS = 'Manejamos las marcas:<br>- Nitro Tech.<br>- Muscle Infusion.<br>- HydroWhey.';
        private const PRODUCT_TYPES = 'Bebidas energizantes/hidratantes.<br>Suplementos.<br>Accesorios/Complementos.';
        private const GYMS_PROFESSOR = 'Contamos con 4 instructores, 2 maturinos y 2 vespertino/nocturno.';
        private const SHOWERS = 'De momento no contamos con esas intalaciones, pero se esta viendo la posibilidad de implementarlas.';
        private const MEMBERSHIPS = 'Mensual $350.<br>Trimestral $900.<br>Semestral $1600.<br>Anual $3000.';
        private const MONTHLY = 'La mensualidad cuesta $350.';
        private const BOTNAME = 'Hola, soy GYMBot';

        private const MIN_PERCENT = 80;

        private $products;

        public function __construct()
        {                        
            $adminProducts = new AdminProductos();
            $products = $adminProducts->listarProductos();
            $size_products = $products->size();
            $this->products = [];
            $i = 0;
            while ($i < $size_products) {
                array_push($this->products, new Product(self::clean_str($products->get($i)->getNombre()), $products->get($i++)->getPrecio()));
            }            
        }

        public function process_question(string $question = '') : string
        {            
            if (strlen($question) == 0) {
                return 'Error: ' . self::ERRORS[0];
            }            
            $question = self::clean_str($question);
            $question = self::clean_question($question);            
            if (strlen($question) == 0) {
                return 'Disculpa ' . self::ERRORS[1];
            }
            if (((self::str_contains($question, 'hola'))) || ((self::str_contains($question, 'como')) && (self::str_contains($question, 'llamas')))) {
                return self::BOTNAME;
            }
            // echo '<b>simplified: </b>' . $question . '<br>';
            if (!self::correct_keywords($question, ['anios', 'instructores', 'edad', 'ingresar', 'entrenar', 'abren', 'cierran',
                'horario', 'regaderas', 'banar', 'membresia', 'marcas', 'proteina', 'productos', 'precio',
                'cuesta'])) {
                    return 'Disculpa ' . self::ERRORS[1];
            }
            if (self::str_contains($question, 'instructores')) {
                return self::GYMS_PROFESSOR;
            }
            if (((self::str_contains($question, 'anios')) || (self::str_contains($question, 'edad'))) &&
                 ((self::str_contains($question, 'ingresar')) || (self::str_contains($question, 'entrenar')))) {
                    return self::MIN_AGE;
            }
            if (self::str_contains($question, 'membresia')) {
                return self::MEMBERSHIPS;
            }
            if ((self::str_contains($question, 'abren')) || (self::str_contains($question, 'cierran')) || (self::str_contains($question, 'horario'))) {
                return self::SCHEDULE;
            }
            if ((self::str_contains($question, 'regaderas')) || (self::str_contains($question, 'banar'))) {
                return self::SHOWERS;
            }            
            if ((self::str_contains($question, 'marcas')) && (self::str_contains($question, 'proteina'))) {
                return self::PROTEIN_BRANDS;
            }            
            if (self::str_contains($question, 'productos')) {
                return self::PRODUCT_TYPES;
            }
            if ((self::str_contains($question, 'precio')) || (self::str_contains($question, 'cuesta'))) {                
                $question = self::remove_words(explode(' ', $question), ['precio', 'cuesta']);
                $question = preg_replace('!\s+!', ' ', $question);
                // echo '<b>simplified_product: </b>' . $question . '<br>';
                if (self::str_contains($question, 'mensualidad')) {
                    return self::MONTHLY;
                }
                $str_prices = self::get_price_products(self::search_products($question));
                return (strlen($str_prices) > 0) ? $str_prices : 'Disculpa ' . self::ERRORS[2];
            }            
            return 'Disculpa ' . self::ERRORS[1];;
        }        

        private function get_num_keywords(string $question, array $keywords) : int
        {
            $num_keywords = 0;
            foreach ($keywords as $keyword) {
                if (self::str_contains($question, $keyword)) {
                    $num_keywords++;
                }
            }
            return $num_keywords;
        }

        private function correct_keywords(string $question, array $keywords) : bool
        {
            $num_keywords = self::get_num_keywords($question, $keywords);
            if ($num_keywords == 0) {
                return false;
            } else if ($num_keywords == 1) {
                return true;
            } else if ($num_keywords == 2) {
                if (((self::str_contains($question, 'anios')) || (self::str_contains($question, 'edad'))) &&
                 ((self::str_contains($question, 'ingresar')) || (self::str_contains($question, 'entrenar')))) {
                    return true;
                } else if ((self::str_contains($question, 'marcas')) && (self::str_contains($question, 'proteina'))) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        private function clean_str(string $str = '') : string
        {            
            $str = trim($str);
            $chars_to_replace = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y');
            $str = strtr($str, $chars_to_replace);
            $str = strtolower($str);
            $str = preg_replace('!\s+!', ' ', $str);
            $str = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $str);
            $str = trim($str);
            return $str;
        }

        private function clean_question(string $question = '') : string
        {
            $words_to_clean = ['a', 'con', 'cuanto', 'de', 'el', 'favor', 'hay', 'la', 'las', 'lo', 'los', 'me', 'por', 'que', 'tiene', 'tienen'];
            $question = str_replace(['¿',  '?', 'cuentan'], '', $question);
            $question = self::remove_words(explode(' ', $question), $words_to_clean);
            $question = preg_replace('!\s+!', ' ', $question);
            $question = trim($question);
            return $question;
        }

        private function remove_words(array $words_question, array $words_remove) : string
        {
            foreach ($words_question as $i => $word_question) {
                foreach ($words_remove as $word_remove) {
                    similar_text($word_question, $word_remove, $percent);
                    // echo '<b>Word_question: </b>' . $word_question . ', <b>Word_remove: </b>' . $word_remove . ', <b>Percent: </b>' . $percent . '<br>';
                    if ($percent >= self::MIN_PERCENT) {
                        unset($words_question[$i]);
                        break;
                    }
                }
            }            
            return implode(' ', $words_question);
        }

        private function str_contains(string $source, string $target, bool $explode_target = true) : bool
        {            
            if ($explode_target) {
                $words_source = explode(' ', $source);
                foreach ($words_source as $word) {                    
                    similar_text($word, $target, $percent);
                    // echo '<b>Word: </b>' . $word . ', <b>Target: </b>' . $target . ', <b>Percent: </b>' . $percent . '<br>';
                    if ($percent >= self::MIN_PERCENT) {
                        return true;
                    }
                }
            } else {
                if (strpos($target, $source) !== false) {
                    return true;
                }
                similar_text($source, $target, $percent);
                // echo '<b>Source: </b>' . $source . ', <b>Target: </b>' . $target . ', <b>Percent: </b>' . $percent . '<br>';
                if ($percent >= self::MIN_PERCENT) {
                    return true;
                }
            }            
            return false;
        }

        private function search_products(string $product_name) : array
        {
            $products = [];
            foreach ($this->products as $product) {                
                if (strcmp($product_name, $product->name) == 0) {
                    array_push($products, $product);
                    continue;
                }
                $product_name = preg_replace('!\d+!', '', $product_name);
                $product_name = preg_replace('~\b[a-z]{1,2}\b\s*~', '', $product_name);
                $product_name = trim($product_name);
                if ((self::str_contains($product_name, $product->name, false)) || (self::str_contains($product_name, $product->name, true))) {
                    array_push($products, $product);
                }
            }
            return $products;
        }

        private function get_price_products(array $products) : string
        {
            $str_prices = '';
            foreach ($products as $product) {
                $str_prices .= $product->name . '  ' . formatearDinero($product->price) . '<br>';
            }
            return $str_prices;
        }
    }
    
    class Product
    {
        public $name;
        public $price;

        public function __construct(string $name, float $price) {
            $this->name = $name;
            $this->price = $price;
        }
    }
    
?>