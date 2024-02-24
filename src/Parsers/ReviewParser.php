<?php

namespace test\Parsers;

use test\Model\Review;

class ReviewParser
{
    public function getReviewsData(string $url): array
    {
        $reviewData = $this->download($url);
        return $this->parseReviews($reviewData);
    }
    private function download(string $url): array
    {
        $pageContentAll = file_get_contents($url);
        return json_decode($pageContentAll, true);
    }
    private function parseReviews(array $commentsData): array
    {
        $result = [];

        foreach ($commentsData['response'] as $comment) {

            if ($comment['negative_text'] || $comment['positive_text']) {

                $result[] = new Review(
                    $comment['id'],
                    $comment['datetime'],
                    $comment['negative_text'],
                    $comment['positive_text'],
                    $comment['rating'],
                    $comment['user_name']);
            }
        }
        return $result;
    }
}