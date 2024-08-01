<?php

class InfoGateway
{
    private PDO $connection;

    public function  __construct(Database $database)
    {
        $this->connection = $database->connect();
    }

    public function postInfo(string $first_name, string $last_name, int $age, string $address)
    {
        $query = "INSERT INTO `tbl_info`(`first_name`, `last_name`, `age`, `address`) VALUES (:first_name,:last_name,:age,:address)";

        $stmt = $this->connection->prepare($query);

        $first_name = htmlspecialchars(strip_tags($first_name));
        $last_name = htmlspecialchars(strip_tags($last_name));
        $age = htmlspecialchars(strip_tags($age));
        $address = htmlspecialchars(strip_tags($address));

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':address', $address);

        return $stmt->execute();
    }

    public function getAllInfo()
    {
        $query = "SELECT * FROM `tbl_info`";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
