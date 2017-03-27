<?php

$app->get('/posts/all', 'PostsController@getAllPosts');
$app->get('/posts/get/{id}', 'PostsController@getPost');
$app->delete('/posts/delete', 'PostsController@deletePost');
$app->put('/posts/insert', 'PostsController@insertPost');
$app->put('/posts/update', 'PostsController@updatePost');

$app->get('/categories/all', 'CategoriesController@getAllCategories');
