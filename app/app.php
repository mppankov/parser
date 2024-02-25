<?php

$dsn = 'mysql:host=localhost';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $dbName = 'hotel_reviews';

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("CREATE DATABASE IF NOT EXISTS {$dbName}");
    echo "База данных успешно создана.\n";

    $db->query("use $dbName;");

} catch (PDOException $error) {

    echo 'Подключение к базе данных не удалось: ' . $error->getMessage();
    exit;
}

$db->query("CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    external_id INT UNIQUE KEY,
    review_date DATE,
    negative_text TEXT,
    positive_text TEXT,
    rating INT,
    author_name VARCHAR(50))");

$db->query("CREATE TABLE IF NOT EXISTS hotel (
    hotel_id INT AUTO_INCREMENT PRIMARY KEY,
    hotel TEXT,
    rating FLOAT,
    count_reviews INT,
    count_ratings INT,
    UNIQUE KEY hotel_unique (hotel(255)))");

$url = 'https://101hotels.com/main/cities/volzhskiy/gostinitsa_ahtuba.html';

$content = file_get_contents($url);

preg_match('~<h1 class="hotel__header">\s+(.*?)\s+<\/h1>~', $content, $hotelName);
preg_match('~<span class="rating-value">(\S+)<span class="out-of">~', $content, $rating);
preg_match('~(\d+)\s+отзыва~', $content, $countReviews);
preg_match('~(\d+)\s+оценок~', $content, $countRatings);

$query = "INSERT INTO hotel (hotel, rating, count_reviews, count_ratings)
            VALUES (:hotel, :rating, :countReviews, :countRatings)
            ON DUPLICATE KEY UPDATE  
            hotel = :hotel,
            rating = :rating,
            count_reviews = :countReviews, 
            count_ratings = :countRatings;";

$stmt = $db->prepare($query);
$stmt->execute(array(
    ':hotel' => $hotelName[1],
    ':rating' => $rating[1],
    ':countReviews' => $countReviews[1],
    ':countRatings' => $countRatings[1]));


$urlAjax = 'https://101hotels.com/api/review/get_by_owner?owner_type=hotel&owner_id=837';

$ajaxContent = file_get_contents($urlAjax);
$commentsData = json_decode($ajaxContent, true);


if ($commentsData) {

    foreach ($commentsData['response'] as $comment) {

        if ($comment['negative_text'] || $comment['positive_text']) {

            $query = "INSERT INTO reviews (external_id, review_date, negative_text, positive_text, rating, author_name)
            VALUES (:externalId, :reviewDate, :negativeText, :positiveText, :rating, :authorName) 
            ON DUPLICATE KEY UPDATE 
            review_date = VALUES(review_date), 
            negative_text = VALUES(negative_text), 
            positive_text = VALUES(positive_text), 
            rating = VALUES(rating), 
            author_name = VALUES(author_name);";

            $stmt = $db->prepare($query);
            $stmt->execute(array(
                ':externalId' => $comment['id'],
                ':reviewDate' => $comment['datetime'],
                ':negativeText' => $comment['negative_text'],
                ':positiveText' => $comment['positive_text'],
                ':rating' => $comment['rating'],
                ':authorName' => $comment['user_name']
            ));
        }
    }
}
echo "Все отзывы успешно спарсены и сохранены в базе данных.";

