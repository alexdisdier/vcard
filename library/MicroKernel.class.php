<?php

class MicroKernel
{
    /** @var string */
    private $applicationPath;

    /** @var Configuration $configuration */
    private $configuration;

    /** @var string */
    private $controllerPath;


    public function __construct()
    {
        $this->applicationPath = realpath(ROOT_PATH.'/application');
        $this->configuration   = new Configuration();
        $this->controllerPath  = null;
    }

    public function bootstrap()
    {
        // Enable project classes autoloading.
        spl_autoload_register([ $this, 'loadClass' ]);

        // Load configuration files.
        $this->configuration->load('database');
        $this->configuration->load('library');

        // Convert all PHP errors to exceptions.
        error_reporting(E_ALL);
        set_error_handler(function($code, $message, $filename, $lineNumber)
        {
            throw new ErrorException($message, $code, 1, $filename, $lineNumber);
        });

        return $this;
    }

    public function loadClass($class)
    {
        // Enable PSR-4 style namespace support.
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        if(substr($class, -10) == 'Controller')
        {
            // This is a controller class file.
            $filename = "$this->controllerPath/$class.class.php";
        }
        else if(substr($class, -4) == 'Form')
        {
            // This is a form class file.
            $filename = "$this->applicationPath/forms/$class.class.php";
        }
        elseif(substr($class, -5) == 'Model')
        {
            // This is a model class file.
            $filename = "$this->applicationPath/models/$class.class.php";
        }
        else
        {
            // This is an application class file (outside of MVC).
            $filename = "$this->applicationPath/classes/$class.class.php";
        }

        if(file_exists($filename) == true)
        {
            /** @noinspection PhpIncludeInspection */
            include $filename;
        }
        else
        {
            if($this->configuration->get('library', 'autoload-chain', false) == false)
            {
                throw new ErrorException
                (
                    "The class <strong>$class</strong> could not been found ".
                    "in the folder<br><strong>$filename</strong>"
                );
            }
        }
    }

    public function run(FrontController $frontController)
    {
        try
        {
            // Enable output buffering.
            ob_start();

            // Build the HTTP context data.
            $requestPath = $frontController->buildContext($this->configuration);

            // Build the controller path string for controller class autoloading.
            $this->controllerPath = "$this->applicationPath/controllers$requestPath";

            // Execute the front controller.
            $frontController->run();
            $frontController->renderView();

            // Send HTTP response and turn off output buffering.
            ob_end_flush();
        }
        catch(Exception $exception)
        {
            // Destroy any output buffer contents that could have been added.
            ob_clean();

            $frontController->renderErrorView
            (
                implode('<br>',
                [
                    $exception->getMessage(),
                    "<strong>File</strong> : ".$exception->getFile(),
                    "<strong>Line</strong> : ".$exception->getLine()
                ])
            );
        }
    }
}
