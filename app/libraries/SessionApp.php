<?php 


class SessionApp {

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


}

?>