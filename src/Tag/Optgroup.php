<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Optgroup extends Tag
{
    protected $tag = 'optgroup';
    protected $allowed_tags = ['option'];
}
