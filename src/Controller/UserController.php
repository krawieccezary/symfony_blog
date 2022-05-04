<?php

namespace App\Controller;

use App\CQRS\Command\CommandBusInterface;
use App\CQRS\Command\User\CreateUserCommand;
use App\CQRS\Query\QueryBusInterface;
use App\CQRS\Query\User\GetUserQuery;
use App\CQRS\Query\User\GetUsersQuery;
use App\Service\User\CreateUser\CreateUserModel;
use App\Util\UuidGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;


class UserController extends AbstractController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private UuidGeneratorInterface $uuidGenerator
    ) {
    }


    #[Route('/api/users', name: 'api_users', methods: ['GET'])]
    public function getUsers(): Response
    {
        $users = $this->queryBus->query(new GetUsersQuery());
        return $this->json($users);
    }


    #[Route('/api/users', name: 'api_user_create', methods: ['POST'])]
    public function createUser(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);

        if (!$parameters) {
            throw new \InvalidArgumentException();
        }

        try {
            $id = $this->uuidGenerator->generate();
            $userModel = new CreateUserModel();
            $userModel
                ->setId($id)
                ->setUsername($parameters['username'])
                ->setName($parameters['name'])
                ->setSurname($parameters['surname'])
                ->setEmail($parameters['email'])
                ->setPlainPassword($parameters['plainPassword'])
                ->setRoles();

            $this->commandBus->dispatch(new CreateUserCommand($userModel));

            return $this->redirectToRoute('api_users');
        } catch (\Exception $exception) {
            return new Response($exception->getMessage());
        }
    }

    #[Route('/api/users/{id}', name: 'api_user_get', methods: ['GET'])]
    public function fetchUser(string $id): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $user = $this->queryBus->query(new GetUserQuery($uuid));

        return $this->json($user);
    }

}
