<?php

namespace App\Services\Node;

use phpseclib\Net\SSH2;

class LoginNodeService
{
    public function checkLogin($host , $username , $password)
    {
        $ssh = new SSH2($host);
        if ($ssh->login($username, $password)) {
            return true;
        }else{
            return false;
        }
    }
}