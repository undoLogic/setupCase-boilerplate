<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Lang middleware
 */
class LangMiddleware implements MiddlewareInterface
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
        $params = $request->getAttribute('params');

        $url_lang = isset($params['language']) ? $params['language'] : false;
        $session_lang = $request->getSession()->read('lang');
        $browser_lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : false;
        $default_lang = 'en';

        if ($url_lang != null && !empty($url_lang)) {
            $current_lang = $url_lang;
            $lang_from = 'url_lang';
        } elseif (!empty($session_lang)) {
            $current_lang = $session_lang;
            $lang_from = 'session_lang';
        } elseif ($browser_lang) {
            $current_lang = $browser_lang;
            $lang_from = 'browser_lang';
        } else {
            $current_lang = $default_lang;
            $lang_from = 'default_lang';
        }

        //assign the lang and how it was found
        $baseLang = substr($current_lang, 0, 2);
        $request = $request->withAttribute('lang', $baseLang);
        $request = $request->withAttribute('lang_from', $lang_from);

        //save to a session for next time
        $request->getSession()->write('lang', $baseLang);

        //OPTIONAL: Make sure we always have a language in the address bar
//        $attributes = $this->request->getAttributes();
//        if (!isset($attributes['params']['language'])) {
//            $redirectArray = array();
//            $redirectArray['language'] = $this->language;
//            if (isset($attributes['params']['?'])) {
//                $redirectArray['?'] = $attributes['params']['?'];
//            }
//            if (!empty($attributes['params']['pass'])) {
//                $redirectArray = $redirectArray + $attributes['params']['pass'];
//            }
//
//            $this->writeToLog('debug', 'Language-NOT-SET redirecting to '.json_encode($redirectArray), false);
//
//            $this->redirect($redirectArray);
//        }

        //pr('current_lang: '.$request->getAttribute('lang'));
        //dd($request);

        return $handler->handle($request);
    }
}
