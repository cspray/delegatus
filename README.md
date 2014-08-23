# Delegatus

A PHP trait that allows you to easily delegate method calls to dependencies without a lot of boiler plate.

## Installation

The easiest way to install Delegatus is to use [Composer](http://getcomposer.org).

```plain
{
    "require": {
        "cspray/delegatus": "~0.1.0"
    }
}
```

Alternatively you can also just clone/download this repo and ensure that the namespace `Delegatus` is included in a PSR-0 compliant autoloader. There are no external dependencies for this project.

## User Guide

Delegating method calls to dependencies is intended to be very easy and self-explanatory. Check out an example below.

```php
class AuthService {

    function authenticate($username, $password) {
        return "Authenticating $username!";
    }

}

class UserModel {

    use Delegatus\Delegator;

    function __construct(AuthService $auth) {
        $this->delegate($auth, ['authenticate']);
    }

}

$auth = new AuthService();
$userModel = new UserModel($auth);

var_dump($userModel->authenticate('cspray', 'password')); // Authenticating cspray!
```

That's it! You can pass multiple methods to delegate at one time if you wish.

If you attempt to call a method that isn't delegated or you delegate a method that doesn't exist on the object a `Delegatus\Exception\MethodNotFoundException` will be thrown.
