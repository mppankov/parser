<?php

namespace test\Model;

class Hotel
{
    public string $hotelName;
    public int $rating;
    public int $countReviews;
    public int $countRatings;

    public function __construct($hotelName, $rating, $countReviews, $countRatings)
    {
        $this->hotelName = $hotelName;
        $this->rating = $rating;
        $this->countReviews = $countReviews;
        $this->countRatings = $countRatings;
    }
}
