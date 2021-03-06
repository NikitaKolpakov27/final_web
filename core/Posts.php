<?php

class Posts
{
    /**
     * @var DataBaseConnector
     */
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $posts = [];

        $result = $this->db->executeQueryWithResult('SELECT p.*, u.login FROM posts p 
            LEFT JOIN users u on p.user_id = u.id');

        while ($post = $result->fetchRow()) {
            $posts[] = $post;
        }

        return $posts;
    }

    public function getPostById($id)
    {
        return $this->db->executeQueryWithResult('SELECT p.*, u.login FROM posts p 
            LEFT JOIN users u on p.user_id = u.id WHERE p.id=' . $id)->fetchRow();
    }

    public function addPost($userId, $title, $text)
    {
        //Changes
        $title = $this->db->escapeValue($title);
        $text = $this->db->escapeValue($text);
        //End of changes
        $this->db->executeQuery("INSERT INTO posts (user_id, title, text, date) VALUES ({$userId}, '{$title}',
                                                       '{$text}', DATE('now'))");
    }

    public function deletePost($postId)
    {
        //Changes
        $postId = $this->db->escapeValue($postId);
        //end of changes
        $this->db->executeQuery('DELETE FROM posts WHERE id = ' . $postId);
    }

    public function updatePost($postId, $title, $text)
    {
        //Changes
        $postId = $this->db->escapeValue($postId);
        $title = $this->db->escapeValue($title);
        $text = $this->db->escapeValue($text);
        //end of changes
        $this->db->executeQuery("UPDATE posts SET title='{$title}', text='{$text}' WHERE id = " . $postId);
    }
}
