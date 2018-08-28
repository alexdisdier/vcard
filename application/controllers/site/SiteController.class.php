<?php

class SiteController
{
  public function httpGetMethod(Http $http, array $queryFields)
  {
    // Query string validation
    if(array_key_exists('id', $queryFields) == true)
    {
      if(ctype_digit($queryFields['id']) == true)
      {
        // Get all the informations from the "site_description" table
        $siteModel = new SiteModel();
        $site      = $siteModel->find($queryFields['id']);

        /*
        * Serializatin of the "site_description" table into
        * a JSON string of characters, then send the HTTP response
        */
        $http->sendJsonResponse($site);
      }
    }

    // If an error occurs, redirect to homepage
    $http->redirectTo('/');
  }
}
