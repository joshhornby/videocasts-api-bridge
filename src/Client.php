<?php

namespace JoshHornby\Bridge;

use Guzzle\Http\Message\Request;

class Client
{

    /**
     * @var AuthInterface
     */
    protected $oAuthAuthentication;

    /**
     * @var null|string
     */
    protected $url = 'http://videocastsapi.app/';

    /**
     * @param AuthInterface $oAuthAuthentication
     * @param null $url
     */
    public function __construct(AuthInterface $oAuthAuthentication, $url = null)
    {
        $this->oAuthAuthentication = $oAuthAuthentication;

        if (!is_null($url)) {
            $this->url = $url;
        }
    }

    /**
     * @param $token
     * @return array|string
     */
    public function getContent($token)
    {
        return $this->send($this->getHttp($token)->get($this->url.'content'));
    }

    /**
     * Send the request and return the JSON payload as an array.
     *
     * @param  \Guzzle\Http\Message\Request $request
     * @param  bool $json
     * @return array|string
     */
    protected function send(Request $request, $json = true)
    {
        $response = $request->send();
        return $json ? json_decode($response->getBody(), true) : $response->getBody();
    }


    /**
     * Get a new HTTP client instance.
     *
     * @param $token
     * @return \Guzzle\Http\Client
     */
    public function getHttp($token)
    {
        $client = new \Guzzle\Http\Client;
        $client->addSubscriber($this->oAuthAuthentication->makeRequestWithToken($token));
        return $client;
    }
}
