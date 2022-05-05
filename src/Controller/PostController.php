<?php

namespace App\Controller;

use App\CQRS\Command\CommandBusInterface;
use App\CQRS\Command\Post\CreatePostCommand;
use App\CQRS\Command\Post\DeletePostCommand;
use App\CQRS\Command\Post\UpdatePostCommand;
use App\CQRS\Query\Post\GetPostQuery;
use App\CQRS\Query\Post\GetPostsQuery;
use App\CQRS\Query\QueryBusInterface;
use App\Repository\PostRepositoryInterface;
use App\Service\Post\CreateRequestBodyFromJson\CreatePostJsonModel;
use App\Util\UuidGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * @OA\Tag(name="Post")
 */
class PostController extends AbstractController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private UuidGeneratorInterface $uuidGenerator,
        private PostRepositoryInterface $postRepository
    ) {
    }

    /**
     * @OA\Response(response=200, description="Posts displayed")
     * @OA\Get(
     *     summary="Get All Posts"
     * )
     */
    #[Route('/api/posts', name: 'api_posts', methods: ['GET'])]
    public function getPosts(): JsonResponse
    {
        $posts = $this->queryBus->query(new GetPostsQuery());
        return $this->json($posts);
    }

    /**
     * @OA\Response(response=200, description="Post created")
     * @OA\Post(
     *     summary="Create Post"
     * )
     * @OA\RequestBody(
     *     @Model(type=CreatePostJsonModel::class)
     * )
     */
    #[Route('/api/posts', name: 'api_post_create', methods: ['POST'])]
    public function createPost(Request $request): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);

        if (!$parameters) {
            throw new \InvalidArgumentException();
        }

        try {
            $id = $this->uuidGenerator->generate();
            $parameters['id'] = $id;
            $parameters['author'] = $this->getUser();

            $createPostJsonModel = new CreatePostJsonModel($parameters);
            $this->commandBus->dispatch(
                new CreatePostCommand(
                    $id,
                    $createPostJsonModel->getTitle(),
                    $createPostJsonModel->getContent(),
                    $createPostJsonModel->getActive(),
                    $this->getUser()
                )
            );

            return $this->json('Post pomyślnie stworzony!');
        } catch (\Exception $exception) {
            return $this->json($exception->getMessage());
        }
    }

    /**
     * @OA\Response(response=200, description="Post displayed")
     * @OA\Get(
     *     summary="Get single Post"
     * )
     */
    #[Route('/api/posts/{id}', name: 'api_post_get', methods: ['GET'])]
    public function fetchPost(string $id): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $post = $this->queryBus->query(new GetPostQuery($uuid));

        return $this->json($post);
    }


    /**
     * @OA\Response(response=200, description="Post deleted")
     * @OA\Delete(
     *     summary="Delete single Post"
     * )
     */
    #[Route('/api/posts/{id}/delete', name: 'api_post_delete', methods: ['DELETE'])]
    public function deletePost(string $id): JsonResponse
    {
        $uuid = Uuid::fromString($id);
        $this->commandBus->dispatch(new DeletePostCommand($uuid));

        return $this->json('Post został usunięty');
    }

    /**
     * @OA\Response(response=200, description="Post updated")
     * @OA\Put(
     *     summary="Update Post"
     * )
     * @OA\RequestBody(
     *     @Model(type=UpdatePostCommand::class)
     * )
     */
    #[Route('/api/posts/{$id}/update', name: 'api_post_update', methods: ['PUT'])]
    public function updatePost(Request $request, $id): JsonResponse
    {
        $post = $this->postRepository->find($id);

        if (!$post) {
            return $this->json("Not Found", Response::HTTP_NOT_FOUND);
        }

        if ($post->isAuthor($this->getUser())) {
            return $this->json('Nie posiadasz uprawnień do edycji tego postu!');
        }

        $parameters = json_decode($request->getContent(), true);

        if (!$parameters) {
            throw new \InvalidArgumentException();
        }
        try {
            $post
                ->setTitle($parameters['title'])
                ->setContent($parameters['content'])
                ->setActive($parameters['active'])
                ->setAuthor($this->getUser());

            $this->commandBus->dispatch(new UpdatePostCommand($post));

            return $this->json('Post pomyślnie zaktualizowany!');
        } catch (\Exception $exception) {
            return $this->json($exception->getMessage());
        }
    }
}
