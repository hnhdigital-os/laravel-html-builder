<?php

namespace LaravelHtmlBuilder\Tag;

use LaravelHtmlBuilder\Tag;

class Select extends Tag
{
    protected $tag = 'select';
    protected $allowed_tags = ['option', 'optgroup'];
}
