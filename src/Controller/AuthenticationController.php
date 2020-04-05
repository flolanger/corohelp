<?php

namespace Corohelp\Controller;

use Corohelp\Entity\User;
use Corohelp\Form\LoginType;
use Corohelp\Form\RegistrationType;
use Corohelp\Repository\UserRepository;
use Corohelp\Service\EmailService;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EmailService $emailService
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EmailService $emailService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRole('ROLE_USER');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $emailService->sendConfirmationEmail($user);

            return $this->redirectToRoute('index');
        }

        return $this->render('authentication/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(LoginType::class);

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'authentication/login.html.twig',
            [
                'loginForm' => $form->createView(),
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );
    }

    /**
     * @param string $token
     * @return Response
     */
    public function confirm(string $token)
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['emailConfirmationToken' => $token]);

        $userConfirmed = false;
        if ($user instanceof User) {
            $user->setConfirmed(true);
            $entityManager->flush();
            $userConfirmed = true;
        }
        return $this->render(
            'authentication/confirm.html.twig',
            [
                'userConfirmed' => $userConfirmed
            ]
        );
    }

    public function logout()
    {
        throw new LogicException('Logout not configured in firewall');
    }
}
