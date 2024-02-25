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
    private Db $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
        $this->dataBaseInit = new DataBaseInit($this->db);
        $this->hotelStore = new HotelStore($this->db);
        $this->reviewStore = new ReviewStore($this->db);
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