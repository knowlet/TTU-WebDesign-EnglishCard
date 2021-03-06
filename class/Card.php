<?php

class Card
{
    private $userId = "";
    function __construct()
    {
        $this->userId = (new Session)->auth['uid'];
    }

    public function addCard($term, $definition)
    {
        if (!(new Card)->isExist($term)) {
            (new Database)->Update("INSERT INTO `cards` (ownerid, terms, definitions) VALUES (?, ?, ?)", [$this->userId, $term, $definition]);
            return "新增成功";
        } else {
            throw new Exception('單字已存在');
        }
    }

    public function delCard($term)
    {
        if ((new Card)->isExist($term)) {
            (new Database)->Update("UPDATE `cards` SET `valid`= 'N' WHERE ownerid = ? AND terms = ?", [$this->userId, $term]);
            return "移除成功";
        } else {
            throw new Exception('單字不存在');
        }
    }

    protected function isExist($term)
    {
        return (new Database)->Query("SELECT * FROM `cards` WHERE ownerid = ? AND terms = ? AND valid = 'Y'", [$this->userId, $term]);
    }

    public function getCardList()
    {
        return (new Database)->QueryAll("SELECT `terms`, `definitions` FROM `cards` WHERE ownerid = ? AND valid = 'Y'", [$this->userId]);
    }

    public function getCardRandomly($times)
    {
        if ($times == 1) {
            return (new Database)->Query("SELECT `terms`, `definitions` FROM `cards` WHERE ownerid = ? AND valid = 'Y' ORDER BY RAND() LIMIT 0,?", [$this->userId, $times]);
        }
        return (new Database)->QueryAll("SELECT `terms`, `definitions` FROM `cards` WHERE ownerid = ? AND valid = 'Y' ORDER BY RAND() LIMIT 0,?", [$this->userId, $times]);
    }
}
