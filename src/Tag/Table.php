<?php

namespace LaravelHtmlBuilder\Tag;

use LaravelHtmlBuilder\Tag;

class Table extends Tag
{
    protected $tag = 'table';
    protected $allowed_tags = ['tbody', 'tr'];
}
