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
    protected $url = 'http://josh.videocastsapi.app/api/';

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
    public function getContent()
    {
        return $this->send($this->getHttp()->get($this->url . 'content'));
    }

    /**
     * @param $token
     * @param array $data
     * @return array|string
     */
    public function createContent($token, array $data)
    {
        return $this->send($this->getHttp($token)->post($this->url . 'content', null, $data));
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
     * Send the request and get a plain response.
     *
     * @param  \Guzzle\Http\Message\Request $request
     * @return string
     */
    protected function sendPlain(Request $request)
    {
        return (string)$this->send($request, false);
    }


    /**
     * Get a new HTTP client instance.
     *
     * @param $token
     * @return \Guzzle\Http\Client
     */
    public function getHttp($token = null)
    {
        $client = new \Guzzle\Http\Client;
        if (!is_null($token)) {
            $client->addSubscriber($this->oAuthAuthentication->makeRequestWithToken($token));
        }
        return $client;
    }
}
