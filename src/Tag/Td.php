<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Td extends Tag
{
    protected $tag = 'td';
    protected $allowed_tags = [];
    protected $allowed_text = true;
}
