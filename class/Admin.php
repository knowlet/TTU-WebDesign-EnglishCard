<?php
/**
 * Admin class
 */
class Admin
{
    private $userId = "";
    function __construct()
    {
        $this->userId = (new Session)->auth['uid'];
        try {
            if (!$this->isAdmin())
                throw new Exception("Privilege Error.");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delUser($id)
    {
        try {
            if (!(new User)->isExistById($id)) throw new Exception("User Not Found.");
            return (new Database)->Update("UPDATE `users` SET `valid`= 'N' WHERE uid = ? ", [$id]);
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function demoteUser($id)
    {
        try {
            if (!(new User)->isExistById($id)) throw new Exception("User Not Found.");
            return (new Database)->Update("UPDATE `users` SET `privilege`= 2 WHERE uid = ? ", [$id]);
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getUserList()
    {
        return (new Database)->QueryAll("SELECT `uid`, `username`, `privilege`, `valid` FROM `users`", []);
    }

    public function isAdmin()
    {
        return !empty((new Database)->Query("SELECT `privilege` FROM `users` WHERE uid = ? AND privilege = 1 AND valid = 'Y'", [$this->userId]));
    }

    public function promoteUser($id)
    {
        try {
            if (!(new User)->isExistById($id)) throw new Exception("User Not Found.");
            return (new Database)->Update("UPDATE `users` SET `privilege`= 1 WHERE uid = ? ", [$id]);
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function resumeUser($id)
    {
        try {
            if (!(new User)->isExistById($id)) throw new Exception("User Not Found.");
            return (new Database)->Update("UPDATE `users` SET `valid`= 'Y' WHERE uid = ? ", [$id]);
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
