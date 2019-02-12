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

    public function add_post($data){
        $this->db->query('INSERT INTO posts (title, body, user_id) VALUES(:title, :body, :user_id)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':body', $data['body']);

        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    public  function get_post_by_id($id){
        $this->db->query('SELECT * FROM posts WHERE posts.id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->result_single();
        return $row;
    }

    public function update_post($data){
        $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':body', $data['body']);

        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    public function delete_post($id){
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }
}