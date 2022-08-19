<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 12:21 AM
 */
namespace Meygh\GithubApi\Base;


use Meygh\GithubApi\contracts\CommandInterface;


/**
 * Class abstract of CommandBase
 */
abstract class CommandBase extends Component implements CommandInterface
{
    /** @var string of the console signature */
    protected static $signature = '';

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

    public function getRunningPlace()
    {
        return getcwd();
    }



    public function beforeRun(): CommandInterface
    {
        return $this;
    }

    public function afterRun(): CommandInterface
    {
        return $this;
    }

    /**
     * Handle the action of related command class.
     *
     * @param array $args
     * @return CommandInterface
     */
    abstract public function run(array $args=[]): CommandInterface;
}