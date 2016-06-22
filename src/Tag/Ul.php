<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Ul extends Tag
{
    protected $tag = 'ul';
    protected $allowed_tags = ['li'];
}
