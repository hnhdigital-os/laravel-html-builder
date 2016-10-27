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

    /**
     * Assert that creating an invalid tag throws an exception.
     * @expectedException Exception
     */
    public function testAddExeptionForInvalidTag()
    {
        $table = Tag::create('table1');
    }

    /**
     * Assert that adding an invalid tag to another tag throws an exception.
     * @expectedException Exception
     */
    public function testAddExeptionForIncorrectTag()
    {
        $table = Tag::table();
        $td = $table->add('td');
    }

    /**
     * Assert that adding an invalid tag to another tag throws an exception.
     * @expectedException Exception
     */
    public function testAddExeptionForIncorrectTag1()
    {
        $table = Tag::table();
        $td = $table->td();
    }

    /**
     * Assert that changing a tag on a special tag throws an exception.
     * @expectedException Exception
     */
    public function testChangeTagException()
    {
        $table = Tag::table();
        $tr = $table->tr();
        $th = $tr->setTag('th');
    }

    /**
     * Assert that we change a tag.
     */
    public function testChangeTag()
    {
        $table = Tag::table();
        $tr = $table->tr();
        $th = $tr->th();
        $this->assertEquals(trim((string)$th), "<th>\n</th>");

        $td = $th->setTag('td');
        $this->assertEquals(trim((string)$td), "<td>\n</td>");
    }

    /**
     * Assert that we can ignore a parent tag.
     */
    public function testIgnoreTags()
    {
        $table = Tag::table();
        $tr = $table->tr();
        $td = $tr->td();
        $row_html = trim($table->getHtml(['ignore_tags' => 'table']));
        $this->assertEquals($row_html, "<tr>\n  <td>\n  </td>\n</tr>");        
    }

    /**
     * Assert that we get html or json.
     */
    public function testPrepare()
    {
        $label = Tag::label();
        $this->assertEquals(trim($label->prepare()), "<label>\n</label>");

        $label = Tag::label();
        request()->ajax = true;

        $array_output = [['label', '', '', []]];
        $this->assertEquals($label->prepare(),$array_output);
    }
}
