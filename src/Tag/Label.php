<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Label extends Tag
{
    protected $tag = 'label';
    protected $allowed_tags = [];
    protected $allowed_text = true;
}
