<?php

use test\Service\Db;
use test\Service\DataBaseInit;

$url = 'https://101hotels.com/main/cities/volzhskiy/gostinitsa_ahtuba.html';
$urlAjax = 'https://101hotels.com/api/review/get_by_owner?owner_type=hotel&owner_id=837';

$db = Db::getInstance();

$dataBaseInit = new DataBaseInit($db);
$dataBaseInit->init();



echo "Данные успешно спарсены и сохранены в базе данных.";
