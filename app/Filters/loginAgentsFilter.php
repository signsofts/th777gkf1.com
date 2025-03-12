<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class loginAgentsFilter implements FilterInterface
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
        // $key = getenv('JWT_SECRET') ?: 'b7d928bf4b84fb12010f30d60a0d75270eb1e4ef2bc7dfc1577c8573cecd93921381812d726e0cf43ec367a2bf52c99b2578b140283aec3a6ba309d6a1fdf347858868373d3af30e2d65d298ac135d63d61a64e417e92fa387870fd16fba3b68f3d9a2db5a9203ef15467229bae5b02286b01618203a7062c84ee507fe9a318463581458c7d440c0e89d9608e512cb1708c5d6cc798ce88713ff8c057fc12274761d19de155248f650da432da4ffba5a740c27f700241b43fef80c930378996f526b18d9e3649c1880daccd3feb70bfb0985079ea6db34b1b05d4f44a083cb2e0e1abf1da9e7b34826399198a95c7a4b22cb5835a058516b1a0e2cb90d46377512a987d226e4df47bf59c32e5f58fe23813dd0bcd8a84fc8adf76ab202012699c7ac09989d79d90f695d6e6c4133697414b469a1992dc5b9518fc3357201cad9974faa86d3d7ccbf2aafdf0c2e12de1ab4c8d7a166cb87cc5f43badb03c27785978cd566e2a3713a6f031b17de7029f114d06eefb081ba875f915614337d630d2e38cee77bf666457cb4509e2dd6ba2b2a38a79f576ed7414ce3af4a1101019f076eb4786de48af2ed7d3b49018daaa1295ee1b4392196fda714763f3a1cfa8fcb6b2dd85932ad588531c7f7cbf8a8d335af4d3a1d5825e11a30e15ea75ab603df4d2b3a0b1b9007dfc42e0437ef5eff1cc9dc967a1cbfd0c35d8007e0f1ac75'; // Added default key
        $key = JWT_SECRET;
        if ($key === false || empty($key) || (strcmp($type, "agents") !== 0)) {
            // log_message('error', 'Invalid key material');
            return redirect()->to('agents/signin')->with('error', 'Unauthorized access.');
        }

        // Check if the token is valid
        if (is_null($token) || empty($token)) {
            return redirect()->to(base_url('agents/signin'));
        }

        // log_message('info', 'Token: ' . $token);

        try {
            $keyObject = new Key($key, $algorithm);
            $decoded = JWT::decode($token, $keyObject);
            // Set decoded token into session

            // if($decoded->)
            session()->set('detoken', (array) $decoded);
        } catch (Exception $e) {
            // log_message('error', 'JWT decode error: ' . $e->getMessage());
            return redirect()->to('/agents/signin')->with('error', 'Unauthorized access.');
        }
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
