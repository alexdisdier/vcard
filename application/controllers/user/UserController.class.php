<?php


class UserController
{
	public function httpGetMethod()
	{
		return [ '_form' => new UserForm() ];
	}

	public function httpPostMethod(Http $http, array $formFields)
	{
		try
		{
			// Signup first time user as administrator
			$userModel = new UserModel();
			//Only one user can be registered per site.
			if ($userModel->userExist() == False){
				$userModel->signUp
				(
					$formFields['lastName'],
					$formFields['firstName'],
					$formFields['email'],
					$formFields['password']
				);
			}

			// redirect the user to homepage
			$http->redirectTo('/');
		}
		catch(DomainException $exception)
		{
				// Show the error message on the front
			$form = new UserForm();
			$form->bind($formFields);
			$form->setErrorMessage($exception->getMessage());

			return [ '_form' => $form ];
		}
	}
}
