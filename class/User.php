<?php
/**
 * Users class
 */
class User
{
    private $db = null;

    function __construct()
    {

    }

    public function getVocabularyList($start, $end)
    {
        return (new Database)->Query("SELECT `vocavId` FROM `vocabularies` DESC LIMIT $start, $end");
    }

    public function isExist($username)
    {
        return !empty((new Database)->Query("SELECT `uid` FROM `users` WHERE username = ?", [$username]));
    }

    public function createAccount($username, $password)
    {
        $username = htmlentities($username);
        if ($this->isExist($username))
            throw new Exception('帳號重複');
        if (strlen($password) < 8)
            throw new Exception('密碼小於8個位元');
        $hash = password_hash($password, PASSWORD_DEFAULT);
        (new Database)->Update("INSERT INTO `users` (username, pwd) VALUES (?, ?)", [$username, $hash]);
    }
}
