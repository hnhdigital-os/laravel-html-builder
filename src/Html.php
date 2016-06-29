<?php

namespace Bluora\LaravelHtmlBuilder;

use HtmlGenerator\Markup;

class Html extends Markup
{
    protected $autocloseTagsList = [
        'img', 'br', 'hr', 'input', 'area', 'link', 'meta', 'param'
    ];
    protected $tag = 'tag';

    /**
     * Add an action link.
     *
     * @return Html instance
     */
    public function action($text, $controller_action, $parameters = [])
    {
        return $this->add('a')->text($text)
            ->href(action($controller_action, $parameters));
    }

    /**
     * Add an action link (static).
     *
     * @return Html instance
     */
    public static function actionLink($text, $controller_action, $parameters = [])
    {
        return self::addElement('a')->text($text)
            ->href(action($controller_action, $parameters));
    }

    /**
     * Add an array of attributes
     *
     * @param array $attribute_list
     * @return Html instance
     */
    public function addAttributes($attribute_list)
    {

    }

    /**
     * Add a class to classList.
     *
     * @param string $value
     * @return Html instance
     */
    public function addClass($value)
    {
        $paramaters = func_get_args();
        if (count($paramaters) > 1) {
            $value = $paramaters;
        }
        if (!is_array($value)) {
            $value = explode(' ', $value);
        }
        if (!isset($this->attributeList['class']) || is_null($this->attributeList['class'])) {
            $this->attributeList['class'] = [];
        }
        foreach ($value as $class_name) {
            $class_name = trim($class_name);
            if (!empty($class_name)) {
                if (function_exists('hookAddClassHtmlTag')) {
                    hookAddClassHtmlTag($class_name);
                }
                $this->attributeList['class'][] = $class_name;
            }
        }
        return $this;
    }

    /**
     * Shortcut to set('for', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function addFor($value)
    {
        return parent::attr('for', $value);
    }

    /**
     * Create options
     */
    public function addOptionsArray($data, $value, $name, $selected_value = [])
    {
        if (!is_array($selected_value)) {
            $selected_value = [$selected_value];
        }
        foreach ($data as $data_option) {
            $option = $this->addElement('option')->value($data_option[$value])->text($data_option[$name]);
            if (in_array($data_option[$value], $selected_value)) {
                $option->selected('selected');
            }
        }
        return $this;
    }

    /**
     * Shortcut to set('autocomplete', $value). Only works with FORM, INPUT tags.
     *
     * @return Html instance
     */
    public function autocomplete()
    {
        if (in_array($this->tag, ['form', 'input'])) {
            return parent::attr('autocomplete', 'autofocus');
        }
        return $this;
    }

    /**
     * Shortcut to set('autofocus', $value). Only works with BUTTON, INPUT, KEYGEN, SELECT, TEXTAREA tags.
     *
     * @return Html instance
     */
    public function autofocus()
    {
        if (in_array($this->tag, ['button', 'input', 'keygen', 'select', 'textarea'])) {
            return parent::attr('autofocus', 'autofocus');
        }
        return $this;
    }

    /**
     * Shortcut to set('checked', $value).
     *
     * @param boolean $value
     * @param boolean $check_value
     * @return Html instance
     */
    public function checked($value = true, $check_value = true)
    {
        if ($value === $check_value) {
            return parent::attr('checked', 'checked');
        }
        return $this;
    }

    /**
     * Create a new tag.
     *
     * @param string $tag
     * @param mixed $attributes1
     * @param mixed $attributes2
     * @return Markup instance
     */
    public static function createElement($tag = '', $attributes1 = [], $attributes2 = [])
    {
        $tag_object = parent::createElement($tag);
        $tag_object->setTag($tag);
        $attributes = $attributes1;
        if (!is_array($attributes1) && strlen($attributes1) > 0) {
            $tag_object->text($attributes1);
            $attributes = $attributes2;
        }
        if (is_array($attributes)) {
            foreach ($attributes as $name => $value) {
                if (method_exists($tag_object, $name)) {
                    if (!is_array($value)) {
                        $value = [$value];
                    }
                    call_user_func_array([$tag_object, $name], $value);
                }
            }
        }
        return $tag_object;
    }

    /**
     * Shortcut to set('data-$name', $value).
     *
     * @param string $name
     * @param string $value
     * @return Html instance
     */
    public function data($name, $value)
    {
        return parent::attr('data-'.$name, $value);
    }

    /**
     * Shortcut to set('disabled', $value).
     *
     * @param boolean $value
     * @param boolean $check_value
     * @return Html instance
     */
    public function disable($value = true, $check_value = true)
    {
        if ($value === $check_value) {
            return parent::attr('disabled', 'disabled');
        }
        return $this;
    }

    /**
     * Get the tag name.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Shortcut to set('height', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function height($value)
    {
        return parent::attr('height', $value);
    }

    /**
     * Shortcut to set('href', $value). Only works with A tags.
     *
     * @param string $value
     * @return Html instance
     */
    public function href($value = '')
    {
        if ($this->tag === 'a') {
            return parent::attr('href', $value);
        }
        return $this;
    }

    /**
     * Shortcut to set('id', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function id($value)
    {
        return $this->set('id', $value);
    }

    /**
     * Shortcut to for creating a label
     *
     * @param string $value
     * @return Html instance
     */
    public function label($text)
    {
        $id = $this->attributeList['id'];

        return Html::createElement('label')
            ->refer($id)
            ->text($this)
            ->text($text);
    }

    /**
     * Add an route link (static).
     *
     * @return Html instance
     */
    public static function urlLink($text, $url, $parameters  = [], $secure = null)
    {
        return $this->createElement('a')->text($text)
            ->href(url($route, $parameters, $secure ));
    }

    /**
     * Add an route link
     *
     * @return Html instance
     */
    public function url($text, $url, $parameters  = [], $secure = null)
    {
        return $this->add('a')->text($text)
            ->href(url($route, $parameters, $secure ));
    }

    /**
     * Shortcut to set('name', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function name($value)
    {
        return parent::attr('name', $value);
    }

    /**
     * Shortcut to set('on...', $value).
     *
     * @param string $name
     * @param string $value
     * @return Html instance
     */
    public function on($name, $value)
    {
        return parent::attr('on'.$name, $value);
    }

    /**
     * Shortcut to set('pattern', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function pattern($value)
    {
        return parent::attr('pattern', $value);
    }

    /**
     * Shortcut to set('placeholder', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function placeholder($value)
    {
        return parent::attr('placeholder', $value);
    }

    /**
     * Shortcut to set('multiple', 'multiple').
     *
     * @param string $value
     * @return Html instance
     */
    public function multiple()
    {
        return parent::attr('multiple', 'multiple');
    }

    /**
     * Remove a class from classList.
     *
     * @param string $value
     * @return Html instance
     */
    public function removeClass($value)
    {
        if (!is_null($this->attributeList['class'])) {
            unset($this->attributeList['class'][array_search($value, $this->attributeList['class'])]);
        }
        return $this;
    }

    /**
     * Shortcut to set('required', $value).
     *
     * @param boolean $required
     * @param boolean $required_value
     * @return Html instance
     */
    public function required($required = true, $required_value = true)
    {
        if ($required == $required_value) {
            return parent::attr('required', 'required');
        }
        return $this;
    }

    /**
     * Shortcut to set('rows', $value).
     *
     * @param integer $rows
     * @return Html instance
     */
    public function rows($rows)
    {
        if ($this->tag === 'textarea') {
            return parent::attr('rows', $rows);
        }
        return $this;
    }

    /**
     * Add an route link.
     *
     * @return Html instance
     */
    public function route($text, $route, $parameters = [])
    {
        return $this->add('a')->text($text)
            ->href(route($route, $parameters));
    }

    /**
     * Shortcut to set('selected', 'selected').
     *
     * @param string $value
     * @return Html instance
     */
    public function selected()
    {
        return parent::attr('selected', 'selected');
    }

    /**
     * Add an route link (static).
     *
     * @return Html instance
     */
    public static function routeLink($text, $route, $parameters = [])
    {
        return self::createElement('a')->text($text)
            ->href(route($route, $parameters));
    }

    /**
     * (Re)Define an attribute.
     *
     * @param string $name
     * @param string $value
     * @return Markup instance
     */
    public function set($name, $value)
    {
        if ($name === 'value') {
            $value = htmlspecialchars($value);
        }
        parent::set($name, $value);
        return $this;
    }

    /**
     * Set the tag name.
     *
     * @return string
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * Shortcut to set('src', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function src($value)
    {
        if ($this->tag === 'img') {
            return parent::attr('src', $value);
        }
        return $this;
    }

    /**
     * Shortcut to set('style', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function style($value)
    {
        return parent::attr('style', $value);
    }

    /**
     * Define text content.
     *
     * @param string $value
     * @return Markup instance
     */
    public function text($value)
    {
        if ($this->tag === 'textarea') {
            $value = htmlspecialchars($value);
        }
        parent::text($value);
        return $this;
    }

    /**
     * Shortcut to set('title', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function title($value)
    {
        return parent::attr('title', $value);
    }

    /**
     * Shortcut to set('type', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function type($value)
    {
        switch ($value) {
            case 'checkbox':
                $this->value(1);
                break;
        }
        return parent::attr('type', $value);
    }

    /**
     * Shortcut to set('width', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function width($value)
    {
        return parent::attr('width', $value);
    }

    /**
     * Shortcut to set('value', $value).
     *
     * @param string $value
     * @return Html instance
     */
    public function value($value = '')
    {
        return parent::attr('value', htmlspecialchars($value));
    }

    /**
     * Add a new element
     *
     * @param  string $tag
     * @param  array $arguments
     * @return Html instance
     */
    public function __call($tag, $arguments)
    {
        array_unshift($arguments, $tag);
        return call_user_func_array([$this, 'addElement'], $arguments);
    }

    /**
     * Create a new element
     *
     * @param  string $tag
     * @param  array $arguments
     * @return Html instance
     */
    public static function __callStatic($tag, $arguments)
    {
        array_unshift($arguments, $tag);
        return call_user_func_array(['self', 'createElement'], $arguments);
    }

}
