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
    /**
     * Language
     * 
     * The main language.
     * 
     * @var string
     */
     
    static $language = '';
    
    /**
     * Default Language
     * 
     * The default language, when there's no translated string for the main language,
     * we search the library of the default language.
     * 
     * @var string
     */
     
    static $defaultLanguage = '';
    
    /**
     * Url Prefix
     * 
     * The GET parameter to change the current main language.
     * 
     * @var string
     */
     
    static $urlPrefix = 'lang';
    
    /**
     * Cookie Prefix
     * 
     * The name of the cookie to change the current main language.
     * 
     * @var string
     */
     
    static $cookiePrefix = 'karen_language';
    
    /**
     * Language Path
     * 
     * The path of the language files.
     * 
     * @var string
     */
     
    static $languagePath = '';
    
    /**
     * Text Domain
     * 
     * The current text domain.
     * 
     * @var string
     */
     
    static $textDomain = 'default';
    
    /**
     * Library
     * 
     * Stores the translated strings.
     * 
     * @var array
     */
     
    static $library = [];
    
    /**
     * Default Library
     * 
     * Stores the translated strings of the default language.
     * 
     * @var array
     */
     
    static $defaultLibrary = [];
    
    
    
    
    /**
     * Initialize
     * 
     * Initialize Karen with the language path and the default language.
     * 
     * @param string $languagePath      The path of the language folder.
     * @param string $defaultLanguage   The default language, ex: en_us, zh_tw.
     */
    
    static function initialize($languagePath, $defaultLanguage)
    {
        self::$languagePath = $languagePath;
        self::$defaultLanguage = $defaultLanguage;
        
        self::detect();
        self::loadLanguage();
        self::loadLanguage(true);
    }
    
    
    
    
    /**
     * Get String
     * 
     * Get the translated string.
     * 
     * @param  string $token   The keyword of the translated string.
     * 
     * @return string          The transalted string or just a original token 
     *                         if there's no transled string.
     */
     
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
    
    
    
    
    /**
     * Validate ISO
     * 
     * Make sure the string is valid with the ISO-639 and ISO-3166.
     * 
     * @param string $value   The value to check.
     * 
     * @return bool
     */
    
    static function validateISO($value)
    {
        return preg_match('/^[a-zA-Z]{2}(_[a-zA-Z]{2})?$/', $value);
    }
    
    
    
    
    /**
     * Switch Language
     * 
     * Fuck cookie and the GET parameter, force to use this language instead.
     * 
     * @param string $language   Again, some thing like en_us or zh_tw.
     */
     
    static function switchLanguage($language)
    {
        self::$language = $language;
        self::loadLanguage();
    }
    
    
    
    
    /**
     * Parse String
     * 
     * Replace the template tag ({@tag}) with the actual value.
     * 
     * @param string $string      The original string.
     * @param array  $variables   Key as the tag name, value as the actual value.
     * 
     * @return string
     */
     
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
    
    
    
    
    /**
     * Load Language
     * 
     * Load the language and import the translated strings 
     * if the language file does exist.
     * 
     * @param bool $default   Set true to load the default language library instead of load 
     *                        the library of the current language.
     */
    
    static function loadLanguage($default = false)
    {
        $language = $default ? self::$defaultLanguage : self::$language;
        $path     = self::$languagePath . $language . '/' . self::$textDomain . '.php';

        if(file_exists($path))
        {
            require($path);
            
            if($default)
                self::$library        = $library;
            else
                self::$defaultLibrary = $library;
        }
    }
    
    
    
    
    /**
     * Text Domain
     * 
     * Switch the text domain.
     * 
     * @param string|null $domainName   The name of the domain, set to default when null.
     */
    
    static function textDomain($domainName = null)
    {
        self::$textDomain = $domainName ?: 'default';
        self::loadLanguage();
    }
    
    
    
    
    /**
     * Detect
     * 
     * Detect the language which the current user is using.
     */
     
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