<?php

namespace NilsWisiol\FlightManagementBundle\Controller;

use FOS\Rest\Util\Codes;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use NilsWisiol\FlightManagementBundle\Entity\Captain;
use NilsWisiol\FlightManagementBundle\Form\CaptainType;

/**
 */
class CaptainsController extends FOSRestController
{
	/**
	 * @Rest\View()
	 * GET /captains
	 */
	public function getCaptainsAction() {
		$flights = $this->getDoctrine()->getManager()->getRepository('NilsWisiolFlightManagementBundle:Captain')->findAll();
		return $flights;
	}
	
	/**
	 * @Rest\View()
	 * GET /captains/3
	 */
	public function getCaptainAction($slug) {
		return $this->loadCaptain($slug);		
	}
	
	public function postCaptainsAction(Request $request) {
		return $this->processCaptainForm(new Captain(), true);
	}
	
	/**
	 * @Rest\View()
	 */
	public function putCaptainAction($slug) {
		return $this->processCaptainForm($this->loadCaptain($slug), false);
	}
	
	/**
	 * @Rest\View()
	 */
	public function postCaptainAction($slug) {
		return $this->processCaptainForm($this->loadCaptain($slug), false);
	}
	
	/**
	 * @Rest\View(statusCode=204)
	 */	
	public function deleteCaptainAction($slug) {
		$em = $this->getDoctrine()->getManager();
		$em->remove($this->loadCaptain($slug));
		$em->flush();
	}
	
	private function processCaptainForm(Captain $captain, $isNew) {
		$form = $this->createForm(new CaptainType(), $captain);
		$form->bind($this->getRequest());
		
		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			if ($isNew) {
				$em->persist($captain);
			}
			$em->flush();
			if ($isNew) {
				$resp = $this->redirectView($this->generateUrl('get_flight', array('slug' => $captain->getId())), Codes::HTTP_CREATED);
				$resp->setData($captain);
				return $resp;
			} else {
				return null;
			}
		}
		
		return array('form' => $form);		
	}
	
	private function loadCaptain($slug) {
		$em = $this->getDoctrine()->getManager();
		$captain = $em->getRepository('NilsWisiolFlightManagementBundle:Captain')->find($slug);
		
		if (!$captain) {
			throw $this->createNotFoundException("No such captain.");
		}

		return $captain;
	}
}
