<?php

namespace LaravelHtmlBuilder\Tag;

use LaravelHtmlBuilder\Tag;

class Tr extends Tag
{
    protected $tag = 'tr';
    protected $allowed_tags = ['td'];
}
