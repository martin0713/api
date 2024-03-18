## API

### Framework : [Laravel](https://laravel.com/docs)

### Start

```
git clone git@github.com:martin0713/api.git
cd api
composer install
php artisan migrate
php artisan db:seed
php artisan serve
```

### Route:

#### Auth :

`POST {{url}}/api/auth/register`

-   註冊使用者

`POST {{url}}/api/auth/login`

-   使用者登入

`POST {{url}}/api/auth/logout`

-   使用者登出

#### User :

`GET {{url}}/api/users/{id}`

-   取得使用者資訊，包含使用者的文章

`PUT {{url}}/api/users/{id}`

-   更新使用者

`DELETE {{url}}/api/users/{id}`

-   刪除使用者

#### Articles :

`GET {{url}}/api/articles`

-   取得所有文章，包含作者資訊、標籤

`GET {{url}}/api/articles/{id}`

-   取得某文章，包含作者資訊、標籤

`POST {{url}}/api/articles`

-   新增文章

`PUT {{url}}/api/articles/{id}`

-   更新文章

`DELETE {{url}}/api/articles/{id}`

-   刪除文章

#### Tags :

`GET {{url}}/api/tags`

-   取得所有標籤

`GET {{url}}/api/tags/{id}`

-   取得某標籤

`POST {{url}}/api/tags`

-   新增標籤

`PUT {{url}}/api/tags/{id}`

-   更新標籤

`DELETE {{url}}/api/tags/{id}`

-   刪除標籤
