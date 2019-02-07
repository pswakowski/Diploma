<?php

// take care of taking request from url and processing an action we wanna call
// url/users/register -> calls register function of the users class (works with htaccess)

class Bootstrap
{
    private $controller;
    private $action;
    private $request;

    public function __construct($request)
    {
        $this->request = $request;

        if ($this->request['controller'] == "")
        {
            $this->controller = 'Home';
        } else
        {
            $this->controller = $this->request['controller'];
        }

        // action
        if ($this->request['action'] == "")
        {
            $this->action = 'index';
        } else
        {
            $this->action = $this->request['action'];
        }

    }

    public function createController()
    {
        // check Class, we have controller set at the beginning so ve have access to it
        if(class_exists($this->controller))
        {
            $parents = class_parents($this->controller);

            // check extend - if controller includes the action passed in
            if (in_array("Controller", $parents))
            {
                if (method_exists($this->controller, $this->action))
                {
                    return new $this->controller($this->action, $this->request);
                }
                else
                {
                  // Method doesnt exist
                    echo '<h1>404 - Metoda nie istnieje.</h1>';
                    return;
                }
            } else
            {
                // Base controller doesnt exist
                echo '<h1>404 - Kontroler nie istnieje.</h1>';
                return;
            }
        } else
        {
            // Controller class doesnt exist
            echo '<h1>404 - Klasa kontrolera nie istnieje.</h1>';
            return;
        }
    }
}