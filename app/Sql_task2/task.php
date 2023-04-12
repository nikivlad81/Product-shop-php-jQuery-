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

echo 'Script execution time: '.round(microtime(true) - $start, 4).' sec.';

return $result;
