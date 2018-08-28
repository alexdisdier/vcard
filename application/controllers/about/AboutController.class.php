<?php


class AboutController
{
	public function httpGetMethod(Http $http, array $queryFields)
	{
		// Query string validation
		if(array_key_exists('id', $queryFields) == true)
		{
			if(ctype_digit($queryFields['id']) == true)
			{
				// Get all the informations from the "about" table
				$aboutModel = new AboutModel();
				$about      = $aboutModel->find($queryFields['id']);

				/*
				* Serialization of the "about" table into
				* a JSON string of characters, then send the HTTP response
				*/
				$http->sendJsonResponse($about);
			}
		}

		// If an error occurs, redirect to homepage
		$http->redirectTo('/');
	}
}
