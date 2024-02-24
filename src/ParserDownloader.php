<?php

namespace test;

use test\Service\DataBaseInit;
use test\Model\HotelStore;
use test\Model\ReviewStore;
use test\Parsers\HotelParser;
use test\Parsers\ReviewParser;
use test\Service\Db;

class ParserDownloader
{
    private DataBaseInit $dataBaseInit;
    private HotelStore $hotelStore;
    private ReviewStore $reviewStore;
    private HotelParser $hotelParser;
    private ReviewParser $reviewParser;

    public function __construct()
    {
        $this->dataBaseInit = new DataBaseInit(Db::getInstance());
        $this->hotelStore = new HotelStore(Db::getInstance());
        $this->reviewStore = new ReviewStore(Db::getInstance());
        $this->hotelParser = new HotelParser();
        $this->reviewParser = new ReviewParser();
    }

    public function save(string $url, string $ajaxUrl): void
    {
        $this->dataBaseInit->init();

        $this->hotelStore->save($this->hotelParser->getParseHotelData($url));

        $parseReviewsData = $this->reviewParser->getReviewsData($ajaxUrl);
        foreach ($parseReviewsData as $review) {
            $this->reviewStore->save($review);
        }
    }
}