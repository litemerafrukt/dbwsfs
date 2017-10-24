<?php

namespace litemerafrukt\Gravatar;

class Gravatar
{
    const GRAVURL = 'https://www.gravatar.com/avatar/';

    private $email;
    private $size;

    /**
     * Construct
     *
     * @param string
     * @param string
     */
    public function __construct($email, $size = 80)
    {
        $this->email = $email;
        $this->size = $size;
    }

    public function url()
    {
        $emailHash = md5(strtolower(trim($this->email)));
        $queryOptions = "?s={$this->size}&d=identicon&r=pg";
        return self::GRAVURL . $emailHash . $queryOptions;
    }
}
