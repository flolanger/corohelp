<?php

namespace Places\Controller;

use Places\Entity\User;
use Places\Form\LoginType;
use Places\Form\RegistrationType;
use Places\Form\ResetAccountType;
use Places\Repository\UserRepository;
use Places\Service\EmailService;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends AbstractController
{
    /**
     * @var EmailService
     */
    protected EmailService $emailService;

    /**
     * @param EmailService $emailService
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
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

            $this->emailService->sendConfirmationEmail($user);

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

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param string $token
     * @return Response
     */
    public function reset(Request $request, UserRepository $userRepository, $token = '')
    {
        $form = $this->createForm(ResetAccountType::class);
        $form->handleRequest($request);

        $emailSent = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $userRepository->findOneBy(['email' => $email]);
            if ($user instanceof User) {
                $user->updatePasswordResetToken();
                $this->getDoctrine()->getManager()->flush();
                $this->emailService->sendPassworsResetEmail($user);
                $emailSent = true;
            }
        }

        return $this->render('authentication/reset.html.twig', [
            'resetForm' => $form->createView(),
            'emailSent' => $emailSent,
        ]);
    }

    public function logout()
    {
        throw new LogicException('Logout not configured in firewall');
    }
}
