## Endpoint

#set up
`composer install`
`php artisan migrate:refresh`
`php -S localhost:8000 -t ./public`

# Header
- Content-Type: application/json
- Accept: application/json
- Authorization: Bearer `{token}`

# Users endpoint
http://your-domain-host/api/login
- username
- password

http://your-domain-host/api/register
- username
- password

# ToDo endpoint

## List all available items (method:GET)
http://your-domain-host/api/items/

has parameter of
 - order_by=column_name
 - direction=<ASC or DESC>

 example http://your-domain-host/api/items/?order_by=created_at&direction=DESC

## Display all completed items (method:GET)
http://your-domain-host/api/items/completed
## Display all incompleted items (method:GET)
http://your-domain-host/api/items/incompleted

## Creat new items (method:POST)
http://your-domain-host/api/items/

input params
  - name (string)
  - priority (digits)
  - location (string)
  - start_time (time format 00:00)

## Updating items (method:PUT)
http://your-domain-host/api/items/id
form: ecnoded-form-data

## Deleting items (method:DELETE)
http://your-domain-host/api/items/id

## More

```

$router->group(['prefix' => 'items/'], function ($router) {
      $router->get('/', 'ItemsController@index');
      $router->get('completed/', 'ItemsController@completed');
      $router->get('incompleted/', 'ItemsController@incompleted');
      $router->get('{id}', 'ItemsController@show');
      $router->post('/', 'ItemsController@store');
      $router->put('{id}', 'ItemsController@update');
      $router->delete('{id}', 'ItemsController@destroy');
  });
  $router->group(['prefix' => 'templates/'], function ($router) {
      $router->get('/', 'TemplatesController@index');
      $router->get('{id}', 'TemplatesController@show');
      $router->post('/', 'TemplatesController@store');
      $router->put('{id}', 'TemplatesController@update');
      $router->delete('{id}', 'TemplatesController@destroy');
  });
  $router->group(['prefix' => 'checklists/'], function ($router) {
      $router->get('/', 'ChecklistsController@index');
      $router->get('{id}', 'ChecklistsController@show');
      $router->post('/', 'ChecklistsController@store');
      $router->put('{id}', 'ChecklistsController@update');
      $router->delete('{id}', 'ChecklistsController@destroy');
  });

```
Hasan Setiawan (vizzlearn@gmail.com)
