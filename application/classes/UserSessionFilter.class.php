<?php

class UserSessionFilter implements InterceptingFilter
{
	public function run(Http $http, array $queryFields, array $formFields)
	{
		return
        [
            'userSession' => new UserSession()
        ];
	}
}