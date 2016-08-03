<?php

namespace Neveldo\TextGenerator\Tag;

use Neveldo\TextGenerator\TextFunction\ProbabilityRandomFunction;

class ProbabilityRandomFunctionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp() {
        $this->tagReplacer = new TagReplacer();
        $this->function = new ProbabilityRandomFunction($this->tagReplacer);
    }

    public function testWithZeroArgument()
    {
        $result = $this->function->execute([]);
        $this->assertEquals('', $result);
    }

    public function testWithOneArgument()
    {
        $result = $this->function->execute(['1:test']);
        $this->assertEquals('test', $result);
    }

    public function testWithTwoArguments()
    {
        $result = $this->function->execute(['2:test1', '8:test2']);
        $this->assertContains($result, ['test1', 'test2']);
    }

    public function testWithStringThatContainsEmptyTag()
    {
        $result = $this->function->execute(['9:test1' . $this->tagReplacer->getEmptyTag(), '1:test2']);
        $this->assertEquals('test2', $result);
    }

    public function testWithWrongProbabilities()
    {
        $result = $this->function->execute(['2:test1', 'test2']);
        $this->assertContains($result, ['test1']);
    }

    public function testWithWrongProbabilities2()
    {
        $result = $this->function->execute(['test1', 'test2']);
        $this->assertEquals('', $result);
    }

    public function testWithWrongProbabilities3()
    {
        $result = $this->function->execute(['xx:test1', 'yy:test2']);
        $this->assertEquals('', $result);
    }

    public function testWithWrongProbabilities4()
    {
        $result = $this->function->execute(['-5:test1', '-8:test2']);
        $this->assertEquals('', $result);
    }
}