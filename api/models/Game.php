<?php


class Game
{
    private $conn;

    public $id;
    public $name;
    public $image;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addGame()
    {
        try {
            $query = 'INSERT INTO games
                SET 
                name = :name,
                image = :image
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
            $stmt->bindParam(':image', htmlspecialchars(strip_tags($this->image)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getGames()
    {
        try {
            $sql = "
                SELECT *
                FROM games
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getGameById()
    {
        try {
            $sql = "
                SELECT *
                FROM games
                WHERE id = :id
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteGame()
    {
        try {
            $query = 'DELETE FROM games
                WHERE id = :id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateGame()
    {
        try {
            $query = 'UPDATE games
                SET 
                name = :name,
                image = :image
                where id = :id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));
            $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
            $stmt->bindParam(':image', htmlspecialchars(strip_tags($this->image)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}