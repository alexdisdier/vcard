<?php


class QuotesController
{
	public function httpGetMethod(Http $http, array $queryFields)
	{
		// Query string validation
		if(array_key_exists('id', $queryFields) == true)
		{
			if(ctype_digit($queryFields['id']) == true)
			{

				// Get all the informations from the "quotes" table
				$quotesModel = new QuotesModel();
				$quotes      = $quotesModel->find($queryFields['id']);

				/*
				* Serializatin of the "quotes" table into
				* a JSON string of characters, then send the HTTP response
				*/
				$http->sendJsonResponse($quotes);
			}
		}

		// If an error occurs, redirect to homepage
		$http->redirectTo('/');
	}
}
