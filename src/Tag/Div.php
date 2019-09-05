<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Div extends Tag
{
    protected $tag = 'div';
    protected $allowed_tags = [];
    protected $allowed_text = true;
}
