<?php

use System\Application;

$app = Application::getApp();

$app->route->add('/' , 'Home');
$app->route->add('/posts/:text/:id' , 'Posts/Post');
$app->route->add('/404' , 'Error/NotFound');
$app->route->notFound('/404');
