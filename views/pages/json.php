<?php

use App\Controllers\Content;

header('Content-Type: application/json');
$json = Content::getContentForJson();
echo json_encode($json);
