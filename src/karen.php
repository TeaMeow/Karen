<?php
function __($token)
{
    $isArray = is_array(Karen::getString($token));
    
    return $isArray ? Karen::getString($token)[0] : Karen::getString($token);
}

function _e($token)
{
    echo __($token);
}

function _n($token, $number)
{
    $isArray = is_array(Karen::getString($token));
    
    if(!$isArray)
        return Karen::getString($token);
    
    if($number == 0 || $number == 1)
        return Karen::getString($token)[0];
    else
        return Karen::getString($token)[1];
}

function _en($token, $number)
{
    echo _n($token, $number);
}

function _f($string, $variables)
{
    return Karen::parseString($string, $variables);
}

function _ef($string, $variables)
{
    echo _f($string, $variables);
}



class Karen
{
    static $language     = false;
    static $defaultLanguage     = false;
    static $urlPrefix    = 'lang';
    static $cookiePrefix = 'karen_language';
    static $languagePath = '';
    static $textDomain   = 'default';
    static $library      = [];
    static $defaultLibrary = [];
    
    static function initialize($languagePath, $defaultLanguage)
    {
        self::$languagePath = $languagePath;
        self::$defaultLanguage = $defaultLanguage;
        
        self::detect();
        self::loadLanguage();
        self::loadDefaultLanguage();
    }
    
    static function getString($token)
    {
        if(isset(self::$library[$token]))
            $string = self::$library[$token];
        elseif(isset(self::$defaultLibrary[$token]))
            $string = self::$defaultLibrary[$token];
        else
            $string = $token;
        
        return $string;
    }
    
    
    static function validateISO($value)
    {
        return preg_match('/^[a-zA-Z]{2}(_[a-zA-Z]{2})?$/', $value);
    }
    
    static function switchLanguage($language)
    {
        self::$language = $language;
        self::loadLanguage();
    }
    
    static function parseString($string, $variables)
    {
        $search  = [];
        $replace = [];
        foreach($variables as $name => $value)
        {
            array_push($search, '{@' . $name . '}');
            array_push($replace, $value);
        }

        $string = str_replace($search, $replace, $string);
        
        return $string;
    }
    
    
    
    static function loadLanguage()
    {
        $path = self::$languagePath . self::$language . '/' . self::$textDomain . '.php';

        if(file_exists($path))
        {
            require($path);
            
            self::$library = $library;
        }
    }
    
    static function loadDefaultLanguage()
    {
        $path = self::$languagePath . self::$defaultLanguage . '/' . self::$textDomain . '.php';

        if(file_exists($path))
        {
            require($path);
            
            self::$defaultLibrary = $library;
        }
    }
    
    static function textDomain($domainName = null)
    {
        self::$textDomain = $domainName;
        self::loadLanguage();
    }
    
    static function detect()
    {
        $url    = self::$urlPrefix;
        $cookie = self::$cookiePrefix;

        if(isset($_GET[$url]) && self::validateISO($_GET[$url]))
        {
            self::$language = strtolower($_GET[$url]);
        }    
        elseif(isset($_COOKIE[$cookie]) && self::validateISO($_COOKIE[$cookie]))
        {
            self::$language = strtolower($_COOKIE[$cookie]);
        }
        else
        {
            $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $language  = strtolower($languages[0]);
            $language  = str_replace('-', '_', $language);
            
            if(self::validateISO($language))
                self::$language = $language;
        }
    }
}
?>