<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class loginUsersFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $token = $session->get('token');
        $type = $session->get('type');

        $algorithm = 'HS512';
        $key = JWT_SECRET;


        switch ($type) {
            case 'users':
                # code...
                if (is_null($token) || empty($token)) {
                    return redirect()->to(base_url('login'));
                }

                try {

                    $keyObject = new Key($key, $algorithm);
                    $decoded = JWT::decode($token, $keyObject);

                    if (!isset($decoded->user_id)) {
                        return redirect()->to(base_url('/'));
                    }

                    session()->set('detoken', (array) $decoded);
                    // return redirect()->to(base_url('users'));

                } catch (Exception $e) {
                    return redirect()->to(base_url('login'))->with('error', 'Unauthorized access.');
                }

                break;

            default:
                session_destroy();
                return redirect()->to(base_url('login'))->with('error', 'Unauthorized access');
        }

        // session_destroy();
        // return redirect()->to(base_url('login'))->with('error', 'Unauthorized access');

        // echo "get Type";
        // die();
        // return;
        // if ($key === false || empty($key) || (strcmp($type, "users") !== 0)) {
        //     if ((strcmp($type, "users") !== 0)) {
        //         log_message('error', 'Invalid key material');
        //         return redirect()->to('/auth/signin')->with('error', 'Unauthorized access.');
        //     } else {
        //         log_message('error', 'Invalid key material');
        //         return redirect()->to('/users/signin')->with('error', 'Unauthorized access.');
        //     }
        // }

        // // Check if the token is valid
        // if (is_null($token) || empty($token)) {
        //     return redirect()->to(base_url('users/signin'));
        // }

        // // log_message('info', 'Token: ' . $token);

        // try {
        //     $keyObject = new Key($key, $algorithm);
        //     $decoded = JWT::decode($token, $keyObject);

        //     if (!isset($decoded->userId)) {
        //         return redirect()->to(base_url('/'));
        //     }

        //     session()->set('detoken', (array) $decoded);
        // } catch (Exception $e) {
        //     return redirect()->to('/users/signin')->with('error', 'Unauthorized access.');
        // }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No after filter logic required
    }
}
