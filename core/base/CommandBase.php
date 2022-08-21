<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 12:21 AM
 */
namespace Meygh\GithubApi\Base;


use Meygh\GithubApi\Contracts\iCommand;


/**
 * Class abstract of CommandBase
 */
abstract class CommandBase extends Component implements iCommand
{
    /** @var string of the console signature */
    protected static $signature = '';

    /** @var array of given arguments while running the command */
    private $arguments = [];

    /**
     * @return string
     */
    public static function signature(): string
    {
        if ($sign = static::$signature) {
            return $sign;
        }

        $class_name = explode('\\', strtolower(get_called_class()));
        static::$signature = $class_name[(count($class_name) - 1)];

        return static::$signature;
    }

    /**
     * Parse and sets commands arguments
     * @param array $args
     */
    public function setArguments(array $args = [])
    {
        $parsedArgs = [];

        if ($args) {
            foreach ($args as $arg) {
                $command = explode(':', $arg, 2);

                /*
                 * If command argument is something like arg_name:arg_value
                 * will be parsed as key => value in the $arguments property
                 */
                if (count($command) == 2) {
                    $parsedArgs[$command[0]] = $command[1];
                } else {
                    $parsedArgs[] = $arg;
                }
            }
        }

        $this->arguments = $parsedArgs;
    }

    /**
     * Returns all command arguments all just given name.
     * It will parse arguments which follow a specific structure:
     * @example arg_name:arg_value
     *
     * @param string $arg
     * @return array|mixed|null
     */
    public function arguments(string $arg = '')
    {
        if (!$arg) {
            return $this->arguments;
        }

        return array_get($this->arguments, $arg);
    }

    /**
     * Renders and displays errors on the screen
     * @param array $errors
     */
    public function renderErrors(array $errors): void
    {
        if (!$errors) {
            return;
        }

        echo "\n\n\n===========================================\n\nError!\n\n";

        if ($message = array_get($errors, 'message')) {
            echo "{$message}\n";
        }

        if ($errorsInfo = array_get($errors, 'errors')) {
            foreach ($errorsInfo as $errorInfo) {
                echo " * {$errorInfo}\n";
            }
        }

        echo "\n===========================================\n\n\n\n";
    }

    /**
     * @return string
     */
    public function getRunningPlace()
    {
        return getcwd();
    }

    /**
     * This event handler will be emmit before call the main run() method.
     * if returns false the main run() method never be launched!
     * @return bool
     */
    public function beforeRun(): bool
    {
        return true;
    }

    /**
     * This event handler will be emit after call the run() method
     * @return bool
     */
    public function afterRun(): bool
    {
        return true;
    }

    /**
     * Handle the action of related command class.
     *
     * @param array $args
     * @return iCommand
     */
    abstract public function run(array $args=[]): iCommand;
}