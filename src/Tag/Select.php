<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Select extends Tag
{
    protected $tag = 'select';
    protected $allowed_tags = ['option', 'optgroup'];
}
