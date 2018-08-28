<?php


class SocialController
{
	public function httpGetMethod(Http $http, array $queryFields)
	{
		// Query string validation
		if(array_key_exists('id', $queryFields) == true)
		{
			if(ctype_digit($queryFields['id']) == true)
			{
				// Get all the informations from the "social_media" table
				$socialModel = new SocialModel();
				$social      = $socialModel->find($queryFields['id']);

				/*
				* Serializatin of the "social_media" table into
				* a JSON string of characters, then send the HTTP response
				*/
				$http->sendJsonResponse($social);
			}
		}

		// If an error occurs, redirect to homepage
		$http->redirectTo('/');
	}
}
