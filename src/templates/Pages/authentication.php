<div class="card">
    <div class="card-header">
        <h5>Authentication</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- left coding -->
            <div class="col-lg-6">
                <br>
                <ol>
                    <!-- install auth plugin -->
                    <li>
                        <strong>Install Authentication Plugin</strong>
                    </li>
                    <code>composer require "cakephp/authentication:^2.0"</code>
                    <!-- add password hasher -->
                    <li>
                        <strong>Add Password hasher in User Model and UsersController</strong>
                    </li>
                    <ul>
                        <li>
                            <p>In Model->Entity->User.php</p>
                            <code>use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line</code>
                            <br>
                            <p> Add this method</p>
                            <code>
                                protected function _setPassword(string $password) : ?string<br>
                                {<br>
                                if (strlen($password) > 0) {<br>
                                return (new DefaultPasswordHasher())->hash($password);<br>
                                }else{<br>
                                return false;<br>
                                }<br>
                            </code>
                            <br>
                        </li>

                        <li>
                            <p> In Controller->UsersController.php</p>
                            <code>use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line</code>
                        </li>
                    </ul>
                    <!-- END OF add password hasher -->
                    <li><strong>Update application.php</strong></li>
                    <ul>
                        <li>In src/Application.php, add the following imports under existing classes</li>
                        <code>use Authentication\AuthenticationService;</code><br>
                        <code> use Authentication\AuthenticationServiceInterface;</code></br>
                        <code>  use Authentication\AuthenticationServiceProviderInterface;</code></br>
                        <code>   use Authentication\Middleware\AuthenticationMiddleware;</code></br>
                        <code>   use Cake\Routing\Router;</code></br>
                        <code>  use Psr\Http\Message\ServerRequestInterface;</code></br>
                        <br>
                        <li>
                            Add AuthenticationServiceProviderInterface<br>
                            <code>class Application extends BaseApplication
                                <u>implements AuthenticationServiceProviderInterface</u>
                            </code>

                        </li>
                        <br>
                        <li>Update Middleware function</li>
                        <code>
                            public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue<br>
                            {<br>
                            $middlewareQueue<br>
                            // Catch any exceptions in the lower layers,<br>
                            // and make an error page/response<br>
                            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))<br>

                            // Handle plugin/theme assets like CakePHP normally does.<br>
                            ->add(new AssetMiddleware([<br>
                            'cacheTime' => Configure::read('Asset.cacheTime'),<br>
                            ]))<br>


                            // ... other middleware added before<br>
                            ->add(new RoutingMiddleware($this))<br>
                            // add Authentication after RoutingMiddleware<br>
                            ->add(new AuthenticationMiddleware($this));<br>

                            //;<br>
                            // Add middleware and set the valid locales<br>
                            $middlewareQueue->add(new LocaleSelectorMiddleware(['en_CA', 'fr_CA']));<br>
                            // To accept any locale header value<br>
                            $middlewareQueue->add(new LocaleSelectorMiddleware(['*']));<br>

                            return $middlewareQueue;<br>
                            }<br>
                        </code>

                        <br>
                        <li>Add getAuthenticationService function</li>

                        <br>
                        <code>
                            public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface<br>
                            {<br>
                            $authenticationService = new AuthenticationService([<br>
                            'unauthenticatedRedirect' => <u>Router::url('/users/login')</u>,<br>
                            'queryParam' => 'redirect',<br>
                            ]);<br>

                            // Load identifiers, ensure we check email and password fields<br>
                            $authenticationService->loadIdentifier('Authentication.Password', [<br>
                            'fields' => [<br>
                            'username' => 'email',<br>
                            'password' => 'password',<br>
                            ]<br>
                            ]);
                            <br>
                            // Load the authenticators, you want session first<br>
                            $authenticationService->loadAuthenticator('Authentication.Session');<br>
                            // Configure form data check to pick email and password<br>
                            $authenticationService->loadAuthenticator('Authentication.Form', [<br>
                            'fields' => [<br>
                            'username' => 'email',<br>
                            'password' => 'password',<br>
                            ],
                            'loginUrl' => Router::url('/users/login'),<br>
                            ]);<br>

                            return $authenticationService;<br>
                            }<br>
                        </code>

                    </ul>

                    <li><strong>Update AppController</strong></li>
                    <ul>
                        <li>Add the following in initialize function</li>

                        <code

                            $this->loadComponent('Authentication.Authentication');


                        </code>
                        <li>
                            Add the following in beforeFilter Function
                        </li>
                        <code> $this->Authentication->allowUnauthenticated(['login']);</code>


                        </ul>
                    <li><strong> Add login & logout functions in UsersController</strong></li>
                            <ul>
                            <li>Login</li>
                            <code>
                                public function login()<br>
                                {<br>

                                //echo (new DefaultPasswordHasher())->hash(''); exit;<br>
                                $this->request->allowMethod(['get', 'post']);<br>
                                $result = $this->Authentication->getResult();<br>
                                // regardless of POST or GET, redirect if user is logged in<br>
                                if ($result->isValid()) {<br>
                                // pr($result); exit;<br>
                                return $this->redirect(['controller' => 'users', 'action' => 'index']);<br>
                                }<br>
                                // display error if user submitted and authentication failed<br>
                                if ($this->request->is('post') && !$result->isValid()) {<br>
                                $this->Flash->error(__('Invalid username or password'));<br>
                                }<br>
                                }<br>
                            </code>
                                <li>logout</li>
                                <br>
                                 <code>
                                public function logout()<br>
                                {<br>
                                $result = $this->Authentication->getResult();<br>

                                // regardless of POST or GET, redirect if user is logged in<br>
                                if ($result->isValid()) {<br>
                                $this->Authentication->logout();<br>
                                     $this->Flash->success('You have been logged out');
                                $this->redirect(['controller' => 'users', 'action' => 'login ']);<br>

                                }<br>
                                }//logout<br>
                            </code>
                        </ul>
                        <code>

                        </code>

                    <li><strong> login view page</strong></li>
                    <ul>
                        <li>
                            In Templates->Users, add login.php file and add the following
                        </li>
                        <div class="card">
                            <img src="<?= $webroot; ?>img/login.PNG" />
                        </div>

                    </ul>
                </ol>


            </div>

            <!-- right visual -->
            <div class="col-lg-6">
                <div class="card">
                <h6> 1. Plugin is saved in Vendor directory</h6>
                  <img src="<?= $webroot; ?>img/auth.png" width="40%" />
                </div>
                <div class="card">

                </div>
            </div>
        </div>
    </div>
</div>
