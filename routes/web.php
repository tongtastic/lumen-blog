<?php

$app->get('/posts/all', 'PostsController@getAllPosts');
$app->get('/posts/get/{id}', 'PostsController@getPost');
$app->delete('/posts/delete', 'PostsController@deletePost');
$app->put('/posts/insert', 'PostsController@insertPost');
$app->put('/posts/update', 'PostsController@updatePost');

$app->get('/categories/all', 'CategoriesController@getAllCategories');
$app->get('/categories/get/{id}', 'CategoriesController@getCategory');
$app->delete('/categories/delete', 'CategoriesController@deleteCategory');
$app->put('/categories/insert', 'CategoriesController@insertCategory');
$app->put('/categories/update', 'CategoriesController@updateCategory');
