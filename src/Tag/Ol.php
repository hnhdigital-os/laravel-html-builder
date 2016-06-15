<?php

namespace LaravelHtmlBuilder\Tag;

use LaravelHtmlBuilder\Tag;

class Ol extends Tag
{
    protected $tag = 'ol';
    protected $allowed_tags = ['li'];
}
