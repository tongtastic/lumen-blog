# Lumen micro-service for blog posts

Very simple micro service with even simpler token based auth

## Setup

Easy peasy, simply run the following commands:
* `git clone` repository url
* `composer install`
* `artisan:migrate`

**.env file**  
Edit the following line to the bottom of your `.env` file. this will be the api token your other applications use to gain access to your micro-service. You **should** have secured your micro-services within a VPC or similar WAF, but this gives you just that extra bit of protection, should you really need it.

API_TOKEN=**TOKEN_GOES_HERE**

## Available End Points

All end points require an `api_token` parameter, which is the same as the one you set in your `.env`  file.

### Get all posts

`GET /posts/all?api_token=`  

Returns JSON  

```javascript
// Valid response 200
{
  'success': true,
  'data': [
    {
      'id': (int) // post id,
      'user_id': (int) // user id of post,
      'title': (string) // post title,
      'content': (string) // post content,
      'created_at': (string) // created time eg: 2017-03-24 11:47:12,
      'update_at': (string) // updated time eg: 2017-03-24 11:47:12
    }
  ]
}

// Invalid response {response code}
{
  'success': false,
  'data': {
    'message': (string),
  }
}
```

### Get post

`GET /posts/get/{id}?api_token=`  

Accepts the following parameters:

`{id}` being the id of the post you are requesting (required).

Returns JSON  

```javascript
// Valid response 200
{
  'success': true,
  'data': {
    'id': (int) // post id,
    'user_id': (int) // user id of post,
    'title': (string) // post title,
    'content': (string) // post content,
    'created_at': (string) // created time eg: 2017-03-24 11:47:12,
    'update_at': (string) // updated time eg: 2017-03-24 11:47:12
  }
}

// Invalid response {response code}
{
  'success': false,
  'data': {
    'message': (string),
  }
}
```

### Insert post

`PUT /posts/insert?api_token=`  

Accepts the following parameters:  

* `user_id` (int) id of user that owns post (required)
* `title` (string) post title (required)
* `content` (string) post content (required)

Returns JSON  

```javascript
// Valid response 200
{
  'success': true,
  'data': {
    'id': (int) // post id,
    'user_id': (int) // user id of post,
    'title': (string) // post title,
    'content': (string) // post content,
    'created_at': (string) // created time eg: 2017-03-24 11:47:12,
    'update_at': (string) // updated time eg: 2017-03-24 11:47:12
  }
}

// Invalid response {response code}
{
  'success': false,
  'data': {
    'message': (string),
  }
}
```

### Delete post

`DELETE /posts/delete?api_token=`  

Accepts the following parameters:  

* `id` (int) id of post you wish to delete (required)

Returns JSON  

```javascript
// Valid response 200
{
  'success': true,
  'data': {
    'id': (int) //post id
  }
}

// Invalid response {response code}
{
  'success': false,
  'data': {
    'message': (string),
  }
}
```

### Update post

`PUT /posts/update?api_token=`  

Accepts the following parameters:  

* `id` (int) id of post to update (required)
* `user_id` (int) id of user that owns post
* `title` (string) post title
* `content` (string) post content

Returns JSON  

```javascript
// Valid response 200
{
  'success': true,
  'data': {
    'id': (int),
    'user_id': (int),
    'title': (string),
    'content': (string),
    'created_at': (string),
    'update_at': (string)
  }
}

// Invalid response {response code}
{
  'success': false,
  'data': {
    'message': (string),
  }
}
```
