<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Th extends Tag
{
    protected $tag = 'th';
    protected $allowed_tags = [];
    protected $allowed_text = true;
}
