<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Ul extends Tag
{
    protected $tag = 'ul';
    protected $allowed_tags = ['li'];
}
