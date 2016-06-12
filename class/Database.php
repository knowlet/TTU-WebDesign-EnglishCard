<?php
/**
 * A simple database class
 * @author knowlet
 */
class Database extends PDO
{
    protected $dbh;

    function __construct($file='.env')
    {
        $this->Connect($file);
    }

    private function Connect($file)
    {
        try {
            if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open settings.');
            $host = $settings['DATABASE']['HOST'];
            $name = $settings['DATABASE']['DATABASE'];
            $user = $settings['DATABASE']['USERNAME'];
            $pass = $settings['DATABASE']['PASSWORD'];
            $dsn = "mysql:host=$host;dbname=$name;charset=utf8";
            parent::__construct($dsn, $user, $pass, [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ]);
            # We can now log any exceptions on Fatal error.
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # Disable emulation of prepared statements, use REAL prepared statements instead.
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die('錯誤: 無法連接到資料庫');
        }
    }

    public function Query($sql, $value=[])
    {
        try {
            $sth = $this->prepare($sql);
            $sth->execute($value);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die('資料庫操作失敗，請重試，若問題仍在，請通知管理單位。');
        }
        $rs = $sth->fetchall();
        return $rs;
    }

    public function Update($sql, $value=[])
    {
        try {
            $sth = $this->prepare($sql);
            $sth->execute($value);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die('資料庫操作失敗，請重試，若問題仍在，請通知管理單位。');
        }
    }
}
