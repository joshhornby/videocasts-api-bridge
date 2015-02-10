<?php

namespace JoshHornby\Videocasts\Api;

use CommerceGuys\Guzzle\Plugin\Oauth2\GrantType\PasswordCredentials;
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

    /**
     * @param array $data
     * @return array
     */
    public function makeRequestWithPasswordCredentials(array $data)
    {
        $oauth2Client = new Guzzle('http://josh.videocastsapi.app/oauth/access_token');
        $config = array(
            'username'      => $data['username'],
            'password'      => $data['password'],
            'client_id'     => $data['client_id'],
            'client_secret' => $data['client_secret'],
            'scope'         => $data['scopes']
        );

        $grantType = new PasswordCredentials($oauth2Client, $config);
        return $grantType->getTokenData();
    }
}
