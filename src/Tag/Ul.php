<?php

namespace LaravelHtmlBuilder\Tag;

use LaravelHtmlBuilder\Tag;

class Ul extends Tag
{
    protected $tag = 'ul';
    protected $allowed_tags = ['li'];
}
