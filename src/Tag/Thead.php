<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Thead extends Tag
{
    protected $tag = 'thead';
    protected $allowed_tags = ['tr'];
}
