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

echo 'Script execution time: '.round(microtime(true) - $start, 4).' sec.';

return $result;
