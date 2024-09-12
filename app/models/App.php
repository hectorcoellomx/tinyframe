<?php 

namespace App\Models;

use Core\Databases\DB;

class App{

    public function single($id){
        $db = DB::init();
        return $db->db_select_row("SELECT * FROM users WHERE id=?", [ $id ]);
    }

    public function list($status){
        $db = DB::init();
        return $db->db_select("SELECT * FROM users WHERE status=?", [ $status ]);
    }

    public function insert($name){
        $db = DB::init();
        return $db->db_insert("INSERT INTO users (fullname) VALUES (?)", [ $name ]);
    }

    public function update($id, $name){
        $db = DB::init();
        return $db->db_update("UPDATE users SET fullname = ? WHERE id = ?", [ $name, $id ]);
    }

    public function delete($id){
        $db = DB::init();
        return $db->db_delete("DELETE from users WHERE id = ?", [ $id ]);
    }

    public function message(){
        return "is a microframework with MVC Architecture for small projects and api rest.";
    }

}