<?php

namespace test\Service;

class DataBaseInit
{
    private Db $db;
    public function __construct(Db $db)
    {
        $this->db = $db;
    }
    public function init(): void
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    externalId INT UNIQUE KEY,
    reviewDate DATE,
    negativeText TEXT,
    positiveText TEXT,
    rating INT,
    author_name VARCHAR(50))");

        $this->db->query("CREATE TABLE IF NOT EXISTS hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rating INT,
    countReviews INT,
    countRatings INT)");

    }
}
