<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Select extends Tag
{
    protected $tag = 'select';
    protected $allowed_tags = ['option', 'optgroup'];
}
