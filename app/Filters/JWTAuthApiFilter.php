<?php

namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Exceptions\InvalidAccessFromException;

class JWTAuthApiFilter implements FilterInterface
{
    use ResponseTrait;

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
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader     = $request->getHeader('authorization');
        // $accessFrom     = $request->getHeader('x-access-from');
        $accessFrom     = $request->uri->getSegments()[0] !== 'api' ? 'web' : 'api';

        try {
            if (is_null($authHeader)) {
                throw new \Exception('Unauthorized');
            }

            helper('jwt');
            $encodedToken = getJWTFromRequest($authHeader->getValue());
            $validateJWTFromRequest($encodedToken);
            return $request;
        }
        // catch (InvalidAccessFromException $e) {
        //     return Services::response()
        //         ->setJSON([
        //             'status'    => ResponseInterface::HTTP_UNAUTHORIZED,
        //             'error'     => 'invalid_request',
        //             'message'   => $e->getMessage(),
        //         ])
        //         ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        // }
        catch (\Exception $e) {
            if ($accessFrom === 'api') {
                return Services::response()
                    ->setJSON([
                        'status'    => ResponseInterface::HTTP_UNAUTHORIZED,
                        'error'     => 'unauthorized',
                        'message' => $e->getMessage(),
                    ])
                    ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }

            if ($accessFrom === 'web') {
                return redirect()->to('/');
            }
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
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
