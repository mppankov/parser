<?php

use test\ParserDownloader;

require_once __DIR__ . '/../vendor/autoload.php';

$url = 'https://101hotels.com/main/cities/volzhskiy/gostinitsa_ahtuba.html';
$urlAjax = 'https://101hotels.com/api/review/get_by_owner?owner_type=hotel&owner_id=837';

$downloader = new ParserDownloader();
$downloader->save($url, $urlAjax);

echo "Данные успешно спарсены и сохранены в базе данных.";
