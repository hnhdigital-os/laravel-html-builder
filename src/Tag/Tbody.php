<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Tbody extends Tag
{
    protected $tag = 'tbody';
    protected $allowed_tags = ['tr', 'thead'];
}
