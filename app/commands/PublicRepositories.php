<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/18/22
 * Time: 12:28 AM
 */

namespace Meygh\GithubApi\App\Commands;


use Meygh\GithubApi\contracts\CommandInterface;


/**
 * Command ListRepositories
 * @example run.php repos [since:23434]
 *
 * @package Meygh\GithubApi\App\commands
 */
class PublicRepositories extends GitHubCommandBase
{
    /** @var string */
    public static $signature = 'repos';

    public function run(array $argv = []): CommandInterface
    {
        echo "\n\n\n> List of your github repositories.\n\n";

        $result = $this->apiClient->repos()->all($this->arguments('since'));

        if ($this->apiClient->repos()->validateResult())  {
            foreach ($result as $num => $repo) {
                echo ($num + 1) . ") {$repo->name} (Forks: " . ($repo->fork ?: 0) . ")\n";
                echo "Description: " . ($repo->description ?? '(Not Set)') . "\n\n";
                echo "Repository: {$repo->html_url}\n";
                echo "\n---------------------\n\n";
            }

            return $this;
        }

        $this->renderErrors($this->apiClient->repos()->getErrors());

        return $this;
    }
}
