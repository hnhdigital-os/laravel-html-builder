<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Tr extends Tag
{
    protected $tag = 'tr';
    protected $allowed_tags = ['td'];
}
