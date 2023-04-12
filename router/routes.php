<?php

use App\Services\Router;
use App\Controllers\Create;

Router::page("/", "home");
Router::page("/shop", "shop");
Router::page("/json/shop", "json");
Router::page("/task2", "task2");

Router::post('/create/contant', Create::class, 'content');


Router::enable();