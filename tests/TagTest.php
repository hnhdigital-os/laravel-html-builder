<?php

namespace Bluora\LaravelHtmlBuilder\Tests;

use Bluora\LaravelHtmlBuilder\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Assert that created object creates the correct output.
     */
    public function testCreateInput()
    {
        $input = Tag::create('input');
        $this->assertEquals(trim((string)$input), "<input/>");
        $this->assertEquals(trim($input->__toString()), "<input/>");
        $this->assertEquals(trim($input->getHtml()), "<input/>");

        $input = Tag::create('input', ['value' => 'test']);
        $this->assertEquals(trim((string)$input), "<input value=\"test\"/>");

        $input->set('value', 'test1');
        $this->assertEquals(trim((string)$input), "<input value=\"test1\"/>");

        $input = Tag::input();
        $this->assertEquals(trim((string)$input), "<input/>");
        $this->assertEquals(trim($input->__toString()), "<input/>");
        $this->assertEquals(trim($input->getHtml()), "<input/>");

        $input = Tag::input(['value' => 'test']);
        $this->assertEquals(trim((string)$input), "<input value=\"test\"/>");

        $input = Tag::input(['value' => 'test'], 'test');
        $this->assertEquals(trim((string)$input), "<input value=\"test\"/>");
    }

    /**
     * Assert that created object creates the correct output.
     */
    public function testCreateLabel()
    {
        $label = Tag::label();
        $this->assertEquals(trim((string)$label), "<label>\n</label>");
        $this->assertEquals($label->getJson(), '[["label","","",[]]]');

        $label->setAttribute('title', 'Click me');
        $this->assertEquals(trim((string)$label), "<label title=\"Click me\">\n</label>");
        $this->assertEquals($label->getJson(), '[["label"," title=\"Click me\"","",[]]]');
        $this->assertEquals($label->getAttribute('title'), 'Click me');

        $label = Tag::label();
        $label->setAttributes(['title' => 'Click me']);
        $this->assertEquals(trim((string)$label), "<label title=\"Click me\">\n</label>");
        $this->assertEquals($label->getAttributes(), ['title' => 'Click me']);

        $label->input(['value' => 'test']);
        $this->assertEquals(trim((string)$label), "<label title=\"Click me\">\n  <input value=\"test\"/>\n</label>");
        $this->assertEquals($label->getJson(), '[["label"," title=\"Click me\"","",[["<input value=\"test\"\/>\r\n\t"]]]]');
    }
}
