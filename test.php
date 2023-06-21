<?php

class Review
{

  private $conn;
  public function reviwe_exists()
  {
    $query = 'SELECT * FROM reviews ORDER BY id DESC LIMIT 9';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return true;
  }
  public function reviwe2_exists($id)
  {
    try {
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $query = 'SELECT * FROM reviews WHERE id = :id';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $review = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    if (!$review) {
      echo "Invalid review ID or review not found.";
    } else {
    }
  }
}