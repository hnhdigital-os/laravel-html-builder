<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Div extends Tag
{
    protected $tag = 'div';
    protected $allowed_tags = [];
    protected $allowed_text = true;
}
