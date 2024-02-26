<?php

namespace test\Model;

use test\Service\Db;

class HotelStore
{
    protected Db $db;
    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function save(Hotel $entity): void
    {
        $query = "INSERT INTO hotel (hotel, rating, count_reviews, count_ratings)
            VALUES (:hotel, :rating, :countReviews, :countRatings)
            ON DUPLICATE KEY UPDATE  
            hotel = :hotel,
            rating = :rating,
            count_reviews = :countReviews, 
            count_ratings = :countRatings;";

        $this->db->query($query, [
            ':hotel' => $entity->hotelName,
            ':rating' => $entity->rating,
            ':countReviews' => $entity->countReviews,
            ':countRatings' => $entity->countRatings]);
    }
}


