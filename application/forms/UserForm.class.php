<?php

class UserForm extends Form
{
    public function build()
    {
        $this->addFormField('lastName');
        $this->addFormField('firstName');
        $this->addFormField('email');
    }
}
