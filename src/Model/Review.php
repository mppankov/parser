<?php

namespace test\Model;

class Review
{
    public int $externalId;
    public string $reviewDate;
    public string $negativeText;
    public string $positiveText;
    public int $rating;
    public string $authorName;

    public function __construct($externalId, $reviewDate, $negativeText, $positiveText, $rating, $authorName)
    {
        $this->externalId = $externalId;
        $this->reviewDate = $reviewDate;
        $this->negativeText = $negativeText;
        $this->positiveText = $positiveText;
        $this->rating = $rating;
        $this->authorName = $authorName;
    }
}