<?php

namespace LaravelHtmlBuilder\Tag;

use LaravelHtmlBuilder\Tag;

class Tbody extends Tag
{
    protected $tag = 'tbody';
    protected $allowed_tags = ['td'];
}