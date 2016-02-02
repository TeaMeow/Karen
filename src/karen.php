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

class Karen
{
    static $language     = false;
    static $urlPrefix    = 'lang';
    static $cookiePrefix = 'karen_language';
    static $languagePath = '';
    static $library      = [];
    
    static function initialize($languagePath)
    {
        self::$languagePath = $languagePath;
        
        self::detect();
        self::loadLanguage();
    }
    
    static function getString($token)
    {
        return isset(self::$library[$token]) ? self::$library[$token] : null;
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