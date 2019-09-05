<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Ol extends Tag
{
    protected $tag = 'ol';
    protected $allowed_tags = ['li'];
}
