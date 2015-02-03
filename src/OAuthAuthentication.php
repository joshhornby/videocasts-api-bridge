<?php

namespace JoshHornby\Bridge;

use Guzzle\Http\Client as Guzzle;
use CommerceGuys\Guzzle\Plugin\Oauth2\Oauth2Plugin;

class OAuthAuthentication implements AuthInterface
{

    /**
     * @var Oauth2Plugin
     */
    protected $oAuthPlugin;

    /**
     * @var Guzzle
     */
    protected $client;

    /**
     * @param Oauth2Plugin $oAuthPlugin
     * @param Guzzle $client
     */
    public function __construct(Oauth2Plugin $oAuthPlugin, Guzzle $client)
    {
        $this->oAuthPlugin = $oAuthPlugin;
        $this->client = $client;
    }

    /**
     * @param $token
     * @return Oauth2Plugin
     */
    public function makeRequestWithToken($token)
    {
        $accessToken = ['access_token' => trim($token)];

        $this->oAuthPlugin->setAccessToken($accessToken);

        return $this->oAuthPlugin;
    }
}
