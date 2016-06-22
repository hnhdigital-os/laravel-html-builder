<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Td extends Tag
{
    protected $tag = 'td';
    protected $allowed_tags = [];
    protected $allowed_text = true;
}
