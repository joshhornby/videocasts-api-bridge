<?php

namespace JoshHornby\Videocasts\Api;

interface AuthInterface
{

    /**
     * @param $token
     * @return mixed
     */
    public function makeRequestWithToken($token);

    /**
     * @param array $data
     * @return mixed
     */
    public function makeRequestWithPasswordCredentials(array $data);
}
