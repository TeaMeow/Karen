<?php
function __($token)
{
    return Karen::getString($token);
}

function _e($token)
{
    echo Karen::getString($token);
}

function _n($token, $number)
{
    
}

function _en($token, $number)
{
    $isArray = is_array(Karen::getString());
    
    if(!$isArray)
        echo Karen::getString($token);
    
    if($number == 0 || $number == 1)
        echo Karen::getString($token)[0];
    else
        echo Karen::getString($token)[1];
}

class Karen
{
    static $language     = false;
    static $urlPrefix    = 'lang';
    static $cookiePrefix = 'karen_language';
    static $languagePath = '';
    static $library      = [];
    
    function initialize($languagePath)
    {
        self::$languagePath = $languagePath;
        
        self::detect();
        self::loadLanguage();
    }
    
    static function validateISO($value)
    {
        return preg_match('/^[a-zA-Z]{2}(_[a-zA-Z]{2})?$/', $value);
    }
    
    
    static function loadLanguage()
    {
        $path = self::$languagePath . self::$language . '.php';

        if(file_exists($path))
        {
            require($path);
            
            self::$library = $library;
        }
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