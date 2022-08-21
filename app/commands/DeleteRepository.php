<?php
/**
 * Created by PhpStorm.
 * User: meysam.ghanbari
 * Date: 8/20/22
 * Time: 4:52 PM
 */

namespace Meygh\GithubApi\App\Commands;


use Meygh\GithubApi\Contracts\iCommand;


/**
 * Command DeleteRepository
 * Deletes a repository of the authenticated user
 *
 * Required parameters: repo:your_repository_name
 * @link https://docs.github.com/en/rest/repos/repos#delete-a-repository
 *
 * @package Meygh\GithubApi\App\commands
 */
class DeleteRepository extends GitHubCommandBase
{
    /** @var string */
    public static $signature = 'del-repo';

    public function run(array $args = []): iCommand
    {
        echo "\n\n\n> Delete a new repository from your GitHub account.\n\n";

        $repo_name = $this->arguments('repo');
        $this->apiClient->user()->deleteRepo($this->arguments());
        $errors = $this->apiClient->user()->getErrors();

        if (!$errors)  {
            echo "Repository '{$repo_name}' has been deleted successfully!\n\n\n\n";

            return $this;
        }

        $this->renderErrors($errors);

        return $this;
    }
}