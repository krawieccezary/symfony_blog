<?php

namespace App\Controller;

use App\Command\CommandBusInterface;
use App\Command\User\CreateUserCommand;
use App\Form\NewUserType;
use App\Service\CreateUser\CreateUserModel;
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

    #[Route('/admin/user/create', name: 'user_create', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $userModel = new CreateUserModel();
        $form = $this->createForm(NewUserType::class, $userModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            throw new \Exception('Niestety nie udało się stworzyć nowego użytkownika.');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $id = $this->uuidGenerator->generate();
                $userModel->setId($id);
                $userModel->setRoles(['USER_ROLE']);

                $this->commandBus->dispatch(
                    new CreateUserCommand($userModel)
                );
            } catch (\Exception $exception) {
                return new Response($exception->getMessage());
            }
        }


        return $this->renderForm('admin/user.html.twig', [
            'form' => $form
        ]);
    }
}
