<?php

namespace App\Controller;

use App\Form\ProfileType;
use FontLib\EOT\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/perfil", name="perfil")
     */
    public function profile(Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $old_img = $this->getUser()->getAvatar();

        $form = $this->createForm(ProfileType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $profile = $form->getData();
            $uploadedFile = $form['avatar']->getData();

            if($uploadedFile != null) {

                $destination = $this->getParameter('kernel.project_dir').'/public/img';

                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $profile->setAvatar($newFilename);
            }else {
                $profile->setAvatar($old_img);
            }
            
            $entityManager->persist($profile);
            $entityManager->flush();
        }
        
        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
            'profileForm' =>$form->createView(),
        ]);
    }
}