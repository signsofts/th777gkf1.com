<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Predis\Command\Redis\WATCH;
use Psr\Log\LoggerInterface;
use stdClass;

/**
 * Class LineApiController
 *
 * LineApiController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends LineApiController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class LineApiController extends Controller
{
    protected $token = '';

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend LineApiController.
     *
     * @var list<string>
     */
    protected $helpers = [
        'url',
        'array',
        'cookie',
        'date',
        'filesystem',
        'form',
        'html',
        'inflector',
        'number',
        'security',
        'text',
        'xml',
        'session',
        'function'
    ];


    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // $language = \Config\Services::language();
        // $lang = json_decode(file_get_contents(WRITEPATH . "lineMessage/language.json"));
        // $language->setLocale($lang->lang);
    }


    public function log($fileName = 'events.json', $text = '')
    {
        $events = json_decode(file_get_contents(WRITEPATH . $fileName), true);
        array_push($events, $text);
        file_put_contents(WRITEPATH . $fileName, json_encode($events));


        return $events;
    }
}
