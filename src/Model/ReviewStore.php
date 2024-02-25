<?php

namespace test\Model;

use test\Service\Db;

class ReviewStore
{
    protected Db $db;
    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function save($entity): void
    {
        $query = "INSERT INTO reviews (external_id, review_date, negative_text, positive_text, rating, author_name)
            VALUES (:externalId, :reviewDate, :negativeText, :positiveText, :rating, :authorName) 
            ON DUPLICATE KEY UPDATE 
            review_date = VALUES(review_date), 
            negative_text = VALUES(negative_text), 
            positive_text = VALUES(positive_text), 
            rating = VALUES(rating), 
            author_name = VALUES(author_name);";

        $this->db->query($query, [
            ':externalId' => $entity->externalId,
            ':reviewDate' => $entity->reviewDate,
            ':negativeText' => $entity->negativeText,
            ':positiveText' => $entity->positiveText,
            ':rating' => $entity->rating,
            ':authorName' => $entity->authorName]);
    }
}
