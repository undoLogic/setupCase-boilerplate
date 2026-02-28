<?php

namespace App\Middleware;

use Authentication\Authenticator\ResultInterface;
use Authentication\Authenticator\Result;
use Cake\Log\Log;
use Authentication\Authenticator\FormAuthenticator;
use Cake\ORM\Locator\LocatorAwareTrait;
use Psr\Http\Message\ServerRequestInterface;

class FormLoginAttemptsAuthenticator extends FormAuthenticator
{
    use LocatorAwareTrait;

    public function authenticate(ServerRequestInterface $request): ResultInterface
    {
        if (!$this->_checkUrl($request)) {
            return $this->_buildLoginUrlErrorResult($request);
        }

        $data = $this->_getData($request);
        if ($data === null) {
            return new Result(null, Result::FAILURE_CREDENTIALS_MISSING, [
                'Login credentials not found',
            ]);
        }

        $clientIp = $this->authenticate_getClientIp($request);
        if ($this->fetchTable('FormAttempts')->tooManyFailures($clientIp)) {
            Log::debug('Login blocked due to too many failures for IP: ' . $clientIp);

            return new Result(null, Result::FAILURE_OTHER, [
                'Too many failed login attempts. Please wait 5 minutes and try again.',
            ]);
        }

        $user = $this->_identifier->identify($data);
        if (empty($user)) {
            $this->fetchTable('FormAttempts')->saveFailure($clientIp);

            return new Result(null, Result::FAILURE_IDENTITY_NOT_FOUND, $this->_identifier->getErrors());
        }

        $this->fetchTable('FormAttempts')->clearFailures($clientIp);

        return new Result($user, Result::SUCCESS);
    }

    private function authenticate_getClientIp(ServerRequestInterface $request): string
    {
        if (method_exists($request, 'clientIp')) {
            $clientIp = (string)$request->clientIp();
            if ($clientIp !== '') {
                return $clientIp;
            }
        }

        $serverParams = $request->getServerParams();

        return (string)($serverParams['REMOTE_ADDR'] ?? '0.0.0.0');
    }
}
