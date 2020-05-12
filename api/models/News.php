<?php


class News
{
    private $conn;

    public $id;
    public $game_id;
    public $title;
    public $about;
    public $image;
    public $created_by;
    public $type;
    public $event_date;
    public $stadium_id;

    /**
     * News constructor.
     * @param $conn
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addNews($images)
    {
        try {
            $query = 'INSERT INTO news
                SET 
                game_id = :game_id,
                title= :title,
                about = :about,
                image = :image,
                created_by = :created_by,
                type = :type,
                event_date = :event_date,
                stadium_id = :stadium_id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':game_id', htmlspecialchars(strip_tags($this->game_id)));
            $stmt->bindParam(':title', htmlspecialchars(strip_tags($this->title)));
            $stmt->bindParam(':about', htmlspecialchars(strip_tags($this->about)));
            $stmt->bindParam(':image', htmlspecialchars(strip_tags($this->image)));
            $stmt->bindParam(':created_by', htmlspecialchars(strip_tags($this->created_by)));
            $stmt->bindParam(':type', htmlspecialchars(strip_tags($this->type)));
            $stmt->bindParam(':event_date', htmlspecialchars(strip_tags($this->event_date)));
            $stmt->bindParam(':stadium_id', htmlspecialchars(strip_tags($this->stadium_id)));

            $stmt->execute();

            $this->id =  $this->conn->lastInsertId();
            foreach ($images as $image) {
                $this->addNewsImage($image);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getNews()
    {
        try {
            $sql = "
                SELECT news.*, DATE_FORMAT(news.event_date, '%Y-%m-%dT%H:%i') AS custom_event_date,
                game.name AS game_name, game.image AS game_image,
                stadium.name AS stadium_name, stadium.image AS stadium_image
                FROM news news
                LEFT JOIN users AS user ON user.id = news.created_by
                LEFT JOIN stadiums AS stadium ON stadium.id = news.stadium_id
                LEFT JOIN games AS game ON game.id = news.game_id
            ";
            if (isset($this->type) && $this->type !== "") {
                $sql .= "WHERE news.type = :type";
            }
            $stmt = $this->conn->prepare($sql);
            if (isset($this->type) && $this->type !== "") {
                $stmt->bindParam(':type', htmlspecialchars(strip_tags($this->type)));
            }
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getNewsById()
    {
        try {
            $sql = "
                SELECT news.*, DATE_FORMAT(news.event_date, '%Y-%m-%dT%H:%i') AS custom_event_date,
                game.name AS game_name, game.image AS game_image,
                stadium.name AS stadium_name, stadium.image AS stadium_image
                FROM news news
                LEFT JOIN users AS user ON user.id = news.created_by
                LEFT JOIN stadiums AS stadium ON stadium.id = news.stadium_id
                LEFT JOIN games AS game ON game.id = news.game_id
                WHERE news.id = :id
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));
            $stmt->execute();

            $news = $stmt->fetch(PDO::FETCH_OBJ);

            $news->images = $this->getNewsImages();

            return $news;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateNews()
    {
        try {
            $query = 'UPDATE news
                SET 
                game_id = :game_id,
                title= :title,
                about = :about,
                image = :image,
                created_by = :created_by,
                type = :type,
                event_date = :event_date,
                stadium_id = :stadium_id
                WHERE id = :id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));
            $stmt->bindParam(':game_id', htmlspecialchars(strip_tags($this->game_id)));
            $stmt->bindParam(':title', htmlspecialchars(strip_tags($this->title)));
            $stmt->bindParam(':about', htmlspecialchars(strip_tags($this->about)));
            $stmt->bindParam(':image', htmlspecialchars(strip_tags($this->image)));
            $stmt->bindParam(':created_by', htmlspecialchars(strip_tags($this->created_by)));
            $stmt->bindParam(':type', htmlspecialchars(strip_tags($this->type)));
            $stmt->bindParam(':event_date', htmlspecialchars(strip_tags($this->event_date)));
            $stmt->bindParam(':stadium_id', htmlspecialchars(strip_tags($this->stadium_id)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteNews()
    {
        try {
            $images = $this->getNewsImages();
            foreach ($images as $image) {
                $this->deleteNewsImage($image->id);
            }

            $query = 'DELETE FROM news
                WHERE id = :id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getNewsImages() {
        try {
            $query = 'SELECT * FROM news_images WHERE news_id = :newsId
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':newsId', htmlspecialchars(strip_tags($this->id)));

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function addNewsImage($image) {
        try {
            $query = 'INSERT INTO news_images
                    SET 
                    news_id = :news_id,
                    image = :image
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':news_id', htmlspecialchars(strip_tags($this->id)));
            $stmt->bindParam(':image', htmlspecialchars(strip_tags($image)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteNewsImage($imageId)
    {
        try {
            $query = 'DELETE FROM news_images
                WHERE id = :id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($imageId)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }


}