<?php


class MClass
{
    private $conn;

    public $id;
    public $game_id;
    public $stadium_id;
    public $location;
    public $title;
    public $about;
    public $mfrom;
    public $mto;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function addMClass()
    {
        try {
            $query = 'INSERT INTO mclasses
                SET 
                game_id = :game_id,
                stadium_id= :stadium_id,
                location = :location,
                title = :title,
                about = :about,
                mfrom = :from,
                mto = :to
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':game_id', htmlspecialchars(strip_tags($this->game_id)));
            $stmt->bindParam(':stadium_id', htmlspecialchars(strip_tags($this->stadium_id)));
            $stmt->bindParam(':location', htmlspecialchars(strip_tags($this->location)));
            $stmt->bindParam(':title', htmlspecialchars(strip_tags($this->title)));
            $stmt->bindParam(':about', htmlspecialchars(strip_tags($this->about)));
            $stmt->bindParam(':from', htmlspecialchars(strip_tags($this->mfrom)));
            $stmt->bindParam(':to', htmlspecialchars(strip_tags($this->mto)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getMClasses($userId = null)
    {
        try {
            $sql = "
                SELECT mclass.*, DATE_FORMAT(mclass.mfrom, '%Y-%m-%d') AS custom_from,
                DATE_FORMAT(mclass.mto, '%Y-%m-%d') AS custom_to,
                game.name AS game_name, game.image AS game_image,
                stadium.name AS stadium_name, stadium.image AS stadium_image
                FROM mclasses mclass
                LEFT JOIN games AS game ON game.id = mclass.game_id
                LEFT JOIN stadiums AS stadium ON stadium.id = mclass.stadium_id
                ORDER BY mclass.mfrom ASC
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            if ($userId) {
                $classes = [];
                foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $c) {
                    $sql = "SELECT * FROM user_mclasses WHERE user_id = :userId AND class_id = :classId";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':userId', htmlspecialchars(strip_tags($userId)));
                    $stmt->bindParam(':classId', htmlspecialchars(strip_tags($c->id)));
                    $stmt->execute();
                    $c->joined = $stmt->fetch(PDO::FETCH_OBJ);
                    array_push($classes, $c);
                }
                return $classes;
            } else {
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateMClass()
    {
        try {
            $query = 'UPDATE mclasses
                SET 
                game_id = :game_id,
                stadium_id= :stadium_id,
                location = :location,
                title = :title,
                about = :about,
                mfrom = :from,
                mto = :to
                WHERE id = :id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));
            $stmt->bindParam(':game_id', htmlspecialchars(strip_tags($this->game_id)));
            $stmt->bindParam(':stadium_id', htmlspecialchars(strip_tags($this->stadium_id)));
            $stmt->bindParam(':location', htmlspecialchars(strip_tags($this->location)));
            $stmt->bindParam(':title', htmlspecialchars(strip_tags($this->title)));
            $stmt->bindParam(':about', htmlspecialchars(strip_tags($this->about)));
            $stmt->bindParam(':from', htmlspecialchars(strip_tags($this->mfrom)));
            $stmt->bindParam(':to', htmlspecialchars(strip_tags($this->mto)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteClass()
    {
        try {
            $query = 'DELETE FROM mclasses
                WHERE id = :id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function joinClass($userId)
    {
        try {
            $query = 'INSERT INTO user_mclasses
                SET 
                class_id = :class_id,
                user_id= :user_id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':class_id', htmlspecialchars(strip_tags($this->id)));
            $stmt->bindParam(':user_id', htmlspecialchars(strip_tags($userId)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function leaveClass($userId)
    {
        try {
            $query = 'DELETE FROM user_mclasses
                WHERE  class_id = :classId AND user_id = :userId
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':classId', htmlspecialchars(strip_tags($this->id)));
            $stmt->bindParam(':userId', htmlspecialchars(strip_tags($userId)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getJoinedClasses($userId)
    {
        try {
            $sql = "
                SELECT mclass.*, DATE_FORMAT(mclass.mfrom, '%Y-%m-%d') AS custom_from,
                DATE_FORMAT(mclass.mto, '%Y-%m-%d') AS custom_to,
                game.name AS game_name, game.image AS game_image,
                stadium.name AS stadium_name, stadium.image AS stadium_image
                FROM mclasses mclass
                LEFT JOIN games AS game ON game.id = mclass.game_id
                LEFT JOIN stadiums AS stadium ON stadium.id = mclass.stadium_id
                INNER JOIN user_mclasses AS user_class ON user_class.class_id = mclass.id
                WHERE user_class.user_id = :userId
                ORDER BY mclass.mfrom ASC
            ";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':userId', htmlspecialchars(strip_tags($userId)));

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getClassMembers()
    {
        try {
            $sql = "
                SELECT user.*
                FROM users user
                INNER JOIN user_mclasses AS user_class ON user_class.user_id = user.id
                WHERE user_class.class_id = :id
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

}