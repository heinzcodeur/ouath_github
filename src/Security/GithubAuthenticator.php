<?php

namespace App\Security;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GithubAuthenticator extends SocialAuthenticator
{

    public function __construct(private RouterInterface $router, private ClientRegistry $clientRegistry)
    {
        
    }

    public function start(Request $request, ?AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('app_login'));
    }

    public function supports(Request $request)
    {
        return 'oauth_check' === $request->attributes->get('route') && $request->get('service') === 'github';
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->clientRegistry->getClient('github'));
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $client = $this->clientRegistry->getClient('github')->fetchUserFromToken($credentials);
        dd($credentials);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        
    }

}
