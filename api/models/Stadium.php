<?php


class Stadium
{
    private $conn;

    public $id;
    public $name;
    public $location;
    public $image;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addStadium()
    {
        try {
            $query = 'INSERT INTO stadiums
                SET 
                name = :name,
                location= :location,
                image = :image
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
            $stmt->bindParam(':location', htmlspecialchars(strip_tags($this->location)));
            $stmt->bindParam(':image', htmlspecialchars(strip_tags($this->image)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getStadiums()
    {
        try {
            $sql = "
                SELECT *
                FROM stadiums stadium
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getStadiumById()
    {
        try {
            $sql = "
                SELECT *
                FROM stadiums
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

    public function updateStadium()
    {
        try {
            $query = 'UPDATE stadiums
                SET 
                name = :name,
                location= :location,
                image = :image
                WHERE
                id = :id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));
            $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
            $stmt->bindParam(':location', htmlspecialchars(strip_tags($this->location)));
            $stmt->bindParam(':image', htmlspecialchars(strip_tags($this->image)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteStadium()
    {
        try {
            $query = 'DELETE FROM stadiums
                WHERE id = :id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}