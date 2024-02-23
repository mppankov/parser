<?php

namespace test\Adapters;

use test\Model\Hotel;

class UrlAdapter
{
    public function getReviewsData(string $url): array
    {
        $reviewData = $this->download($url);
        return $this->parseReviews($reviewData);
    }
    private function download(string $url): string
    {
        return file_get_contents($url);
    }
    private function parseReviews(string $content): array
    {
        preg_match('~<h1 class="hotel__header">\s+(.*?)\s+<\/h1>~', $content, $hotelName);
        preg_match('~<span class="rating-value">(\S+)<span class="out-of">~', $content, $rating);
        preg_match('~(\d+)\s+отзыва~', $content, $countReviews);
        preg_match('~(\d+)\s+оценок~', $content, $countRatings);

        $result[] = new Hotel($hotelName[1], $rating[1], $countReviews[1], $countRatings[1]);

        return $result;

    }
}