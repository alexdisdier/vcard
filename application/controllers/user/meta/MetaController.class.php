<?php

class MetaController
{
  public function httpGetMethod(Http $http, array $queryFields)
  {
    // Query string validation
    if(array_key_exists('id', $queryFields) == true)
    {
      if(ctype_digit($queryFields['id']) == true)
      {
        // Get all the informations from the "meta" table
        $metaModel = new MetaModel();
        $meta      = $metaModel->find($queryFields['id']);

        /*
        * Serializatin of the "meta" table into
        * a JSON string of characters, then send the HTTP response
        */
        $http->sendJsonResponse($meta);
      }
    }

    // If an error occurs, redirect to homepage
    $http->redirectTo('/');
  }
}
