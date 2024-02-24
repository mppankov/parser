<?php

namespace test\Parsers;

use test\Model\Hotel;

class HotelParser
{
    public function getParseHotelData(string $url): Hotel
    {
        $content = $this->download($url);
        return $this->parseHotel($content);
    }

    private function download(string $url): string
    {
        return file_get_contents($url);
    }

    private function parseHotel(string $content): Hotel
    {
        preg_match('~<h1 class="hotel__header">\s+(.*?)\s+<\/h1>~', $content, $hotelName);
        preg_match('~<span class="rating-value">(\S+)<span class="out-of">~', $content, $rating);
        preg_match('~(\d+)\s+отзыва~', $content, $countReviews);
        preg_match('~(\d+)\s+оценок~', $content, $countRatings);

        return new Hotel($hotelName[1], $rating[1], $countReviews[1], $countRatings[1]);
    }
}