<?php

class Hashing
{
    public function myHash($value) {
        return $this->sha1($this->md5($value));
    }

    public function md5 ($value) : string | false{
        return md5($value);
    }

    public function hash($value) : string | false {
        return hash("sha512", $value);
    }

    public function sha1($value) : string | false {
        return $this->sha1($value);
    }

}