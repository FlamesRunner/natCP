<?php
namespace App\Traits;

use Exception;
use phpseclib\Net\SSH2;

trait SSH
{
    public function checkLogin($host , $username , $password)
    {
        $ssh = new SSH2($host);
        $ssh->setTimeout(2);
        try{
            if(!$ssh->login($username, $password)){
                return false;
            }else{
                return true;
            }

        }catch(Exception $e){
            return false;
        }
    }
}