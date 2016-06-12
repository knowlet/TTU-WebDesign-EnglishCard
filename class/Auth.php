<?php

class Auth
{

    public function login($username, $password)
    {
        $username = htmlentities($username);
        $user = $this->getUser($username);
        if(empty($user))
            throw new Exception('帳號不存在');
        if($username === $user['username'] &&
            password_verify($password, $user['pwd']))
        {
            $session = (new Session());
            $session->auth = $user;
            return $user;
        }
        else
            throw new Exception('帳號密碼錯誤');
    }

    public function logout()
    {
        $session = new Session();
        $session->remove('auth');
    }

    public static function check()
    {
        $session = new Session();
        return is_array($session->auth);
    }

    protected function getUser($username)
    {
        return (new Database)->Query("SELECT * FROM `users` WHERE username = ?", [$username])[0];
    }

}
