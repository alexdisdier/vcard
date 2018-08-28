<?php


class ProfileController
{
	public function httpGetMethod(Http $http, array $queryFields)
	{
		// Query string validation
		if(array_key_exists('id', $queryFields) == true)
		{
			if(ctype_digit($queryFields['id']) == true)
			{

				// Get all the informations from the "profile" table
				$profileModel = new ProfileModel();
				$profile      = $profileModel->find($queryFields['id']);

				/*
				* Serializatin of the "profile" table into
				* a JSON string of characters, then send the HTTP response
				*/
				$http->sendJsonResponse($profile);
			}
		}

		// If an error occurs, redirect to homepage
		$http->redirectTo('/');
	}
}
