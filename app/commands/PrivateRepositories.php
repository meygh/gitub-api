<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/20/22
 * Time: 12:53 PM
 */

namespace Meygh\GithubApi\App\Commands;


use Meygh\GithubApi\contracts\CommandInterface;


/**
 * Command ListRepositories
 * @example run.php user-repos [since:23434]
 *
 * @package Meygh\GithubApi\App\commands
 */
class PrivateRepositories extends GitHubCommandBase
{
    /** @var string */
    public static $signature = 'user-repos';

    public function run(array $args = []): CommandInterface
    {
        echo "\n\n\n> List of your github repositories.\n\n";

        $result = $this->gitHubClient->user()->repos($this->arguments('since'));

        if ($this->gitHubClient->user()->validateResult())  {
            foreach ($result as $num => $repo) {
                echo ($num + 1) . ") {$repo->name} (Forks: " . ($repo->fork ?: 0) . ")\n";
                echo "Description: " . ($repo->description ?? '(Not Set)') . "\n\n";
                echo "Repository: {$repo->html_url}\n";
                echo "\n---------------------\n\n";
            }

            return $this;
        }

        $this->renderErrors($this->gitHubClient->user()->getErrors());

        return $this;
    }
}
