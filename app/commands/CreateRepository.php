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
 * Command CreateRepository
 * Creates a repository for the authenticated user
 *
 * Name parameter is required to create a new repository.
 * @example run.php create-repository name:new-test-repository
 *
 * Other command configs are named exactly the original GitHub documentation the following link:
 * @link https://docs.github.com/en/rest/repos/repos#create-a-repository-for-the-authenticated-user
 *
 * @package Meygh\GithubApi\App\commands
 */
class CreateRepository extends GitHubCommandBase
{
    /** @var string */
    public static $signature = 'create-repo';

    public function run(array $args = []): CommandInterface
    {
        echo "\n\n\n> Create a new repository in your GitHub account.\n\n";

        $result = $this->apiClient->user()->create($this->arguments());
        $errors = $this->apiClient->user()->getErrors();

        if (!$errors)  {
            if (isset($result->id)) {
                echo "Your new repository with name '{$result->name}' has been created:\n";
                echo "Link: {$result->html_url}\n\n\n\n";

                return $this;
            }
        }

        $this->renderErrors($errors);

        return $this;
    }
}
