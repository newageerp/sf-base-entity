<?php

namespace Newageerp\SfBaseEntity\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Firebase\JWT\JWT;
use Newageerp\SfBaseEntity\Interface\IUser;
use Newageerp\SfSocket\Event\SocketSendPoolEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OaBaseController extends AbstractController
{
    protected ObjectRepository $userRepository;

    protected EntityManagerInterface $em;

    protected EventDispatcherInterface $eventDispatcher;

    /**
     * @return EntityManagerInterface
     */
    public function getEm(): EntityManagerInterface
    {
        return $this->em;
    }

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->userRepository = $em->getRepository('App\\Entity\\User');
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function transformJsonBody(Request $request): Request
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }

    /**
     * @param string $schema
     * @return string
     */
    protected function convertSchemaToEntity(string $schema): string
    {
        $entityClass = implode('', array_map('ucfirst', explode("-", $schema)));

        return 'App\Entity\\' . $entityClass;
    }

    /**
     * @return Response
     */
    protected function noAuthError(): Response
    {
        return $this->returnError(0, 'Wrong token');
    }

    /**
     * @param int $code
     * @param string $description
     * @param array|null $extraData
     * @return Response
     */
    protected function returnError(int $code, string $description, ?array $extraData = []): Response
    {
        return $this->signErrorResponse(
            array_merge(
                [
                    'isError' => true,
                    'error' => ['code' => $code, 'description' => $description],
                ],
                $extraData
            )
        );
    }

    /**
     * @param $output
     * @param Request|null $request
     * @return Response
     */
    protected function signErrorResponse($output, Request $request = null): Response
    {
        $response = $this->json($output);
        $response->setStatusCode(Response::HTTP_BAD_REQUEST);

        if ($request && $request->headers->get('origin')) {
            $origin = $request->headers->get('origin');
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
        } else {
            $response->headers->set('Access-Control-Allow-Origin', '*');
        }

        return $response;
    }

    /**
     * @param Request $request
     * @return IUser|null
     */
    public function findUser(Request $request): ?IUser
    {
        $token = $request->get('token') ? $request->get('token') : $request->headers->get('Authorization');
        if ($token) {
            $decoded = (array)JWT::decode($token, $_ENV['AUTH_KEY'], array('HS256'));

            return $this->userRepository->find($decoded['id']);
        }
        return null;
    }

    public function sendSocketPool()
    {
        $event = new SocketSendPoolEvent();
        $this->eventDispatcher->dispatch($event, SocketSendPoolEvent::NAME);
    }
}