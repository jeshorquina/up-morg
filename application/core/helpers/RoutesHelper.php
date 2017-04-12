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
            $routes = self::ReadFromFile();
            foreach($routes as $route_name => $route_properties) 
            {
                $route_name = self::MutateRouteName($route_name);
                $route[$route_name] = self::GetRouteHandler($route_name, $route_properties);
            }
        } 
        catch (ParseException $e) 
        {
            printf("Unable to parse the YAML String: %s", $e->GetMessage());
        }
        catch (\Exception $e) 
        {
            printf("Unable to prepare routes: %s", $e->GetMessage());
        }
        
        self::HandleUndefinedRoutes($route);
    }

    /**
     * Wraps the YAML file parser of Symfony and
     * returns an array of the routes.
     * 
     * @param String $routes_file A String containing the filename of the routes file
     * @return array The array obtained from the YAML file
     */
    private static function ReadFromFile($routes_file = 'routes.yml')
    {
        return Yaml::parse(file_get_contents(FCPATH.$routes_file));
    }

    /**
     * Mutates the route name into a processable
     * String by the CodeIgniter routing.
     * 
     * @param String $route_name A String containing the route name to be Mutated
     * @return String The Mutated route name
     */
    private static function MutateRouteName($route_name)
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
    private static function GetRouteHandler(&$route_name, $route_properties)
    {
        try
        {
            $route_value = '';
            $has_parent = false;
            foreach($route_properties as $key => $value) 
            {
                switch(strtolower($key)) 
                {
                    case 'directory':
                        self::AppendDirectoryToRoute($route_value, $value);
                        break;
                    case 'controller':
                        self::AppendControllerToRoute($route_value, $value);
                        break;
                    case 'function':
                        self::AppendFunctionToRoute($route_value, $value);
                        break;
                    case 'parent':
                        self::AppendParentParameterToRoute($route_value, $value);
                        $has_parent = true;
                        break;
                    case 'parameter':
                        self::AppendParameterToRoute($route_name, $route_value, $value, $has_parent);
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
     * Validates the directory and Appends to the 
     * route value when validated.
     *
     * @param String &$route_value A referenced String for the route value
     * @param String $value A String containing the value to Append
     *
     * @return String A String containing the Appended value
     *
     * @throws Exception If the controller is not found
     */
    private static function AppendDirectoryToRoute(&$route_value, $value)
    {
        if(file_exists(APPPATH.'controllers/'.$value))
        {
            $route_value = $value;
        }
        else 
        {
            throw new \Exception("No directory found: $directory");
        }
    }

    /**
     * Validates controller and Appends to the 
     * route value when validated.
     *
     * @param String &$route_value A referenced String for the route value
     * @param String $value A String containing the value to Append
     *
     * @return String A String containing the Appended value
     *
     * @throws Exception If the controller is not found
     */
    private static function AppendControllerToRoute(&$route_value, $value)
    {
        $dir = APPPATH.'controllers/';

        if(trim($route_value) === "")
        {
            if(file_exists($dir.$value.'.php'))
            {
                $route_value = $value;
                return;
            }
        }
        else
        {
            if(file_exists($dir.sprintf('%s/%s', $route_value, $value).'.php'))
            {
                $route_value = sprintf('%s/%s', $route_value, $value);
                return;
            }
        }

        throw new \Exception("No controller found: $controller");
    }

    /**
     * Validates the function and Appends to 
     * the route value when validated.
     *
     * @param String &$route_value A referenced String for the route value
     * @param String $value A String containing the value to Append
     *
     * @return String A String containing the Appended value
     *
     * @throws Exception If the function is not found
     */
    private static function AppendFunctionToRoute(&$route_value, $value)
    {
        require_once APPPATH.'controllers/'.$route_value.'.php';

        $controller = '';
        if(strpos($route_value, '/') !== FALSE) 
        {
            $controller = substr($route_value, strpos($route_value, '/') + 1);
        }
        else
        {
            $controller = $route_value;
        }

        if((new \ReflectionClass($controller))->hasMethod($value)) 
        {  
            $route_value = sprintf('%s/%s', $route_value, $value);
        }
        else 
        {
            throw new \Exception("No function found: $value");
        }
    }


    private static function AppendParentParameterToRoute(&$route_value, $value)
    {
        $route_value = sprintf('%s/%s', $route_value, '$1');
    }

    /**
     * Validates the parameter and Appends to 
     * the route value when validated.
     *
     * @param String &$route_name A referenced String for the route name
     * @param String &$route_value A referenced String for the route value
     * @param String $value A String containing the value to Append
     *
     * @return String A String containing the Appended value
     *
     * @throws Exception If the parameter is not a supported parameter
     */
    private static function AppendParameterToRoute(
        &$route_name, &$route_value, $value, $has_parent = false
    ) {
        $key = (!$has_parent) ? '$1' : '$2';

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

        $route_value = sprintf('%s/%s', $route_value, $key);
    }

    /**
     * Handles any routes not defined in the 
     * YAML config file.
     *
     * @param Array &$route A referenced Array for the CI route variable
     */
    private static function HandleUndefinedRoutes(&$route)
    {
        $route['(:any)'] = 'errors/show_404';
    }
}