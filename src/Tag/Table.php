<?php

namespace HnhDigital\LaravelHtmlBuilder\Tag;

use HnhDigital\LaravelHtmlBuilder\Tag;

class Table extends Tag
{
    protected $tag = 'table';
    protected $allowed_tags = ['tbody', 'thead', 'tr'];
}
