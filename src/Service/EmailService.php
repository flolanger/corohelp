<?php

namespace Corohelp\Service;

use Corohelp\Entity\User;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * Class EmailService
 */
class EmailService
{
    /**
     * @var Swift_Mailer
     */
    protected Swift_Mailer $mailer;

    /**
     * @var Environment
     */
    protected Environment $twig;

    /**
     * @var TranslatorInterface
     */
    protected TranslatorInterface $translator;

    /**
     * @var ParameterBagInterface
     */
    protected ParameterBagInterface $params;

    /**
     * @param Swift_Mailer $mailer
     * @param Environment $twig
     * @param TranslatorInterface $translator
     * @param ParameterBagInterface $params
     */
    public function __construct(
        Swift_Mailer $mailer,
        Environment $twig,
        TranslatorInterface $translator,
        ParameterBagInterface $params
    )
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->translator = $translator;
        $this->params = $params;
    }

    /**
     * @param User $user
     */
    public function sendConfirmationEmail(User $user)
    {
        $emailParams = $this->params->get('email');
        $message = (new Swift_Message($this->translator->trans('email.registration.subject')))
            ->setFrom($emailParams['registrationFrom'])
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderBody('email/registration.html.twig', ['token' => $user->getEmailConfirmationToken()]),
                'text/html'
            );
        $this->mailer->send($message);
    }

    /**
     * @param User $user
     */
    public function sendPassworsResetEmail(User $user)
    {
        $emailParams = $this->params->get('email');
        $message = (new Swift_Message($this->translator->trans('email.passwordReset.subject')))
            ->setFrom($emailParams['registrationFrom'])
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderBody('email/resetPassword.html.twig', ['token' => $user->getPasswordResetToken()]),
                'text/html'
            );
        $this->mailer->send($message);
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     * @noinspection PhpUnhandledExceptionInspection
     * @param string $template
     * @param array $arguments
     * @return string
     */
    protected function renderBody(string $template, array $arguments = []): string
    {
        return $this->twig->render(
            $template,
            $arguments
        );
    }
}