<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserRegistrationForm;

class UserController extends Controller
{
	/**
	 * @Route("/register", name="user_register")
	 */
	public function registerAction(Request $request)
	{
		$form = $this->createForm(UserRegistrationForm::class);
		$form->handleRequest($request);
		if ($form->isValid()) {
			$user = $form->getData();
			$em = $this->getDoctrine()->getManager(); 
			$em->persist($user);
			$em->flush();
			$this->addFlash('success', 'Welcome '.$user->getEmail());

			return $this->redirectToRoute('homepage');
		}
		return $this->render('user/register.html.twig', [ 
			'form' => $form->createView()
		]);
	}

}