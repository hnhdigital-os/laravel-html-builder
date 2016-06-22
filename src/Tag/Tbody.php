<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Tbody extends Tag
{
    protected $tag = 'tbody';
    protected $allowed_tags = ['tr'];
}
