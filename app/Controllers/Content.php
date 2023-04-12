<?php


namespace App\Controllers;

use App\Services\Database;

class Content
{

    public static function getCategories () {
        $database = new Database;
        $pdo = $database::start();

        $sql = <<<'SQL'
SELECT c.id, c.name, count(*) as ctn FROM products p JOIN categories c ON c.id = p.category_id GROUP BY c.id, c.name;
SQL;
        $categories = $pdo->query($sql);
        return $categories->fetchAll();
    }

    public static function getContentForJson () {
        $database = new Database;
        $pdo = $database::start();

        $sql = <<<'SQL'
SELECT p.id, p.name as nameprod, p.price, p.category_id, p.date, c.name, p.description FROM products p INNER JOIN categories c ON c.id = p.category_id;
SQL;
        $categories = $pdo->query($sql);
        return $categories->fetchAll();
    }

    public static function getArrayTask2 () {
        $database = new Database;
        $pdo = $database::start();

        $sql = <<<'SQL'
SELECT DISTINCT parent_id FROM `category` ORDER BY parent_id ASC;
SQL;
        $uniq = $pdo->query($sql);
        $uniq = $uniq->fetchAll();

        $sql = <<<'SQL'
SELECT * FROM `category`;
SQL;
        $arr = $pdo->query($sql);
        $arr = $arr->fetchAll();

        $result = [];

        foreach ($uniq as $item) {
            foreach ($arr as $key => $value) {
                if ($value['parent_id'] == $item['parent_id']) {
                    $result[$item['parent_id']][$key + 1] = $key + 1;
                }
            }
        }

        return $result;
    }

}


