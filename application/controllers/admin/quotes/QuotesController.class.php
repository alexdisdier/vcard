<?php

class QuotesController
{
  public function httpGetMethod(Http $http)
  {
    $userSession = new UserSession();

    // We only have access if we're logged in
    if($userSession->isAuthenticated() == false)
    {

      // Otherwise, we redirect to the login page
      $http->redirectTo('/user/login');
    }
  }

  // Manipulate the data sent through the form
  // - ./www/admin/quotes/QuotesView.phtml
  public function httpPostMethod(Http $http, array $formFields)
  {
    $quotesModel = new QuotesModel();

    // Before inserting the new data from our form,
    // we delete the table and reset the id to 1
    $quotesModel->truncate();

    // Loop through the $formFields array
    for ($n = 0; $n < count($formFields)+2; $n++) {

      // Check if the user input a value
      if ( !empty($formFields['quote_content'][$n]) ) {

        // We create a new row in our 'quotes' table
        $quotesModel->create
        (
          $formFields['quote_content'][$n]
        );
      }
    }

    // Uncomment below if you want to log out the user after editing,
    // $userSession = new UserSession();
    // $userSession->destroy();

    // Once the data have been input, redirect the user to home page
    $http->redirectTo('/');
  }
}
