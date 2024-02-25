<?php

namespace test\Parsers;

use test\Model\Review;

class ReviewParser
{
    public function getReviewsData(string $url): array
    {
        return $this->parseReviews($this->download($url));
    }

    private function download(string $url): array
    {
        return json_decode(file_get_contents($url), true);
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