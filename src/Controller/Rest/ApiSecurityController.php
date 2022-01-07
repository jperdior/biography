<?php

declare(strict_types=1);

namespace App\Controller\Rest;

use App\Entity\User;
use App\Entity\Person;
use App\Entity\Familiar;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class ApiSecurityController extends AbstractController
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/security/login", name="login")
     */
    public function loginAction(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $userClone = clone $user;
        $userClone->setPassword('');
        $data = $this->serializer->serialize($userClone, JsonEncoder::FORMAT,['circular_reference_handler'=> function($object){
            return $object->getId();
        }]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/security/register", name="register")
     */
    public function registerAction(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, JsonEncoder::FORMAT);
        $userExists = $managerRegistry->getManager()->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
        if ($userExists) {
            throw new RuntimeException('User already exists');
        }
        $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );
        $user->setEmail($user->getUsername());
        $user->setIsVerified(true);
        $managerRegistry->getManager()->persist($user);
        $managerRegistry->getManager()->flush();

        $person = new Person();
        $person->setUser($user);
        $person->setMainPerson(true);
        $parentOne = new Familiar();
        $parentOne->setChild($person);
        $parentTwo = new Familiar();
        $parentTwo->setChild($person);
        $person->addParent($parentOne);
        $person->addParent($parentTwo);
        $managerRegistry->getManager()->persist($person);
        $managerRegistry->getManager()->flush();

        return new JsonResponse('', Response::HTTP_CREATED, [], true);
    }

    /**
     * @throws RuntimeException
     *
     * @Route("/security/logout", name="logout")
     */
    public function logoutAction(): void
    {
        throw new RuntimeException('This should not be reached!');
    }
}