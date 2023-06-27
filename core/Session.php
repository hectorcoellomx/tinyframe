<?php

namespace Core;

class Session
{
    private $id= 'tarj3t4s2023';
    private $url_login = 'login';

    function create($data)
    {
        $this->ci->session->set_userdata($this->id, $data);
    }

    function get_data($key="")
    {   
        $data = $this->ci->session->userdata($this->id);
        return ($key == "") ? $data : ((isset($data[$key])) ? $data[$key] : null);
    }

    function set_data($key, $value)
    {   
        $data = $this->ci->session->userdata($this->id);
        $data[$key] = $value;
        $this->ci->session->set_userdata($this->id, $data);        
    }

    function check()
    {   
        return $this->ci->session->userdata($this->id);
    }

	function validate($url_login='')
    {   
        $url_login = ($url_login=='') ? $this->url_login : $url_login;
        
        if(!$this->ci->session->userdata($this->id)){
            redirect($url_login);
        }
    }

    function logout($redirect='')
    {
        unset($_SESSION[$this->id]);

        if($redirect!=''){
            redirect($redirect);
        }
    }

}
