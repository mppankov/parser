<?php

namespace test\Model;

use test\Service\Db;

class HotelStore
{
    protected Db $db;
    private string $table = 'hotel';

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function save(Hotel $entity): void
    {
        $columns = ['hotel', 'rating', 'countReviews', 'countRatings'];

        $query = "INSERT INTO $this->table (" . implode(',' , $columns) .  ") 
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


