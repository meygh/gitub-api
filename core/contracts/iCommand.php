<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/17/22
 * Time: 7:44 PM
 */

namespace Meygh\GithubApi\Contracts;


interface iCommand extends iComponent
{
    public static function signature(): string;
    public function beforeRun(): bool;
    public function run(array $args=[]): iCommand;
    public function afterRun(): bool;
}