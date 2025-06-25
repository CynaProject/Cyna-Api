<?php
namespace App\Controller;

use App\Repository\PendingUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\MailerService;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;

class ValidationController extends AbstractController
{
   #[Route('/api/valider-inscription/{token}', name: 'app_registration_validate', methods: ['GET'])]
    public function validate(
        string $token,
        PendingUserRepository $pendingRepo,
        UserRepository $userRepo,
        EntityManagerInterface $em,
    ): Response {
        $pendingUser = $pendingRepo->findOneBy(['token' => $token]);

        if (!$pendingUser) {
            return new Response("Lien invalide ou déjà utilisé.", 400);
        }

        if ($pendingUser->getExpiresAt() < new \DateTimeImmutable()) {
            return new Response("Lien expiré. Veuillez recommencer l'inscription.", 400);
        }

        $user = $userRepo->findOneBy(['email' => $pendingUser->getEmail()]);
        $user->setIsValid(true);

        $em->remove($pendingUser);
        $em->flush();

        return new RedirectResponse('https://s5-5718.nuage-peda.fr/');
    }

    #[Route('/api/send-confirmation-email', name: 'send_confirmation_email', methods: ['POST'])]
    public function sendEmail(Request $request, MailerService $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email']) || !isset($data['token'])) {
            return new JsonResponse(['error' => 'Email et token requis.'], 400);
        }

        $sent = $mailer->sendConfirmationEmail($data['email'], $data['token']);

        if ($sent) {
            return new JsonResponse(['success' => true, 'message' => 'E-mail envoyé avec succès.']);
        } else {
            return new JsonResponse(['success' => false, 'error' => 'Erreur lors de l\'envoi de l\'email.'], 500);
        }
    }

}


