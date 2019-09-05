<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Label extends Tag
{
    protected $tag = 'label';
    protected $allowed_tags = [];
    protected $allowed_text = true;
}
