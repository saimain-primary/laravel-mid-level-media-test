## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`DB_DATABASE`

`DB_USERNAME`

`DB_PASSWORD`

## Link the Storage

Link the storage path to public for media

`php artisan storage:link`

## Run the Test

To run the Test

`php artisan test`

## API Reference

#### Get All Posts

```http
  GET /api/v1/posts
```

#### Get Post Detail

```http
  GET /api/v1/posts/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of post to fetch |

#### Create New Post

```http
  POST /api/v1/posts
```

| Parameter | Type          | Description                                                  |
| :-------- | :------------ | :----------------------------------------------------------- |
| `title`   | `string`      | **Required**. Title of the post                              |
| `content` | `string`      | **Required**. Content of the post                            |
| `media`   | `array[file]` | **Required**. Media of the post. Example: media[0], media[1] |

#### Update Post

```http
  PUT /api/v1/posts/${id}
```

| Parameter | Type          | Description                                    |
| :-------- | :------------ | :--------------------------------------------- |
| `id`      | `string`      | **Required**. Id of post to update             |
| `title`   | `string`      | Title of the post                              |
| `content` | `string`      | Content of the post                            |
| `media`   | `array[file]` | Media of the post. Example: media[0], media[1] |

#### Delete Post

```http
  DELETE /api/v1/posts/${id}
```

| Parameter | Type     | Description                        |
| :-------- | :------- | :--------------------------------- |
| `id`      | `string` | **Required**. Id of post to delete |

#### Get Post Comments

```http
  GET /api/v1/posts/${id}/comments
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of post to fetch |

#### Create New Comment on Post

```http
  POST /api/v1/comments
```

| Parameter | Type          | Description                                                     |
| :-------- | :------------ | :-------------------------------------------------------------- |
| `post_id` | `string`      | **Required**. Id of the post                                    |
| `content` | `string`      | **Required**. Content of the comment                            |
| `media`   | `array[file]` | **Required**. Media of the comment. Example: media[0], media[1] |

#### Get Comment Detail

```http
  GET /api/v1/comments/${id}
```

| Parameter | Type     | Description                          |
| :-------- | :------- | :----------------------------------- |
| `id`      | `string` | **Required**. Id of comment to fetch |

#### Update Comment on Post

```http
  PUT /api/v1/comments/${id}
```

| Parameter | Type          | Description                                       |
| :-------- | :------------ | :------------------------------------------------ |
| `id`      | `string`      | Id of the comment                                 |
| `content` | `string`      | Content of the comment                            |
| `media`   | `array[file]` | Media of the comment. Example: media[0], media[1] |

#### Delete Comment

```http
  DELETE /api/v1/comments/${id}
```

| Parameter | Type     | Description                           |
| :-------- | :------- | :------------------------------------ |
| `id`      | `string` | **Required**. Id of comment to delete |
