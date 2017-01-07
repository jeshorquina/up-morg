<?php
namespace Jesh\Core\Helpers;
   
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
* This class serves as a helper for the
* database connection in CI (i.e. to 
* be able to read from YAML file)
*
* @author Jeshurun Orquina <jeshorquina@gmail.com>
*/
class DatabaseHelper {

    const DSN           = '';
    const HOSTNAME      = 'localhost';
    const USERNAME      = '';
    const PASSWORD      = '';
    const DATABASE      = '';
    const DBDRIVER      = 'mysqli';
    const DBPREFIX      = '';
    const PCONNECT      = FALSE;
    const CACHE_ON      = FALSE;
    const CACHEDIR      = '';
    const CHAR_SET      = 'utf8';
    const DBCOLLAT      = 'utf8_general_ci';
    const SWAP_PRE      = '';
    const ENCRYPT       = FALSE;
    const COMPRESS      = FALSE;
    const STRICTION     = FALSE;
    const FAILOVER      = array();
    const SAVE_QUERIES  = TRUE;

    private static $config_array;

    /**
    * Constructor for the helper.
    *
    * @param String $config_file A String containing the path to the config file
    */
    public function __construct($config_file)
    {
        try {
            self::$config_array = Yaml::parse(file_get_contents($config_file))["database"];
        }
        catch (ParseException $e) {
            printf("Unable to parse the YAML String: %s", $e->getMessage());
        }
    }

    /**
    * Returns the default active group from
    * the YAML file configuration.
    *
    * @return String A String containing the default active group
    */
    public function getDefaultActiveGroup() {
        if (array_key_exists('active_group', self::$config_array)) {
            return self::$config_array['active_group'];
        }
        else {
            return 'default';
        }
    }

    /**
    * Returns the query builder value from
    * the YAML file configuration.
    *
    * @return Bool A Boolean containing if quey builder is enabled
    */
    public function isQueryBuilderEnabled()
    {
        if (array_key_exists('query_builder', self::$config_array)) {
            return (bool) self::$config_array['query_builder'];
        }
        else {
            return TRUE;
        }
    }

    /**
    * Builds the database groups from 
    * the YAML configuration file.
    *
    * @return Array An array containing the database groups
    *
    * @throws Exception If building group is unsuccessful
    */
    public function buildGroups()
    {
        if(sizeof(self::$config_array["groups"]) === 0) {
            throw new \Exception("No database group defined.");
        }        
        if(!array_key_exists('default', self::$config_array["groups"])) {
            throw new \Exception("No default database group defined.");
        }

        $constants = (New \ReflectionClass(get_class()))->getConstants();
        $db = array();
        foreach(self::$config_array["groups"] as $group_name => $group_properties) {
            $db[$group_name] = self::populateArrayWithDefaultValues();
            foreach($group_properties as $group_key => $group_value) {
                if(array_key_exists(strtoupper($group_key), $constants)) {
                    $db[$group_name][strtolower($group_key)] = $group_value;
                }
                else {
                    throw new \Exception("Could not define custom database group property.");
                }
            }
        }
        return $db;
    }

    /**
    * Creates an array with the default values 
    * of a CI database group.
    *
    * @return Array An array containing the default 
    *         values for a database group
    */
    private static function populateArrayWithDefaultValues()
    {
        $array = array();
        foreach((New \ReflectionClass(get_class()))->getConstants() as $constant_key => $constant_value) {
            $array[strtolower($constant_key)] = $constant_value;
        }
        return $array;
    }
}