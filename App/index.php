<?php

use System\Application;

$app = Application::getApp();

$app->route->add('/' , 'Home');
//Admin Routs

//Login
$app->route->add('/admin/login' , 'Admin/Login');
$app->route->add('/admin/login/submit' , 'Admin/Login@submit' , 'POST');
//Logout
$app->route->add('/logout' , 'Logout');
//Dashboard
$app->route->add('/admin' , 'Admin/Dashboard');
$app->route->add('/admin/dashboard' , 'Admin/Dashboard');
//Admin => User
$app->route->add('/admin/users' , 'Admin/Users');//@index
$app->route->add('/admin/users/add' , 'Admin/Users@add');
$app->route->add('/admin/users/submit' , 'Admin/Users@submit' , 'POST');
$app->route->add('/admin/users/edit/:id' , 'Admin/Users@edit');
$app->route->add('/admin/users/save/:id' ,'Admin/Users@save' , 'POST');
$app->route->add('/admin/users/delete/:id' , 'Admin/Users@delete');
//Admin => User-Group
$app->route->add('/admin/users-groups' , 'Admin/UsersGroups');//@index
$app->route->add('/admin/users-groups/add' , 'Admin/UsersGroups@add');
$app->route->add('/admin/users-groups/submit' , 'Admin/UsersGroups@submit' , 'POST');
$app->route->add('/admin/users-groups/edit/:id' , 'Admin/UsersGroups@edit');
$app->route->add('/admin/users-groups/save/:id' ,'Admin/UsersGroups@save' , 'POST');
$app->route->add('/admin/users-groups/delete/:id' , 'Admin/UsersGroups@delete');
//Admin => Post
$app->route->add('/admin/posts' , 'Admin/Posts');//@index
$app->route->add('/admin/posts/add' , 'Admin/Posts@add');
$app->route->add('/admin/posts/submit' , 'Admin/Posts@submit' , 'POST');
$app->route->add('/admin/posts/edit/:id' , 'Admin/Posts@edit');
$app->route->add('/admin/posts/save/:id' ,'Admin/Posts@save' , 'POST');
$app->route->add('/admin/posts/delete/:id' , 'Admin/Posts@delete');
//Admin => Comment
$app->route->add('/admin/posts/:id/comments' , 'Admin/Comments');
$app->route->add('/admin/comments/edit/:id' , 'Admin/Comments@edit');
$app->route->add('/admin/comments/save/:id' , 'Admin/Comments@save' ,'POST');
$app->route->add('/admin/comments/delete/:id' , 'Admin/Comments@delete');
//Admin => Categories
$app->route->add('/admin/categories' , 'Admin/Categories');//@index
$app->route->add('/admin/categories/add' , 'Admin/Categories@add');
$app->route->add('/admin/categories/submit' , 'Admin/Categories@submit' , 'POST');
$app->route->add('/admin/categories/edit/:id' , 'Admin/Categories@edit');
$app->route->add('/admin/categories/save/:id' ,'Admin/Categories@save' , 'POST');
$app->route->add('/admin/categories/delete/:id' , 'Admin/Categories@delete');
//Admin => Adds
$app->route->add('/admin/ads' , 'Admin/Ads');//@index
$app->route->add('/admin/ads/add' , 'Admin/Ads@add');
$app->route->add('/admin/ads/submit' , 'Admin/Ads@submit' , 'POST');
$app->route->add('/admin/ads/edit/:id' , 'Admin/Ads@edit');
$app->route->add('/admin/ads/save/:id' ,'Admin/Ads@save' , 'POST');
$app->route->add('/admin/ads/delete/:id' , 'Admin/Ads@delete');
//Admin Settings
$app->route->add('/admin/settings' , 'Admin/Settings');
$app->route->add('/admin/settings' , 'Admin/Settings@save' , 'POST');
//Admin Contacts
$app->route->add('/admin/contacts' , 'Admin/Contacts');
$app->route->add('/admin/settings/reply/:id' , 'Admin/Contacts@reply' );
$app->route->add('/admin/settings/send/:id' , 'Admin/Contacts@send' ,'POST');

//Not Found Page
$app->route->add('/404' , 'NotFound');
$app->route->notFound('/404');
