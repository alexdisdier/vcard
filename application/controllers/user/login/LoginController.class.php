<?php


class LoginController
{
	public function httpGetMethod()
	{
		return [ '_form' => new LoginForm()	];
	}

	public function httpPostMethod(Http $http, array $formFields)
	{
		try
		{
			// We try to see if the user exists
			$userModel = new UserModel();
			$user      = $userModel->findWithEmailPassword
			(
				$formFields['email'],
				$formFields['password']
			);

			// If he exists, build the user session
			$userSession = new UserSession();
			$userSession->create
			(
				$user['Id'],
				$user['FirstName'],
				$user['LastName'],
				$user['Email']
			);

			// Once the session is build and the user is connected,
			// redirect the user to homepage
			$http->redirectTo('/');
		}

		// If the User email or password does not exist, we return an error message
		catch(DomainException $exception)
		{
			// Show the message on the front
			$form = new LoginForm();
			$form->bind($formFields);
			$form->setErrorMessage($exception->getMessage());

			return [ '_form' => $form ];
		}
	}
}
