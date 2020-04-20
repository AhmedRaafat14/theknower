<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GithubClient;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GithubAuthenticator extends SocialAuthenticator
{
    /** @var ClientRegistry */
    private $clientRegistry;

    /** @var EntityManagerInterface */
    private $em;

    /** @var RouterInterface */
    private $router;

    /**
     * GithubAuthenticator constructor.
     */
    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
    }

    public function supports(Request $request): bool
    {
        // continue ONLY if the current ROUTE matches the check ROUTE
        return 'connect_github_check' === $request->attributes->get('_route');
    }

    public function getCredentials(Request $request)
    {
        // This method only called if the `supports()` function returned TRUE
        return $this->fetchAccessToken($this->getGithubClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GithubResourceOwner $githubUser */
        $githubUser = $this->getGithubClient()->fetchUserFromToken($credentials);

        $githubUser->getEmail();

        // Check if this user logged-in before
        $existingUser = $this->em->getRepository(User::class)->findOneBy(['github_id' => $githubUser->getId()]);
        if ($existingUser) {
            $user = $existingUser;
        } else {
            // Create a new user
            $user = new User();
            $user->setUsername($githubUser->getName());
            $user->setGithubId($githubUser->getId());
            $user->setCreatedAt(new \DateTime());
            $user->setUpdatedAt(new \DateTime());
        }

        $user->setGithubHandle($githubUser->getNickname());
        $user->setAvatar($githubUser->toArray()['avatar_url']);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function getGithubClient(): GithubClient
    {
        return $this->clientRegistry->getClient('github');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $errorMessage = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($errorMessage, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('home'));
    }

    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        // When the auth is needed but not sent, the page where users choose the auth provider
        return new RedirectResponse('/', Response::HTTP_TEMPORARY_REDIRECT);
    }
}
