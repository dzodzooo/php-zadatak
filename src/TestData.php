<?php
declare(strict_types=1);

use DataObject\UserData;

class TestData
{
    public function set()
    {
        $_SERVER['REMOTE_ADDR'] = "152.216.7.110";
        $_SERVER['HTTP_USER_AGENT'] = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36";
        $_REQUEST['email'] = 'kokodf@sanel.com';
        $_REQUEST['password'] = 'password';
        $_REQUEST['confirmPassword'] = 'password';
    }
    public function get()
    {
        $userData = new UserData($_REQUEST['email'], $_REQUEST['password'], $_REQUEST['confirmPassword']);
        return $userData;
    }
}