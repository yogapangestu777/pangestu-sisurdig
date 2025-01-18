<?php

use Hashids\Hashids;

if (! function_exists('encryptId')) {
    function encryptId($id)
    {
        $hashids = new Hashids('PiscokGodog');

        return $hashids->encode([$id, 54715]);
    }
}

if (! function_exists('decryptId')) {
    function decryptId($hashId)
    {
        $hashids = new Hashids('PiscokGodog');

        return $hashids->decode($hashId)[0];
    }
}
