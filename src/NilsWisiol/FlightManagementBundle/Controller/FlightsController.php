<?php

namespace NilsWisiol\FlightManagementBundle\Controller;
use FOS\Rest\Util\Codes;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use NilsWisiol\FlightManagementBundle\Entity\Flight;
use NilsWisiol\FlightManagementBundle\Form\FlightType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 */
class FlightsController extends FOSRestController {
	/**
	 * Gets the list of all flights. 
	 * 
	 * @Rest\View()
	 * 
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Returns all flights.",
	 *   statusCodes={
	 *     200="Returned when successful",
	 *   },
	 *   output="array(NilsWisiol\FlightManagementBundle\Form\FlightType)"
	 * )
	 */
	public function getFlightsAction() {
		$em = $this->getDoctrine()->getManager();
		$flights = $em
				->getRepository('NilsWisiolFlightManagementBundle:Flight')
				->findAll();
		return $flights;
	}

	/**
	 * Gets one specific flight.
	 * 
	 * @Rest\View()
	 * 
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Returns a flight.",
	 *   statusCodes={
	 *     200="Returned when successful",
	 *   },
	 *   output="NilsWisiol\FlightManagementBundle\Form\FlightType"
	 * )
	 */
	public function getFlightAction($slug) {
		return $this->loadFlight($slug);
	}

	/**
	 * Creates a new flight.
	 * 
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Creates a new flight.",
	 *   statusCodes={
	 *     201="Successfully created",
	 *   },
	 *   output="NilsWisiol\FlightManagementBundle\Form\FlightType"
	 * )
	 */
	public function postFlightsAction(Request $request) {
		return $this->processFlightForm(new Flight(), true);
	}
	
	/**
	 * Creates a new flight.
	 *
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Creates a new flight.",
	 *   statusCodes={
	 *     201="Successfully created",
	 *   },
	 *   output="NilsWisiol\FlightManagementBundle\Form\FlightType"
	 * )
	 */
	public function putFlightsAction(Request $request) {
		return $this->processFlightForm(new Flight(), true);
	}	

	/**
	 * Updates a flight.
	 * 
	 * @Rest\View()
	 * 
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Creates a new flight.",
	 *   statusCodes={
	 *     200="Successfully updated",
	 *   },
	 *   output="NilsWisiol\FlightManagementBundle\Form\FlightType"
	 * )
	 */
	public function putFlightAction($slug) {
		return $this->processFlightForm($this->loadFlight($slug), false);
	}

	/**
	 * Updates a flight.
	 * 
	 * @Rest\View()
	 * 
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Creates a new flight.",
	 *   statusCodes={
	 *     200="Successfully updated",
	 *   },
	 *   output="NilsWisiol\FlightManagementBundle\Form\FlightType"
	 * )
	 */
	public function postFlightAction($slug) {
		return $this->processFlightForm($this->loadFlight($slug), false);
	}

	/**
	 * Deletes a flight.
	 * 
	 * @Rest\View(statusCode=204)
	 * 
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Creates a new flight.",
	 *   statusCodes={
	 *     204="Successfully deleted",
	 *   }
	 * )
	 * 
	 */ 
	public function deleteFlightAction($slug) {
		$em = $this->getDoctrine()->getManager();
		$em->remove($this->loadFlight($slug));
		$em->flush();
	}

	private function processFlightForm(Flight $flight, $isNew) {
		$form = $this->createForm(new FlightType(), $flight);
		$form->bind($this->getRequest());

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			if ($isNew) {
				$em->persist($flight);
			}
			$em->flush();
			if ($isNew) {
				$resp = $this
						->redirectView(
								$this
										->generateUrl('get_flight',
												array(
														'slug' => $flight
																->getId())),
								Codes::HTTP_CREATED);
				$resp->setData($flight);
				return $resp;
			} else {
				return null;
			}
		}

		return array('form' => $form);
	}

	private function loadFlight($slug) {
		$em = $this->getDoctrine()->getManager();
		$flight = $em->getRepository('NilsWisiolFlightManagementBundle:Flight')
				->find($slug);

		if (!$flight) {
			throw $this->createNotFoundException("No such flight.");
		}

		return $flight;
	}
}
