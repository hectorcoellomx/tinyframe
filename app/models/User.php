<?php 

namespace App\Models;

use Core\Databases\DB;

class User{

    public function single($id){
        $db = DB::getInstance();
        return $db->db_select_row("SELECT * FROM users WHERE id=?", [ $id ]);
    }

    public function list($status){
        $db = DB::getInstance();
        return $db->db_select("SELECT * FROM users WHERE status=?", [ $status ]);
    }

    public function insert($name){
        $db = DB::getInstance();
        return $db->db_insert_lastid("INSERT INTO users (fullname) VALUES (?)", [ $name ]);
    }

    public function update($id, $name){
        $db = DB::getInstance();
        return $db->db_update("UPDATE users SET fullname = ? WHERE id = ?", [ $name, $id ]);
    }

    public function delete($id){
        $db = DB::getInstance();
        return $db->db_delete("DELETE from users WHERE id = ?", [ $id ]);
    }

}