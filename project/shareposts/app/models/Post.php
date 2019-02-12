<?php
class Post{

    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function get_posts(){
        $this->db->query('SELECT *, 
                              posts.id AS post_id, 
                              users.id AS user_id, 
                              posts.created_at AS post_created,
                              users.created_at AS user_created 
                              FROM posts 
                              INNER JOIN users 
                              ON posts.user_id = users.id 
                              ORDER BY posts.created_at DESC');
        $result = $this->db->result_set();
        return $result;
    }
}