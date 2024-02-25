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
    external_id INT UNIQUE KEY,
    review_date DATE,
    negative_text TEXT,
    positive_text TEXT,
    rating INT,
    author_name VARCHAR(50))");

        $this->db->query("CREATE TABLE IF NOT EXISTS hotel (
    hotel_id INT AUTO_INCREMENT PRIMARY KEY,
    hotel TEXT,
    rating FLOAT,
    count_reviews INT,
    count_ratings INT,
    UNIQUE KEY hotel_unique (hotel(255)))");

    }
}
