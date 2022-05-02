<?php

namespace App\Controller;

use App\Command\CommandBusInterface;
use App\Command\User\CreateUserCommand;
use App\Util\UuidGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private UuidGeneratorInterface $uuidGenerator
    ) {
    }

    #[Route('/user-create', name: 'user_create', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        try {
            $id = $this->uuidGenerator->generate();

            $this->commandBus->dispatch(
                new CreateUserCommand($id)
            );
        } catch (\Exception $exception) {
            return new Response($exception->getMessage());
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
