<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Ol extends Tag
{
    protected $tag = 'ol';
    protected $allowed_tags = ['li'];
}
