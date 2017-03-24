<?php

$app->get('/posts/{api_token}/all', 'PostsController@getAllPosts');
$app->get('/posts/{api_token}/get/{id}', 'PostsController@getPost');
$app->delete('/posts/{api_token}/delete', 'PostsController@deletePost');
$app->put('/posts/{api_token}/insert', 'PostsController@insertPost');
$app->put('/posts/{api_token}/update', 'PostsController@updatePost');
