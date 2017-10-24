<?php

namespace litemerafrukt\UserCred;

use litemerafrukt\User\UserLevels;
use litemerafrukt\Utils\InjectionAwareClass;

/**
 * Class to handle modifying and retrieving user cred, post-count and comment-count.
 */
class UserCred extends InjectionAwareClass
{
    /**
     * Add points to current user
     *
     * @param int
     */
    public function addCred($cred)
    {
        $this->guard();

        $user = $this->di->get('user');
        $user->cred += $cred;
        $this->di->get('userHandler')->setCred($user->id, $user->cred);
    }

    /**
     * Get top 5 users with cred and total post + comment count
     */
    public function topUsers()
    {
        $userCollection = $this->di->get('usersHandler')->all();
        $postModel = $this->di->get('postModel');

        return $userCollection
            ->sortByDesc('cred')
            ->take(5)
            ->map(function ($user) use ($postModel) {
                $nrOfPosts = \count($postModel->findAllWhere('authorId=?', $user['id']));
                return [
                    'username' => $user['username'],
                    'cred' => $user['cred'],
                    'nrOfPosts' => $nrOfPosts,
                ];
            })
            ->toArray();
    }

    private function guard()
    {
        if ($this->di->get('user')->isLevel(UserLevels::USER)) {
            return;
        }

        $this->di->get('flash')->setFlash('Logga in för att samla cred', 'flash-info');
        $this->di->get('response')->redirect('');
    }
}
