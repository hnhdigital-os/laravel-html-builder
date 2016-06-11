<?php

namespace LaravelHtmlBuilder;

use HtmlGenerator\HtmlTag;

class Tag
{
    private static $tag_registry = [];
    protected $tag;
    protected $text = '';
    protected $attributes = [];
    protected $child_nodes = [];
    protected $allowed_tags = [];
    protected $allowed_text = false;

    /**
     * Create a tag instance
     *
     * @return void
     */
    public function __construct($attributes = [], $text = '')
    {
        $this->setAttributes($attributes);
        $this->setText($text);
    }

    public function setText($value)
    {
        if (!empty($value)) {
            $this->text = $value;
        }
    }

    public function getText()
    {
        return $this->text;
    }

    public function setAttributes()
    {
        $attributes = func_get_args();
        if (count($attributes)) {
            if (count($attributes) == 1 && is_array($attributes[0])) {
                $attributes = $attributes[0];
            }
        }
    }

    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function getAttribute($name)
    {
        return (isset($this->attributes[$name])) ? $this->attributes[$name] : null;
    }

    public function add($tag, $attributes = [], $text = '')
    {
        $tag = strtolower($tag);
        if (in_array($tag, $this->$allowed_tags)) {
            $index = count($this->child_nodes);
            $class_name = 'LaravelHtmlBuilder\\Tag\\'.$tag;
            if (class_exists($class_name)) {
                $tag_object = $class_name($attributes, $text);
                Tag::$tag_registry[] = &$tag_object;
                $this->child_nodes[] = &$tag_object;
                return $tag_object;
            }
        }
    }

    public function __toString()
    {
        $html = HtmlTag::createElement($this->tag);

        return (string)$html;
    }

    public function getHtml()
    {
        return (string)$this;
    }

    public function getJson()
    {
        $result = [$this->tag, []];
        return json_encode($result);
    }

}