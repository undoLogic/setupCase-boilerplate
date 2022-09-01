<?php
declare(strict_types=1);

namespace App\Middleware;

use Cake\Http\Exception\ForbiddenException;
use Cake\Log\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Access middleware
 */
class AccessMiddleware implements MiddlewareInterface
{
    /**
     * Process method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        //No restrictions, theres actions can ALWAYS access any prefix
        if (in_array($request->getAttributes()['params']['action'], ['logout'])) {
            return $handler->handle($request);
        };

        //depending on the current RBAC - limit the users access to different parts of the software
        $params = $request->getAttribute('params');

        if (isset($params['prefix'])) {
            $prefix = $params['prefix'];
            $loggedUser = $request->getAttribute('identity');
            if (is_null($loggedUser)) {
                //user is NOT logged in
                throw new ForbiddenException('User is NOT logged in and is trying to access: '.$prefix);
            } else {
                $loggedUserAccess = $request->getAttribute('access');
                if (empty($loggedUserAccess)) {
                    throw new ForbiddenException('User has not been granted any access');
                } else {
                    if (isset($loggedUserAccess[ $prefix ])) {
                        //Prefix is allowed
                    } else {
                        //not allowed for this prefix
                        throw new ForbiddenException('User does NOT have access to prefix: '.$prefix);
                    }
                }
            }
        } else {
            //no prefix, so not need to force a login
        }

        return $handler->handle($request);
    }
}
