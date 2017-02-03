<?php
namespace Jesh\Core\Helpers;
    
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
* This class serves as a wrapper for the
* routing in CodeIgniter (i.e. to be 
* able to read from a YAML file)
*
* @author Jeshurun Orquina <jeshorquina@gmail.com>
*/
class RoutesHelper 
{
    /**
    * Initializer for the wrapper.
    *
    * Usage:
    * <code>
    *  (New RoutesWrapper())::Init($route);
    * </code> 
    *
    * @param array &$route An array reference to the $route variable in CI
    */
    public function Init(&$route)
    {
        try 
        {
            $routes = self::readFromFile();

            foreach($routes as $route_name => $route_properties) 
            {
                $route_name = self::mutateRouteName($route_name);
                $route[$route_name] = self::getRouteHandler($route_name, $route_properties);
            }
        } 
        catch (ParseException $e) 
        {
            printf("Unable to parse the YAML String: %s", $e->getMessage());
        }
        catch (\Exception $e) 
        {
            printf("Unable to prepare routes: %s", $e->getMessage());
        }
        
        self::handleUndefinedRoutes($route);
    }

    /**
     * Wraps the YAML file parser of Symfony and
     * returns an array of the routes.
     * 
     * @param String $routes_file A String containing the filename of the routes file
     * @return array The array obtained from the YAML file
     */
    private static function readFromFile($routes_file = 'routes.yml')
    {
        return Yaml::parse(file_get_contents(FCPATH.$routes_file));
    }

    /**
     * Mutates the route name into a processable
     * String by the CodeIgniter routing.
     * 
     * @param String $route_name A String containing the route name to be mutated
     * @return String The mutated route name
     */
    private static function mutateRouteName($route_name)
    {
        if(strtolower($route_name) === 'index') 
        {
            return 'default_controller';
        }

        if(substr($route_name, -1) == '/') 
        {
            return substr($route_name, 0, -1);
        }
        else 
        {
            return $route_name;
        }
    }

    /**
     * Prepares the route value for the
     * CodeIgniter routing.
     * 
     * @param String &$route_name A referenced String containing the route name
     * @param array  $route_properties An array contaning the properties of the route value
     *
     * @return String The prepared route value
     *
     * @throws Exception If the config file contains invalid route parameter
     */
    private static function getRouteHandler(&$route_name, $route_properties)
    {
        try
        {
            $route_value = '';
            foreach($route_properties as $key => $value) 
            {
                switch(strtolower($key)) 
                {
                    case 'controller':
                        self::appendControllerToRoute($route_value, $value);
                        break;
                    case 'function':
                        self::appendFunctionToRoute($route_value, $value);
                        break;
                    case 'parameter':
                        self::appendParameterToRoute($route_name, $route_value, $value);
                        break;
                    default:
                        throw New Exception("Cannot define custom route parameter: $key");
                }
            }
            return $route_value;
        }
        catch(\Exception $e) 
        {
            throw $e;
        }
    }

    /**
     * Validates controller and appends to the 
     * route value when validated.
     *
     * @param String &$route_value A referenced String for the route value
     * @param String $value A String containing the value to append
     *
     * @return String A String containing the appended value
     *
     * @throws Exception If the controller is not found
     */
    private static function appendControllerToRoute(&$route_value, $value)
    {
        $controller = APPPATH.'controllers/'.$value.'.php';
        if(file_exists($controller)) 
        {
            $route_value = $value;
        }
        else 
        { 
            throw new \Exception("No controller found: $controller");
        }
    }

    /**
     * Validates the function and appends to 
     * the route value when validated.
     *
     * @param String &$route_value A referenced String for the route value
     * @param String $value A String containing the value to append
     *
     * @return String A String containing the appended value
     *
     * @throws Exception If the function is not found
     */
    private static function appendFunctionToRoute(&$route_value, $value)
    {
        require_once FCPATH.'system/core/Controller.php';
        require_once APPPATH.'controllers/'.$route_value.'.php';

        if((new \ReflectionClass($route_value))->hasMethod($value)) 
        {  
            $route_value = sprintf('%s/%s', $route_value, $value);
        }
        else 
        {
            throw new \Exception("No function found: $value");
        }
    }

    /**
     * Validates the parameter and appends to 
     * the route value when validated.
     *
     * @param String &$route_name A referenced String for the route name
     * @param String &$route_value A referenced String for the route value
     * @param String $value A String containing the value to append
     *
     * @return String A String containing the appended value
     *
     * @throws Exception If the parameter is not a supported parameter
     */
    private static function appendParameterToRoute(&$route_name, &$route_value, $value)
    {
        switch(strtolower($value))
        {
            case 'number':
                $route_name = sprintf('%s/%s', $route_name, '(:num)');
                break;
            case 'any':
                $route_name = sprintf('%s/%s', $route_name, '(:any)');
                break;
            default:
                throw new \Exception("No supported parameter of type: $value");
        }
        $route_value = sprintf('%s/%s', $route_value, '$1');
    }

    /**
     * Handles any routes not defined in the 
     * YAML config file.
     *
     * @param Array &$route A referenced Array for the CI route variable
     */
    private static function handleUndefinedRoutes(&$route)
    {
        $route['(:any)'] = 'errors/show_404';
    }
}