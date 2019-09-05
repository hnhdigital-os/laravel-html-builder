<?php

class FakeRequest
{
    public $ajax = false;

    public function ajax()
    {
        return $this->ajax;
    }
}

$request_object = new FakeRequest();

function request()
{
    global $request_object;

    return $request_object;
}

function hookAddClassHtmlTag($class_name)
{
}

function config($key, $default)
{
    return $default;
}
