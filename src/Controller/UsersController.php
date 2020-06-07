<?php

namespace App\Controller;

use App\Entity\User;
use App\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class UsersController extends AbstractController
{

    /**
     * @Route("/users", name="users")
     */
    public function __invoke(Request $request, UserPasswordEncoderInterface $userPasswordEncoder){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('pages/users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user-delete/{id}", name="user-delete", requirements={"id":"\d+"})
     */
    public function deleteUser(Request $request, User $user){
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_USER_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'L\'utilisateur et ses accés ont été supprimés.');

        return $this->redirectToRoute('users');
    }

    /**
     * @Route("/user-add", name="user-add")
     */
    public function addUser(
        Request $request,
        UserPasswordEncoderInterface $userPasswordEncoder,
        \Swift_Mailer $mailer
    ){
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $RawPassword = $this->randomPassword(10);
            $password = $userPasswordEncoder->encodePassword($user, $RawPassword);
            if($form->get("isAdmin")->getData() === 1) $user->setRoles('ROLE_ADMIN');
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $html = $this->renderView('emails/registration.html.twig', [
                'email' => $user->getEmail(),
                'mdp' => $RawPassword,
                'url' => getenv('DOMAIN_URL'),
            ]);

            $message = (new \Swift_Message('Création d\'accés au gestionnaire de devis'))
                ->setFrom(getenv('INSCRIPTION_EMAIL'))
                ->setTo($user->getEmail())
                ->setBody($html,'text/html');

            $mailer->send($message);

            $this->addFlash('success', 'Les accés pour l\'utilisateur ' . $user->getUserName() . ' ont été créés. 
            Un email a été envoyé à cette adresse avec le mot de passe qui a été généré automatiquement.');

            // for dev or/and testing purpose, this return the raw password whenever a user is created
            if(getenv('APP_DEV')==='dev' || ($this->get('security.authorization_checker')->isGranted("ROLE_ADMIN"))) {
                $this->addFlash('warning', 'Mot de passe du compte créé : ' . $RawPassword);
            }

            // for security, raw have to be erased
            $RawPassword = null;

            return $this->redirectToRoute('users');
        }

        return $this->render('pages/adduser.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    function randomPassword($lenght) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $lenght; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

}