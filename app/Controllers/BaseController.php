<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use stdClass;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $viewData = array();
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    protected $token = '';

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
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
        $session = \Config\Services::session();
        $language = \Config\Services::language();

        $language->setLocale($session->get('lang') ?? 'en');
        $this->setViewData('lang', $language->getLocale());
        $this->setToken(session('token'));
    }

    public function  view($name, $options = array())
    {
        return view($name, $this->getViewData(), $options);
    }

    public function requestApi($url, $method = "GET", $data = [], $returnThis = false, $cookies = [])
    {


        // $url = "https://web-houes.pelution.com/api/v1/resource/card/286";
        // $client = new Client();

        // $options =   [
        //     'timeout' => 10,
        //     // 'auth' => ['user', 'pass'],
        //     'headers' => [
        //         'Authorization' => 'Bearer ' . $this->getToken(),
        //         // 'Accept' => '*/*',
        //         // 'Host' => '1.1.1.1' ,
        //         'Accept' => 'application/json',
        //     ],
        // ];


        // if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE']) && !empty($data)) {
        //     $options['json'] = $data;
        // }


        // $res = $client->request($method,  $url, $options);
        // if (!empty($cookies)) {
        //     $cookieString = '';
        //     foreach ($cookies as $name => $value) {
        //         $cookieString .= "$name=$value; ";
        //     }
        //     $options['headers']['Cookie'] = rtrim($cookieString, '; ');
        // }

        // return (string) $res->getBody();
        // $client = \Config\Services::curlrequest();
        $client = new Client();
        $options = [
            'timeout' => 10,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getToken(),
                'Accept' => '*/*',
                // 'Host' => '1.1.1.1' ,
                // 'Accept' => 'application/json',
            ],
        ];

        // dd($options);
        // Include data if method is POST, PUT, PATCH, or DELETE
        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE']) && !empty($data)) {
            $options['json'] = $data;
        }

        // Include cookies if provided
        if (!empty($cookies)) {
            $cookieString = '';
            foreach ($cookies as $name => $value) {
                $cookieString .= "$name=$value; ";
            }
            $options['headers']['Cookie'] = rtrim($cookieString, '; ');
        }

        try {
            $response = $client->request($method, $url, $options);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            // dd($body);
            if ($statusCode == ResponseInterface::HTTP_OK) {
                if ($returnThis) {
                    return $response;
                } else {
                    return (string) $body; // Decode JSON response
                }
            } else {
                return ['status' => 'error', 'code' => $statusCode, 'message' => 'Request failed'];
            }
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    public function getViewData()
    {
        return $this->viewData;
    }

    public function setViewData(string $key, $viewData)
    {
        $this->viewData[$key] =  $viewData;
        return $this;
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}
