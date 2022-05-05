<?php

namespace App\Controller;

use App\CQRS\Command\CommandBusInterface;
use App\CQRS\Command\User\CreateUserCommand;
use App\CQRS\Query\QueryBusInterface;
use App\CQRS\Query\User\GetUserQuery;
use App\CQRS\Query\User\GetUsersQuery;
use App\Entity\User;
use App\Util\UuidGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;


/**
 * @OA\Tag(name="User")
 */
class UserController extends AbstractController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private UuidGeneratorInterface $uuidGenerator
    ) {
    }

    /**
     * @OA\Response(response=200, description="Users displayed")
     * @OA\Get(
     *     summary="Get All Users"
     * )
     */
    #[Route('/api/users', name: 'api_users', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        $users = $this->queryBus->query(new GetUsersQuery());
        return $this->json($users);
    }

    /**
     * @OA\Response(response=200, description="User created")
     * @OA\Post(
     *     summary="Create User"
     * )
     */
    #[Route('/api/users', name: 'api_user_create', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);

        if (!$parameters) {
            throw new \InvalidArgumentException();
        }

        try {
            $id = $this->uuidGenerator->generate();
            $parameters['id'] = $id;

            $this->commandBus->dispatch(CreateUserCommand::createFromArray($parameters));

            return $this->json('Użytkownik pomyślnie stworzony!');
        } catch (\Exception $exception) {
            return $this->json('Wystąpił jakiś błąd przy tworzeniu użytkownika');
        }
    }

    /**
     * @OA\Response(response=200, description="User displayed")
     * @OA\Get(
     *     summary="Get single User"
     * )
     */
    #[Route('/api/users/{id}', name: 'api_user_get', methods: ['GET'])]
    public function fetchUser(string $id): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $user = $this->queryBus->query(new GetUserQuery($uuid));

        return $this->json($user);
    }

}
