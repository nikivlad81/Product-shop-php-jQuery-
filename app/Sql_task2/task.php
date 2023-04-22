<?php

$start = microtime(true);

$config = [
    'host' => 'localhost',
    'dbname' => 'solomono',
    'user' => 'root',
    'pass' => '',
];

$pdo = new \PDO(
    sprintf('mysql:host=%s;dbname=%s', $config['host'], $config['dbname']),
    $config['user'],
    $config['pass'],
);

$sql = <<<'SQL'
SELECT * FROM `category`;
SQL;
$arr = $pdo->query($sql)->fetchAll();
$result = [];

function recur($arr, $result, $deep1 = null, $deep2 = null) {

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

$result = recur($arr, $result);
echo 'Script execution time: '.round(microtime(true) - $start, 4).' sec.';

return $result;
