<?php

abstract class Form
{
    private $errorMessage;

    private $formFields;


    abstract public function build();


    public function __construct()
    {
        $this->errorMessage = null;
        $this->formFields   = array();
    }

    protected function addFormField($name, $value = null)
    {
        $this->formFields[$name] = $value;
    }

    public function bind(array $formFields)
    {
        $this->build();

        foreach($formFields as $name => $value)
        {
            if(array_key_exists($name, $this->formFields) == true)
            {
                $this->formFields[$name] = $value;
            }
        }
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function getFormFields()
    {
        return $this->formFields;
    }

    public function hasFormFields()
    {
        return empty($this->formFields) == false;
    }

    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
}
