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
}
