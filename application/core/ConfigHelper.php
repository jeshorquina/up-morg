<?php
namespace Jesh\Core;
    
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
* This class serves as a helper for the
* config in CodeIgniter (i.e. to be 
* able to read from a YAML file)
*
* @author Jeshurun Orquina <jeshorquina@gmail.com>
*/
class ConfigHelper {

    const BASE_URL                  = '';
    const INDEX_PAGE                = 'index.php';
    const URI_PROTOCOL              = 'REQUEST_URI';
    const URL_SUFFIX                = '';
    const LANGUAGE                  = 'english';
    const CHARSET                   = 'UTF-8';
    const ENABLE_HOOKS              = FALSE;
    const SUBCLASS_PREFIX           = 'MY_';
    const PERMITTED_URI_CHARS       = 'a-z 0-9~%.:_\-';
    const ALLOW_GET_ARRAY           = TRUE;
    const ENABLE_QUERY_STRINGS      = FALSE;
    const CONTROLLER_TRIGGER        = 'c';
    const FUNCTION_TRIGGER          = 'f';
    const DIRECTORY_TRIGGER         = 'd';
    const LOG_THRESHOLD             = 0;
    const LOG_PATH                  = '';
    const LOG_FILE_EXTENSION        = 'log';
    const LOG_FILE_PERMISSIONS      = 0644;
    const LOG_DATE_FORMAT           = 'Y-m-d H:i:s';
    const ERROR_VIEWS_PATH          = '';
    const CACHE_PATH                = '';
    const CACHE_QUERY_STRING        = FALSE;
    const ENCRYPTION_KEY            = '';
    const SESS_DRIVER               = 'files';
    const SESS_COOKIE_NAME          = 'ci_session';
    const SESS_EXPIRATION           = 7200;
    const SESS_SAVE_PATH            = NULL;
    const SESS_MATCH_IP             = FALSE;
    const SESS_TIME_TO_UPDATE       = 300;
    const SESS_REGENERATE_DESTROY   = FALSE;
    const COOKIE_PREFIX             = '';
    const COOKIE_DOMAIN             = '';
    const COOKIE_PATH               = '/';
    const COOKIE_SECURE             = FALSE;
    const COOKIE_HTTPONLY           = FALSE;
    const STANDARDIZE_NEWLINES      = FALSE;
    const GLOBAL_XSS_FILTERING      = FALSE;
    const CSRF_PROTECTION           = FALSE;
    const CSRF_TOKEN_NAME           = 'ci_csrf_token';
    const CSRF_COOKIE_NAME          = 'ci_csrf_cookie';
    const CSRF_EXPIRE               = 7200;
    const CSRF_REGENERATE           = TRUE;
    const CSRF_EXCLUDE_URIS         = array();
    const COMPRESS_OUTPUT           = FALSE;
    const TIME_REFERENCE            = 'local';
    const REWRITE_SHORT_TAGS        = FALSE;
    const PROXY_IPS                 = array();

    private static $config_array;

    /**
    * Constructor for the helper.
    *
    * @param String $config_file A String containing the path to the config file
    */
    public function __construct($config_file)
    {
        try {
            self::$config_array = Yaml::parse(file_get_contents($config_file))["system"];
        }
        catch (ParseException $e) {
            printf("Unable to parse the YAML String: %s", $e->getMessage());
        }
    }

    /**
    * Gets the configuration from the YAML file. Defaults to a 
    * value if not specified in the YAML file.
    *
    * @param String $config_key A String containing the configuration key
    *
    * @return mixed The configuration key value
    */
    public function getConfig($config_key)
    {
        if(array_key_exists(strtolower($config_key), self::$config_array)) {
            return self::$config_array[strtolower($config_key)];
        }

        try {
            return self::getDefaultValue($config_key);
        }
        catch(\Exception $e) {
            printf("Unable to prepare configs: %s", $e->getMessage());
        }
    }

    /**
    * Gets the default value for the 
    * configuration key specified. 
    *
    * @param String $config_key A String containing the configuration key
    *
    * @return mixed The configuration key value
    *
    * @throws Exception If configuration key is not found in the class 
    *         (i.e. custom configuration key)
    */
    private static function getDefaultValue($config_key)
    {
        foreach((New \ReflectionClass(get_class()))->getConstants() as $constant_name => $constant_value) {
            if(strtolower($config_key) === strtolower($constant_name)) {
                return $constant_value;
            }
        }
        throw new \Exception("Cannot define custom config property: $config_key");
    }
}