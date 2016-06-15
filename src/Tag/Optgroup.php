<?php

namespace LaravelHtmlBuilder\Tag;

use LaravelHtmlBuilder\Tag;

class Optgroup extends Tag
{
    protected $tag = 'optgroup';
    protected $allowed_tags = ['option'];
}
