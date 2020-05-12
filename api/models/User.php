<?php

class User
{
    private $conn;

    public $id;
    public $email;
    public $password;
    public $name;
    public $location;
    public $role;
    public $created_at;

    /**
     * User constructor.
     * @param $conn
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register()
    {
        try {
            $query = 'INSERT INTO users
                SET 
                email = :email,
                password= :password,
                name = :name,
                location = :location,
                role = 1
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', htmlspecialchars(strip_tags($this->name)));
            $stmt->bindParam(':email', htmlspecialchars(strip_tags($this->email)));
            $stmt->bindParam(':location', htmlspecialchars(strip_tags($this->location)));
            $stmt->bindParam(':password', password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_DEFAULT));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function login()
    {
        try {
            $sql = "
                SELECT *
                FROM users
                WHERE email = :email
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', htmlspecialchars(strip_tags($this->email)));
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$user) return false;
            if(!password_verify($this->password, $user->password)) return false;
            return $user;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function changePassword($password, $newPassword)
    {
        try {
            $user = $this->getUserById();
            if(!password_verify($password, $user->password)) throw new Exception('Wrong password');

            $query = 'UPDATE users
                SET 
                password= :password
                WHERE id=:id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));
            $stmt->bindParam(':password', password_hash(htmlspecialchars(strip_tags($newPassword)), PASSWORD_DEFAULT));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getUsers()
    {
        try {
            $sql = "
                SELECT *
                FROM users 
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getUserById()
    {
        try {
            $sql = "
                SELECT *
                FROM users 
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

    public function changeRole()
    {
        try {
            $query = 'UPDATE users
                SET 
                role= :role
                WHERE id=:id
            ';
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', htmlspecialchars(strip_tags($this->id)));
            $stmt->bindParam(':role', htmlspecialchars(strip_tags($this->role)));

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}