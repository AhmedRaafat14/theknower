<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GithubController extends AbstractController
{
    /**
     * Start the connect process.
     *
     * @Route("/connect/github", name="connect_github_start")
     *
     * @return RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry): ?RedirectResponse
    {
        return $clientRegistry
            ->getClient('github')
            ->redirect(['public_profile', 'email'], []);
    }

    /**
     * When you finish the login in Github you will be redirected to here.
     *
     * @Route("/connect/github/check", name="connect_github_check")
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry): void
    {
    }
}
