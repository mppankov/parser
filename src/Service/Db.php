<?php

namespace test\Service;

use PDO;
use PDOException;

class Db
{
    private static Db $instance;
    private PDO $pdo;
    private function __construct()
    {
        try {
            $dbOptions = (require __DIR__ . '/../settings.php')['db'];

            $this->pdo = new PDO(
                'mysql:host=' . $dbOptions['host'] .
                ';dbname=' . $dbOptions['dbname'],
                $dbOptions['user'],
                $dbOptions['password']);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS " . $dbOptions['dbname']);
            echo "База данных успешно создана.\n";

            $this->pdo->exec('SET NAMES UTF8');
            $this->pdo->query("use " . $dbOptions['dbname'] . ";");

        } catch (PDOException $error) {

            echo 'Подключение к базе данных не удалось: ' . $error->getMessage();
            exit;
        }

    }

    public function query(string $sql, array $params = [], string $className = 'stdClass'): array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return [];
        }
        return $sth->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
