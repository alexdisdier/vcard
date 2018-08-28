<?php

class Http
{
	private $requestMethod;

	private $requestPath;

	public function __construct()
	{
		$this->requestMethod = $_SERVER['REQUEST_METHOD'];

		if(isset($_SERVER['PATH_INFO']) == false || $_SERVER['PATH_INFO'] == '/')
		{
			$this->requestPath = null;
		}
		else
		{
			$this->requestPath = strtolower($_SERVER['PATH_INFO']);
		}
	}

	public function getRequestFile()
	{
		if($this->requestPath == null)
		{
			return 'Home';
		}

        $pathSegments = explode('/', $this->requestPath);

        if(($pathSegment = array_pop($pathSegments)) == null)
        {
            // A trailing slash was added to the URL, remove it.
            $pathSegment = array_pop($pathSegments);
        }

        return ucfirst($pathSegment);
	}

	public function getRequestMethod()
	{
		return $this->requestMethod;
	}

	public function getRequestPath()
	{
		return $this->requestPath;
	}

  public function getUploadedFile($name)
  {
        if(array_key_exists($name, $_FILES) == true)
        {
            if($_FILES[$name]['error'] == UPLOAD_ERR_OK)
            {
                return $_FILES[$name];
            }
        }

        return false;
    }

  public function hasUploadedFile($name)
  {
        if(array_key_exists($name, $_FILES) == true)
        {
            if($_FILES[$name]['error'] == UPLOAD_ERR_OK)
            {
                return true;
            }
        }

        return false;
    }

  public function moveUploadedFile($name, $path = null)
  {
        if($this->hasUploadedFile($name) == false)
        {
            return false;
        }

        // Build the absolute path to the destination file.
        $filename = WWW_PATH."$path/".$_FILES[$name]['name'];

        move_uploaded_file($_FILES[$name]['tmp_name'], $filename);

        return pathinfo($filename, PATHINFO_BASENAME);
    }

	public function redirectTo($url)
	{
		if(substr($url, 0, 1) !== '/')
		{
			$url = "/$url";
		}

		// Change the string http to https once in production
		//Source: https://stackoverflow.com/questions/85816/how-can-i-force-users-to-access-my-page-over-https-instead-of-http
		//http://thisinterestsme.com/php-forcing-https-over-http/
		if ($_SERVER['SERVER_NAME'] == IS_PROD_ENV ) {
			header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['SCRIPT_NAME'].$url);
			exit();
		} else {
			header('Location: https://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['SCRIPT_NAME'].$url);
			exit();
		}
	}

	public function sendJsonResponse($data)
	{
        echo json_encode($data);
		exit();
	}
}
