<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Th extends Tag
{
    protected $tag = 'th';
    protected $allowed_tags = [];
    protected $allowed_text = true;
}
