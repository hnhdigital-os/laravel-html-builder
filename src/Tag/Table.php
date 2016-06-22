<?php

namespace Bluora\LaravelHtmlBuilder\Tag;

use Bluora\LaravelHtmlBuilder\Tag;

class Table extends Tag
{
    protected $tag = 'table';
    protected $allowed_tags = ['tbody', 'tr'];
}
