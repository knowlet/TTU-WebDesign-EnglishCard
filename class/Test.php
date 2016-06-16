<?php
/**
 * Test class
 */
class Test
{
    private $userId = "";
    function __construct()
    {
        $this->userId = (new Session)->auth['uid'];
    }

    public function getRecords()
    {
        return (new Database)->QueryAll("SELECT `score`, `dates` FROM `scores` WHERE examineeid = ? ORDER BY id", [$this->userId]);
    }

    public function storeRecord($value)
    {
        return (new Database)->Update("INSERT INTO `scores` (examineeid, score) VALUES (?, ?)", [$this->userId, $value]);
    }

    public function verifyAnswers($ans, $ques)
    {
        $count = 0;
        for ($i=0; $i < count($ans); $i++) { 
            if ($ans[$i] == $ques[$i]) {
                $count += 10;
            }
        }
        return $count;
    }
}
