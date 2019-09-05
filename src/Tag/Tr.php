<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Tr extends Tag
{
    protected $tag = 'tr';
    protected $allowed_tags = ['td', 'th'];
}
