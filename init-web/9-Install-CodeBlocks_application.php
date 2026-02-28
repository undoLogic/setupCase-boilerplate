<?php
//8.1.2. In the application.php page (sourceFiles/src/Application.php) add this function AFTER the "public function middleware(Middl....": NOTE: Make sure you import the required classes after you paste
/*
```php
protected function getAuthenticationService() : AuthenticationService {
  $authenticationService = new AuthenticationService([
      'unauthenticatedRedirect' => Router::url('/login'),
      'queryParam' => 'redirect',
  ]);
  $fields = [
      'username' => 'email',
      'password' => 'password',
  ];

  // Load identifiers, ensure we check email and password fields
  $authenticationService->loadIdentifier('Authentication.Password', [
      'fields' => $fields
  ]);

  // Load the authenticators, you want session first
  $authenticationService->loadAuthenticator('Authentication.Session');

  // Protect against Submit flooding
  //  $authenticationService->loadAuthenticator(FormLoginAttemptsAuthenticator::class, [
  //      'fields' => $fields,
  //      'loginUrl' => Router::url('/login'),
  //  ]);

  //Normal without flooding prevention
  $authenticationService->loadAuthenticator('Authentication.Form', [
      'fields' => $fields,
      'loginUrl' => Router::url('/login'),
  ]);

  // If the user is on the login page, check for a cookie as well.
  $authenticationService->loadAuthenticator('Authentication.Cookie', [
      'fields' => $fields,
      'loginUrl' => '/login',
      'cookie' => [
        'name' => 'remember_me_cookie',
        'expires' => strtotime('+30 days'), // Set the desired expiration time
        'httponly' => true,
      ],
  ]);

  return $authenticationService;
}
```
*/

$applicationFile = dirname(__DIR__) . '/sourceFiles/src/Application.php';

if (!file_exists($applicationFile)) {
    echo "ERROR - Application.php not found";
    exit;
}

$contents = file_get_contents($applicationFile);

if ($contents === false) {
    echo "ERROR - Could not read Application.php";
    exit;
}

$contents = str_replace(["\r\n", "\r"], "\n", $contents);
$updated = false;

if (strpos($contents, "use Authentication\\AuthenticationService;") === false) {
    $anchor = "namespace App;\n\n";
    $replacement = "namespace App;\n\nuse Authentication\\AuthenticationService;\n";
    $contents = str_replace($anchor, $replacement, $contents, $count);
    if ($count !== 1) {
        echo "ERROR - namespace anchor for AuthenticationService import not found";
        exit;
    }
    $updated = true;
}

if (strpos($contents, "use Cake\\Routing\\Router;") === false) {
    $anchor = "use Cake\\Routing\\Middleware\\RoutingMiddleware;\n";
    if (strpos($contents, $anchor) !== false) {
        $contents = str_replace($anchor, $anchor . "use Cake\\Routing\\Router;\n", $contents, $count);
        if ($count !== 1) {
            echo "ERROR - RoutingMiddleware anchor for Router import not found";
            exit;
        }
    } else {
        $namespaceAnchor = "namespace App;\n\n";
        $contents = str_replace($namespaceAnchor, $namespaceAnchor . "use Cake\\Routing\\Router;\n", $contents, $count);
        if ($count !== 1) {
            echo "ERROR - namespace anchor for Router import not found";
            exit;
        }
    }
    $updated = true;
}

if (strpos($contents, 'protected function getAuthenticationService() : AuthenticationService') === false) {
    $insert = <<<'PHP'

    protected function getAuthenticationService() : AuthenticationService
    {
        $authenticationService = new AuthenticationService([
            'unauthenticatedRedirect' => Router::url('/login'),
            'queryParam' => 'redirect',
        ]);
        $fields = [
            'username' => 'email',
            'password' => 'password',
        ];

        // Load identifiers, ensure we check email and password fields
        $authenticationService->loadIdentifier('Authentication.Password', [
            'fields' => $fields,
        ]);

        // Load the authenticators, you want session first
        $authenticationService->loadAuthenticator('Authentication.Session');

        // Protect against Submit flooding
        // $authenticationService->loadAuthenticator(FormLoginAttemptsAuthenticator::class, [
        //     'fields' => $fields,
        //     'loginUrl' => Router::url('/login'),
        // ]);

        // Normal without flooding prevention
        $authenticationService->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => Router::url('/login'),
        ]);

        // If the user is on the login page, check for a cookie as well.
        $authenticationService->loadAuthenticator('Authentication.Cookie', [
            'fields' => $fields,
            'loginUrl' => '/login',
            'cookie' => [
                'name' => 'remember_me_cookie',
                'expires' => strtotime('+30 days'),
                'httponly' => true,
            ],
        ]);

        return $authenticationService;
    }

PHP;

    $needle = "        return \$middlewareQueue;\n    }\n";
    $contents = str_replace($needle, $needle . $insert, $contents, $count);

    if ($count !== 1) {
        echo "ERROR - middleware anchor not found";
        exit;
    }

    $updated = true;
}

if (!$updated) {
    echo "Application authentication setup already exists — skipping<br/>";
    exit;
}

file_put_contents($applicationFile, $contents);

echo "Application authentication setup added successfully<br/><br/>";
