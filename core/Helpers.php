<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 7:35 PM
 */

/**
 * @return \Meygh\GithubApi\Console
 */
function Console()
{
    return \Meygh\GithubApi\Console::getInstance();
}

/**
 * @return \Meygh\GithubApi\Application
 */
function App()
{
    return \Meygh\GithubApi\Application::getInstance();
}

/**
 * @return \Meygh\GithubApi\Service
 */
function Service()
{
    return \Meygh\GithubApi\Service::getInstance();
}

/**
 * @return \Meygh\GithubApi\Base\Route
 */
function Route()
{
    return Service()->Route;
}

/**
 * Return a specific array element without any exception.
 *
 * @param array $array
 * @param $index
 * @param null $default
 * @param bool $pop
 * @return mixed|null true to unset after read the array element
 */
function array_get(array &$array, $index, $default = null, $pop = false)
{
    $value = $default;

    if (isset($array[$index])) {
        $value = $array[$index];

        if ($pop) {
            unset($array[$index]);
        }
    }

    return $value;
}

if (!function_exists('dd')) {
    /**
     * Calls var_dump method and exit from rest of program.
     * @param mixed ...$data
     */
    function dd(...$data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die(1);
    }
}

if (!function_exists('pd')) {
    /**
     * Calls print_r method inside <pre> tag.
     * Exit from rest of program if $die = true.
     * @param $data
     * @param bool $die
     */
    function pd($data, $die = true): void
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        if ($die) {
            die(1);
        }
    }
}

if (!function_exists('typecast')) {
    /**
     * Casts of variable types.
     *
     * @param mixed $var by reference
     * @param string $type string|int|float|double|bool|array|object|serialize|unserialize|json|unjson
     */
    function typecast(&$var, $type = 'string')
    {
        switch ($type) {
            case 'string':
            default:
                settype($var, 'string');
                break;

            case 'int':
            case 'integer':
                settype($var, 'integer');
                break;

            case 'float':
                settype($var, 'float');
                break;

            case 'double':
                settype($var, 'double');
                break;

            case 'bool':
            case 'boolean':
                settype($var, 'boolean');
                break;

            case 'array':
                settype($var, 'array');
                break;

            case 'object':
                settype($var, 'object');
                break;

            case 'serialize':
                $var = serialize($var);
                break;
            case 'unserialize':
                $var = unserialize($var);
                break;

            case 'json':
                $var = json_encode($var);
                break;
            case 'unjson':
                $var = json_decode($var);
                break;
        }
    }
}

if (!function_exists('isPost')) {
    function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }
}

if (!function_exists('isPost')) {
    /**
     * @return bool true if request method is POST
     */
    function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}

if (!function_exists('isGet')) {
    /**
     * @return bool true if request method is GET
     */
    function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}

if (!function_exists('request')) {
    /**
     * Safe get a value of $_REQUEST.
     *
     * @param mixed $key
     * @param null $default
     * @param string $type string|int|float|double|bool|array|object|serialize|unserialize|json|unjson
     * @param boolean $pop unset index if its true
     * @return mixed|null
     */
    function request($key = '', $default = null, $type = 'string', $pop = false)
    {
        if (empty($key))
            return $_REQUEST;

        $output = array_get($_REQUEST, $key, $default);
        typecast($output, $type);

        if ($pop)
            unset($_REQUEST[$key]);

        return $output;
    }
}

if (!function_exists('get')) {
    /**
     * Safe get a value of $_GET.
     *
     * @param mixed $key
     * @param null $default
     * @param string $type string|int|float|double|bool|array|object|serialize|unserialize|json|unjson
     * @param boolean $pop unset index if its true
     * @return mixed|null
     */
    function get($key = '', $default = null, $type = 'string', $pop = false)
    {
        if (empty($key))
            return $_GET;

        $output = array_get($_GET, $key, $default);
        typecast($output, $type);

        if ($pop && !empty($key))
            unset($_GET[$key]);

        return $output;
    }
}

if (!function_exists('post')) {
    /**
     * Safe get a value of $_POST.
     *
     * @param mixed $key
     * @param null $default
     * @param string $type string|int|float|double|bool|array|object|serialize|unserialize|json|unjson
     * @param boolean $pop unset index if its true
     * @return mixed|null
     */
    function post($key = '', $default = null, $type = 'string', $pop = false)
    {
        if (empty($key))
            return $_POST;

        $output = array_get($_POST, $key, $default);
        typecast($output, $type);

        if ($pop)
            unset($_POST[$key]);

        return $output;
    }
}

if (!function_exists('sanitize_router')) {
    /**
     * @param $string
     * @param bool $capitalizeFirstCharacter
     * @return mixed|string
     */
    function sanitize_router($string, $capitalizeFirstCharacter = false)
    {
        $string = str_replace('-', '', ucwords($string, '-'));
        return (!$capitalizeFirstCharacter) ? lcfirst($string) : $string;
    }
}

if (!function_exists('camel_to_dashed')) {
    /**
     * @param $input
     * @param string $delimiter
     * @return string
     */
    function camel_to_dashed($input, $delimiter = '-')
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1'.$delimiter, $input));
    }
}

if (!function_exists('underline_to_dash')) {
    /**
     * @param $input
     * @return string
     */
    function underline_to_dash($input)
    {
        return strtolower(preg_replace('/_/', '$1-', $input));
    }
}

if (!function_exists('camel_to_word')) {
    /**
     * @param $name
     * @param bool $ucwords
     * @return mixed|string
     */
    function camel_to_word($name, $ucwords = true)
    {
        $label = str_replace(['-', '_', '.'], ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', strtolower(trim($name))));
        return $ucwords ? ucwords($label) : $label;
    }
}

if (!function_exists('baseUrl')) {
    function baseUrl()
    {
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            str_replace('index.php', '', $_SERVER['PHP_SELF'])
        );
    }
}

if (!function_exists('urlTo')) {
    function urlTo($path)
    {
        return baseUrl() . $path;
    }
}

if (!function_exists('redirect_not_found')) {
    /**
     * Redirects user to not found page with an optional $msg argument
     * @param string $msg
     */
    function redirect_to_not_found_page($msg = '')
    {
        $path = 'page-not-found';

        if ($msg) {
            $path .= "?msg={$msg}";
        }

        redirect(urlTo($path));
    }
}

if (!function_exists('redirect'))
{
    /**
     * Redirects user to another route/url
     * @param string $path
     * @param bool $replace
     * @param null $status_code
     */
    function redirect(string $path, bool $replace = true, $status_code = null)
    {
        header("Location: $path", $replace, $status_code);
        die();
    }
}