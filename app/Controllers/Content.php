<?php


namespace App\Controllers;

use App\Services\Database;

class Content
{

    public static function getCategories()
    {
        $database = new Database;
        $pdo = $database::start();

        $sql = <<<'SQL'
SELECT c.id, c.name, count(*) as ctn FROM products p JOIN categories c ON c.id = p.category_id GROUP BY c.id, c.name;
SQL;
        $categories = $pdo->query($sql);
        return $categories->fetchAll();
    }

    public static function getContentForJson()
    {
        $database = new Database;
        $pdo = $database::start();

        $sql = <<<'SQL'
SELECT p.id, p.name as nameprod, p.price, p.category_id, p.date, c.name, p.description FROM products p INNER JOIN categories c ON c.id = p.category_id;
SQL;
        $categories = $pdo->query($sql);
        return $categories->fetchAll();
    }

    public static function getArrayTask2()
    {
        $database = new Database;
        $pdo = $database::start();

        $sql = <<<'SQL'
SELECT * FROM `category`;
SQL;
        $arr = $pdo->query($sql)->fetchAll();
        $result = [];

        function recur($arr, $result, $deep1 = null, $deep2 = null)
        {
            if (empty($result)) {
                foreach ($arr as $item) {
                    $parent_id = $item['parent_id'];
                    $categories_id = $item['categories_id'];
                    if ($parent_id == 0) {
                        $result[$categories_id] = [];
                    }
                }
            }

            if ($deep1 != null && $deep2 == null) {
                foreach ($arr as $item) {
                    $parent_id = $item['parent_id'];
                    $categories_id = $item['categories_id'];
                    if ($parent_id == $deep1) {
                        $result[$deep1][$categories_id] = [];
                    }
                }
            }

            if ($deep2 != null) {
                foreach ($arr as $item) {
                    $parent_id = $item['parent_id'];
                    $categories_id = $item['categories_id'];
                    if ($parent_id == $deep2) {
                        $result[$deep1][$deep2][$categories_id] = $categories_id;
                    }
                }
                if (is_array($result[$deep1][$deep2]) && empty($result[$deep1][$deep2])){
                    $result[$deep1][$deep2] = $deep2;
                }
            }

            if (!empty($result) && $deep1 == null) {
                foreach ($result as $key => $value) {
                    $result = recur($arr, $result, $key);
                }
            }
            if ($deep1 == null) {
                foreach ($result as $deep1 => $value) {
                    foreach ($value as $key => $cat) {
                        $result = recur($arr, $result, $deep1, $key);
                    }
                }
            }
            return $result;
        }

        return recur($arr, $result);
    }

}
