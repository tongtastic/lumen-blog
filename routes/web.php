<?php

$app->get('/posts/all', 'PostsController@getAllPosts');
$app->get('/posts/get/{id}', 'PostsController@getPost');
$app->post('/posts/delete', 'PostsController@deletePost');
$app->put('/posts/insert', 'PostsController@insertPost');
