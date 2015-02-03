<?php

namespace JoshHornby\Bridge;

interface AuthInterface
{

    /**
     * @param $token
     * @return mixed
     */
    public function makeRequestWithToken($token);
}
