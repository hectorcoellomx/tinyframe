<?php

namespace Core;

class Session
{
    private $id= 'your_secret_session_id_here';
    private $url_login = 'login';
    private $url_home = 'home';

    public function __construct($id="") {
        
        session_start();

        if($id!=""){
            $this->id = $id;
        }

    }

    function create($data){
        $_SESSION[$this->id] = $data;
    }

    function validate($redirect, $url_login='')
    {   
        $url_login = ($url_login=='') ? $this->url_login : $url_login;

        //if(!$this->ci->session->userdata($this->id)){
        if(!isset($_SESSION[$this->id])){
            //redirect($url_login);
        }
    }

    /*function get_data($key="")
    {   
        $data = $this->ci->session->userdata($this->id);
        return ($key == "") ? $data : ((isset($data[$key])) ? $data[$key] : null);
    }

    function set_data($key, $value)
    {   
        $data = $this->ci->session->userdata($this->id);
        $data[$key] = $value;
        $this->ci->session->set_userdata($this->id, $data);        
    }*/

    function logout($redirect='')
    {
        
        $url_login = ($redirect=='') ? $this->url_login : $redirect;

        unset($_SESSION[$this->id]);

        if($redirect!=''){
            //redirect($url_login);
        }
    }
}
