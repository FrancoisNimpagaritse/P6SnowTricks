<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\ResetPassType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Service\ImageUploader;
use App\Form\PasswordUpdateType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Proxies\__CG__\App\Entity\User as EntityUser;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class AccountController extends AbstractController
{
    /**
     * Permet d'afficher et de gérer le formulaire de connexion
     * 
     * @Route("/login", name="account_login")
     * 
     * @return Response 
     */
    public function login(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $username = $authUtils->getLastUsername();
        $customMessage = null;
        if ($error instanceof CustomUserMessageAccountStatusException) {
            $customMessage = $error->getMessage();
        }

        return $this->render('account/login.html.twig', [
            'hasError'  =>  $error != null,
            'customMessage'    =>   $customMessage ? $customMessage: null,
            'username' =>  $username
        ]);
    }

    /**
     * Permet de se déconnecter
     * 
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout()
    {
        //.. rien
    }

    /**
     * Permet aux utilisateurs de s'enregistrer
     * 
     * @Route("/register", name="account_register")
     * 
     * @return Response
     */
    public function register(Request $request, ImageUploader $uploader, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, MailerInterface $mailer)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadImageName = $form->get('imgName')->getData();

            if ($uploadImageName) {
                $newImageFilename = $uploader->upload($uploadImageName);
                //On renseigne le nom qui sera en BD
                $user->setImageName($newImageFilename);
            }

            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            $user->setUpdatedAt(new \DateTime());

            //On génère le token d'activation
            $user->setActivationToken(md5(uniqid()));

            $manager->persist($user);
            $manager->flush();

            
            //On crée le message et on envoie le mail
            $email = (new Email())
            //On renseigne l'expéditeur
                    ->from('support@franimpa.fr')
            //On renseigne le destinataire
                    ->to($user->getEmail())
            //On renseigne l'objet
                    ->subject('Activation de votre compte')
                    ->html($this->renderView('account/activation.html.twig', ['token' => $user->getActivationToken()]),
                        'UTF-8'
                        );

            $mailer->send($email);

            $this->addFlash(
                'success',
                "Votre compte a bien été créé. Un mail vient de vous être envoyé, veuillez le consulter pour activer votre compte !"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form'  =>  $form->createView()
        ]);
    }

    /**
     * Permet d'afficher et de traiter le formulaire de modification du profil
     * 
     * @Route("/account/profile", name="account_profile")
     * 
     * @return response
     */
    public function profile(Request $request, ImageUploader $uploader, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadImageName = $form->get('imgName')->getData();

            if ($uploadImageName) {
                $newImageFilename = $uploader->upload($uploadImageName);
                //On renseigne le nom qui sera en BD
                $user->setImageName($newImageFilename);
            }
            
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success',
                             "Les données du profil ont été modifiées avec succès !");
        }

        return $this->render('account/profile.html.twig', [
                'form'  =>  $form->createView()
        ]);
    }

    /**
     * Permet de modifier le mot de passe
     * 
     * @Route("/account/password-update", name="account_password")
     * 
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        //Ve=érifier que le oldPassword du formulaire correspond au hash de li'utilisateur
        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getHash())) {
                //On gère l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe saisi ne cprrespond pas à votre mot de passe actuel !"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);
                $user->setHash($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success',
                                "Votre mot de passe a bien été modifié !"
                );

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('account/password.html.twig', [
                'form'  =>  $form->createView()
        ]);
    }

    /**
     * Permet d'activer le compte du client
     * @Route("/activation/{token}", name="account_activation")
     * 
     * @return Response
     */
    public function activate($token, UserRepository $repo, EntityManagerInterface $manager)
    {
        //On vérifie si l'utilisateur a ce token
        $user = $repo->findOneBy(['activationToken' => $token]);

        //Si aucun utilisateur n'a pas ce token erreur 404
        if (!$user) {
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        //On supprime le token après activation
        $user->setActivationToken(null);

        $manager->persist($user);
        $manager->flush();

        $this->addFlash('success', 'Vous avez bien activé votre compte. Vous pouvez maintenant vous connectez.');



        return $this->redirectToRoute('account_login');
    }

    /**
     * Permet de demander à réinitimaiser son mot de passe
     * @Route("/forgotten-password", name="account_forgotten_password")
     * 
     * @return Response
     */
    public function forgottenPassword(Request $request, UserRepository $repo,
    MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            //on cherche si un utilisateur possède cet email
            $user = $repo->findOneByEmail($data['email']);
            //Si l'utilisateur n'existe pas 404
            if (!$user) {
                //On envoie un message flash
                $this->addFlash('danger', 'Cette adresse email n\'existe pas !');

                return $this->redirectToRoute('account_login');
            }
            //On génère un token
            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $manager->persist($user);
                $manager->flush();

            } catch(\Exception $e) {
                $this->addFlash('warning', 'Une erreur est survenue' . $e->getMessage());
                return $this->redirectToRoute('account_login');
            }

            //On génère l'url de réinitialisation
            $url = $this->generateUrl('account_reset-password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            //On envoie le message
            //2. On envoie le mail
            $email = (new Email())
                    ->from('support@franimpa.fr')
                    ->to($user->getEmail())
                    ->subject('Mot de passe oublié')
                    ->text('Une demande de réinitialisation du mot de passe a été effectuée 
                    pour le site snowtricks.franimpa.fr, veuillez cliquer sur le lien
                    suivant : ' . $url );
                  
            $mailer->send($email);

            $this->addFlash('success', 'Un mail de réinitialisation de mot de passe vient de vous être envoyé.');

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/forgottenpassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'initialiser un mot de passe
     * @Route("/reset-password/{token}", name="account_reset-password")
     * 
     * @return Response
     */
    public function resetpassword($token, Request $request, UserRepository $repo, 
    UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        //On cherche l'utilisateur avec le token fourni
        $user = $repo->findOneBy(['resetToken' => $token]);

        if (!$user) {
            $this->addFlash('danger', 'Token inconnu !');

            return $this->redirectToRoute('account_login');
        }

        if ($request->isMethod('POST')) {
            //On supprime le token
            $user->setResetToken(null);

            //On reinitialise le mot de passe
            $user->setHash($encoder->encodePassword($user, $request->request->get('password')));
            
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Mot de passe modifié avec succès.');

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/resetpassword.html.twig', ['token' => $token]);
    }
}
