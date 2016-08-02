<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Thead extends Tag
{
    protected $tag = 'thead';
    protected $allowed_tags = ['tr'];
}
