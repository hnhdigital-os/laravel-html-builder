<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Optgroup extends Tag
{
    protected $tag = 'optgroup';
    protected $allowed_tags = ['option'];
}
