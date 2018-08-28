<?php


class CoverController
{
	public function httpGetMethod(Http $http, array $queryFields)
	{
		// Query string validation
		if(array_key_exists('id', $queryFields) == true)
		{
			if(ctype_digit($queryFields['id']) == true)
			{

				// Get all the informations from the "cover" table
				$coverModel = new CoverModel();
				$cover      = $coverModel->find($queryFields['id']);

				/*
				* Serializatin of the "cover" table into
				* a JSON string of characters, then send the HTTP response
				*/
				$http->sendJsonResponse($about);
			}
		}

		// If an error occurs, redirect to homepage
		$http->redirectTo('/');
	}
}
