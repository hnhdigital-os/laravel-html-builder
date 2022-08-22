<?php

namespace HnhDigital\LaravelHtmlBuilder;

use Illuminate\Support\Arr;
use HnhDigital\LaravelHtmlGenerator\Html;

/**
 * @method static div(...$arguments)
 * @method static label(...$arguments)
 * @method static table(...$arguments)
 * @method static tbody(...$arguments)
 * @method static td(...$arguments)
 * @method static tr(...$arguments)
 * @mixin Tag
 */
class Tag
{
    private static $tag_registry = [];
    private static $special_tags = [
        'img', 'br', 'hr', 'input', 'area', 'link', 'meta', 'param',
    ];

    protected $tag = 'tag';
    protected $text = '';
    protected $attributes = [];
    protected $parent_node;
    protected $child_nodes = [];
    protected $allowed_tags = [];
    protected $allowed_text = false;
    protected $use_whitespace = true;

    /**
     * Create a new tag object.
     *
     * @param string $tag
     * @param array  $attributes
     * @param string $text
     *
     * @return self
     */
    public static function create($tag, $attributes = [], $text = '')
    {
        return (new self())->add($tag, $attributes, $text);
    }

    /**
     * Add a child node to this tag.
     *
     * @param string $tag
     * @param array  $arguments
     *
     * @return self
     */
    public function add($tag, ...$arguments)
    {
        $tag = strtolower($tag);
        $text = '';
        $attributes = [];

        for ($i = 0; $i <= 1; $i++) {
            if (Arr::has($arguments, $i)) {
                if (is_array(Arr::get($arguments, $i))) {
                    $attributes = Arr::get($arguments, $i);
                } elseif (is_string(Arr::get($arguments, $i)) || is_object(Arr::get($arguments, $i))) {
                    $text = Arr::get($arguments, $i);
                }
            }
        }

        if ($this->tag === 'tag'
            || empty($this->allowed_tags)
            || in_array($tag, $this->allowed_tags)
            || in_array($tag, self::$special_tags)) {
            // Tag belongs to the special tags list.
            if (in_array($tag, self::$special_tags)) {
                $tag_object = Html::createElement($tag);
                $tag_object->text($text)->addAttributes($attributes);
                self::$tag_registry[] = &$tag_object;
                $this->child_nodes[] = &$tag_object;

                return $tag_object;
            }

            // Create the class name for this tag
            $class_name = 'HnhDigital\\LaravelHtmlBuilder\\Tag\\'.ucfirst($tag);

            // If the tag exists, otherwise we throw an exception.
            if (class_exists($class_name)) {
                $tag_object = (new $class_name())
                    ->setAttributes($attributes)
                    ->setText($text);
                self::$tag_registry[] = &$tag_object;
                $this->child_nodes[] = &$tag_object;
                $tag_object->setParent($tag_object);

                return $tag_object;
            }

            throw new \Exception($tag.' does not exist.');
        }

        throw new \Exception($this->tag.' does permit '.$tag);
    }

    /**
     * Get the tag parent node.
     *
     * @return self
     */
    public function getParent()
    {
        return $this->parent_node;
    }

    /**
     * Set the parent of this tag.
     *
     * @param LaravelHtmlBuilder\Tag $tag_object
     *
     * @return self
     */
    public function setParent(&$tag_object)
    {
        $this->parent_node = &$tag_object;

        return $this;
    }

    /**
     * Set the tag name.
     *
     * @return self
     */
    public function setTag($tag)
    {
        if (in_array($tag, $this->getParent()->allowed_tags)) {
            throw new \Exception(
                $tag.' can not be changed as it is not allowed under '.$this->getParent()->getTag().'.'
            );
        }

        $this->tag = $tag;

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
     * Set the text for this tag.
     *
     * @param string $value
     *
     * @return self
     */
    public function setText($value)
    {
        $this->text = $value;

        // Auto-convert into html.
        if (is_object($value) && stripos(get_class($value), 'HtmlGenerator\\Html')) {
            $this->text = (string) $value;
        }

        return $this;
    }

    /**
     * Get the text value.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set one or many attributes.
     *
     * @param array ...$attributes
     *
     * @return self
     */
    public function setAttributes()
    {
        $attributes = func_get_args();
        if (count($attributes)) {
            if (count($attributes) == 1 && is_array($attributes[0])) {
                $attributes = $attributes[0];
            }
            $this->attributes = $attributes;
        }

        return $this;
    }

    /**
     * Get the attributes for this tag.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set a single attribute for this tag.
     *
     * @param string $name
     * @param string $value
     *
     * @return self
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Get a single attribute value from this tag.
     *
     * @param string $name
     *
     * @return string
     */
    public function getAttribute($name)
    {
        return (isset($this->attributes[$name])) ? $this->attributes[$name] : null;
    }

    /**
     * Checks to see if this tag has child nodes.
     *
     * @return bool
     */
    public function hasChildNodes()
    {
        return count($this->child_nodes) > 0;
    }

    /**
     * Returns list of child nodes.
     *
     * @return array
     */
    public function getChildNodes()
    {
        return $this->child_nodes;
    }

    /**
     * Checks and defaults the options request for a build request.
     *
     * @param array &$options
     *
     * @return void
     */
    private static function checkBuildOptions(&$options)
    {
        if (isset($options['ignore_tags']) && ! is_array($options['ignore_tags'])) {
            $options['ignore_tags'] = [$options['ignore_tags']];
        }
    }

    /**
     * Build html from this object.
     *
     * @param string                 &$html
     * @param LaravelHtmlBuilder\Tag $tag_object
     * @param array                  $options
     * @param int                    $tab
     *
     * @return void
     */
    private static function buildHtml(&$html, $tag_object, $options, $tab = 0)
    {
        self::checkBuildOptions($options);

        $tag_is_special = in_array($tag_object->getTag(), self::$special_tags);
        $tag_is_ignored = in_array($tag_object->getTag(), Arr::get($options, 'ignore_tags', []));

        $ignore_tag = true;
        if (! isset($options['ignore_tags']) || ! $tag_is_ignored) {
            $ignore_tag = false;
        } elseif (isset($options['ignore_tags']) && $tag_is_ignored) {
            $tab--;
        }

        $pad = '';
        if ($tab > 0) {
            $pad = str_pad($pad, $tab * 2, ' ', STR_PAD_LEFT);
        }

        if (! $ignore_tag) {
            if ($tag_is_special) {
                $html .= $pad.trim((string) $tag_object)."\n";
            } elseif (! $tag_is_special) {
                $html .= $pad;
                $html .= '<'.$tag_object->tag.''.self::buildHtmlAttribute($tag_object->getAttributes()).'>';
                $html .= ($tag_object->use_whitespace) ? "\n" : '';
                if (strlen($tag_object->getText())) {
                    $html .= ($tag_object->use_whitespace) ? $pad.'  ' : '';
                    $html .= $tag_object->getText();
                }
                $html .= ($tag_object->use_whitespace && strlen($tag_object->getText())) ? "\n" : '';
            }
        }

        if (! $tag_is_special && $tag_object->hasChildNodes()) {
            foreach ($tag_object->getChildNodes() as $child_tag_object) {
                self::buildHtml($html, $child_tag_object, $options, $tab + 1);
            }
        }

        $pad = '';
        if ($tab > 0) {
            $pad = str_pad($pad, $tab * 2, ' ', STR_PAD_LEFT);
        }

        if (! $ignore_tag && ! $tag_is_special) {
            $html .= ($tag_object->use_whitespace) ? $pad : '';
            $html .= '</'.$tag_object->tag.'>'."\n";
        }
    }

    /**
     * Build html attributes from array.
     *
     * @param array $attributes
     *
     * @return string
     */
    private static function buildHtmlAttribute($attributes)
    {
        $html = '';
        foreach ($attributes as $name => $value) {
            if (is_array($value)) {
                $value = implode(' ', $value);
            }
            $html .= ' '.$name.'="'.$value.'"';
            $class_list = explode(' ', $value);
            foreach ($class_list as $class_name) {
                switch ($class_name) {
                    case 'class':
                        if (function_exists('hookAddClassHtmlTag')) {
                            hookAddClassHtmlTag($class_name);
                        }
                }
            }
        }

        return $html;
    }

    /**
     * Build an array from this object.
     *
     * @param array                  &$array
     * @param LaravelHtmlBuilder\Tag $tag_object
     * @param array                  $options
     *
     * @return void
     */
    private static function buildArray(&$array, $tag_object, $options = [])
    {
        self::checkBuildOptions($options);

        if (in_array($tag_object->getTag(), self::$special_tags)) {
            $array[] = [trim((string) $tag_object)];
        } elseif (! isset($options['ignore_tags']) || ! in_array($tag_object->getTag(), $options['ignore_tags'])) {
            $array[] = [
                $tag_object->getTag(),
                self::buildHtmlAttribute($tag_object->getAttributes()),
                $tag_object->getText(),
                [],
            ];
        }

        if ($tag_object->hasChildNodes()) {
            if (isset($options['ignore_tags']) && in_array($tag_object->getTag(), $options['ignore_tags'])) {
                foreach ($tag_object->getChildNodes() as $child_tag_object) {
                    self::buildArray($array, $child_tag_object);
                }

                return;
            }

            foreach ($tag_object->getChildNodes() as $child_tag_object) {
                $current_position = count($array) - 1;
                if (isset($array[$current_position][3]) && ! is_null($array[$current_position][3])) {
                    self::buildArray($array[count($array) - 1][3], $child_tag_object);
                }
            }
        }
    }

    /**
     * Build html from an array.
     *
     * @param string &$html
     * @param array  $array
     * @param int    $tab
     *
     * @return void
     */
    public static function buildFromArray(&$html, $array, $tab = 0)
    {
        $pad = '';
        if ($tab > 0) {
            $pad = str_pad($pad, $tab * 2, ' ', STR_PAD_LEFT);
        }

        if (! isset($array[1])) {
            $html .= $array[0]."\n";

            return;
        }

        if (! empty($array[0])) {
            $html .= $pad;
            $html .= '<'.$array[0].$array[1].'>';
            $html .= "\n";
        }

        if (! empty($array[2])) {
            $html .= $pad.'  ';
            $html .= $array[2];
            $html .= "\n";
        }

        if (isset($array[3]) && is_array($array[3])) {
            foreach ($array[3] as $child_array) {
                self::buildFromArray($html, $child_array, $tab + 1);
            }
        }

        if (! empty($array[0])) {
            $html .= $pad;
            $html .= '</'.$array[0].'>';
            $html .= "\n";
        }
    }

    /**
     * Automatically returns the object based on the http request.
     *
     * @return html|array
     */
    public function prepare($options = [])
    {
        if (request()->ajax()) {
            return $this->getArray($options);
        }

        return $this->getHtml($options);
    }

    /**
     * Get html from this object.
     *
     * @param array $options
     *
     * @return string
     */
    public function getHtml($options = [])
    {
        $html = '';
        self::buildHtml($html, $this, $options, 0);

        return $html;
    }

    /**
     * Get array from this object.
     *
     * @param array $options
     *
     * @return string
     */
    public function getArray($options = [])
    {
        $array = [];
        self::buildArray($array, $this, $options);

        return $array;
    }

    /**
     * Get json from this object (via $this->getArray).
     *
     * @param array $options
     *
     * @return string
     */
    public function getJson($options = [])
    {
        return json_encode($this->getArray($options));
    }

    /**
     * Get Html from an array (that was originally generated from $this->getArray).
     *
     * @param array $array
     *
     * @return html
     */
    public static function getHtmlFromArray($array)
    {
        $html = '';
        foreach ($array as $child_array) {
            self::buildFromArray($html, $child_array);
        }

        return $html;
    }

    /**
     * This object will turn into html.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getHtml();
    }

    /**
     * Create a html tab object.
     *
     * @param string $tag
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($tag, $arguments)
    {
        if (empty($this->allowed_tags) || in_array($tag, $this->allowed_tags) || in_array($tag, self::$special_tags)) {
            array_unshift($arguments, $tag);

            return $this->add(...$arguments);
        }

        throw new \Exception($this->tag.' does permit '.$tag);
    }

    /**
     * Create a html tab object.
     *
     * @param string $tag
     * @param array  $arguments
     *
     * @return self $tag_object
     */
    public static function __callStatic($tag, $arguments)
    {
        array_unshift($arguments, $tag);

        return call_user_func_array(['self', 'create'], $arguments);
    }
}
