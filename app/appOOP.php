<?php

use test\ParserDownloader;

include_once \test\ParserDownloader::class;

$url = 'https://101hotels.com/main/cities/volzhskiy/gostinitsa_ahtuba.html';
$urlAjax = 'https://101hotels.com/api/review/get_by_owner?owner_type=hotel&owner_id=837';


$downloader = new ParserDownloader();
$downloader->save($url, $urlAjax);

echo "Данные успешно спарсены и сохранены в базе данных.";
