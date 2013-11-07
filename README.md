# Forum Package for Laravel 4
- This forum package is inspired by esotalk developed by @tobscure.

#### Status: Under Development

### How to Install

- In your app composer.json file, add:

```php
	"require": {
		"eubby/forum": "dev-Core"
	}
```

- Configure your database settings in the L4 app/config/database.php file
- Open your terminal in the L4 App root directory and run `php composer.phar update` command
- Add Forum Service Provider to the app/config/app.php file under the array key "providers" as shown below

```php

'providers' => array(
		
		'Eubby\Forum\ForumServiceProvider',

)

```

- Please change the default user model in app/config/auth.php to:

```php

'model' => 'Eubby\Models\User',

```

- And run the following command in the terminal to start installing the Forum package
- Please note that this command will ask you to create an admin user account before installing the package

```
 php artisan forum:install
```

### Frontend
- By default it is available on http://www.domain.com/forum

### Admin Panel
- By default it is available on http://www.domain.com/admin

Documentation will be updated soon