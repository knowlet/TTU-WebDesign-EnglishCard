<?php

class Session
{
    /**
     * @var \stdClass
     */
    protected $session;
    public function __construct()
    {
        if( !session_id() )
            session_start();
        $this->session = (object) $_SESSION;
    }
    public function __get($name = null)
    {
        if(is_null($name))
            return $this->session;
        else
            return $this->session->$name??null;
    }
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
        $this->session->$name = $value;
    }
    public function remove($name)
    {
        if(isset($_SESSION[$name]))
            unset($_SESSION[$name]);
        if(isset($this->session->$name))
            $this->session->$name = null;
    }
}
