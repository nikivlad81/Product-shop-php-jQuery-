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
SELECT * FROM `category`;
SQL;
        $arr = $pdo->query($sql);
        $arr = $arr->fetchAll();

        $sql = <<<'SQL'
SELECT DISTINCT parent_id FROM category ORDER by parent_id ASC ;
SQL;
        $numbers = $pdo->query($sql);
        $numbers = $numbers->fetchAll();

        $missingNum = [];
        $num = 0;

        foreach ($numbers as $number) {
            if ( ($number['parent_id'] - $num) > 1) {
                $missingNum[] = $num;
                $num++;
            }
            if ( ($number['parent_id'] - $num) > 0) {
                $missingNum[] = $num;
                $num++;
            }
            $num++;
        }


        $newres = [];

        foreach ($arr as $value) {
            if ($value['parent_id'] == 0) {
                $newres[$value['categories_id']][] = $value['categories_id'];
            }
        }
        $result = [];
        foreach ($newres as $key => $value) {
            foreach ($arr as $item) {
                if ($item['parent_id'] == $key) {
                    foreach ($arr as $res) {
                        if ($item['categories_id'] == $res['parent_id']) {
                            $result[$item['parent_id']][$item['categories_id']][$res['categories_id']] = $res['categories_id'];
                        } else {
                            foreach ($missingNum as $num) {
                                if ($item['categories_id'] == $num) {
                                    $result[$item['parent_id']][$item['categories_id']] = $num;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }

}
