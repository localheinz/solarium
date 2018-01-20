<?php

namespace Solarium\Tests\Component\Result\Suggester;

use Solarium\Component\Result\Suggester\Result;
use Solarium\QueryType\Suggester\Result\Dictionary;
use Solarium\QueryType\Suggester\Result\Term;

class ResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Result
     */
    protected $result;

    public function setUp()
    {
        $this->docs = array(
            'dictionary1' => new Dictionary(array(
                'foo' => new Term(2, array(array('term' => 'foo'), array('term' => 'foobar'))),
                'zoo' => new Term(1, array(array('term' => 'zoo keeper'))),
            )),
            'dictionary2' => new Dictionary(array(
                'free' => new Term(2, array(array('term' => 'free beer'), array('term' => 'free software'))),
            )),
        );

        $all = array(
            new Term(2, array(array('term' => 'foo'), array('term' => 'foobar'))),
            new Term(1, array(array('term' => 'zoo keeper'))),
            new Term(2, array(array('term' => 'free beer'), array('term' => 'free software'))),
        );


        $this->result = new Result($this->docs, $all);
    }

    public function testGetDictionary()
    {
         $this->assertEquals($this->docs['dictionary1'], $this->result->getDictionary('dictionary1'));
    }

    public function testIterator()
    {
        $docs = array();
        foreach ($this->result as $key => $doc) {
            $docs[$key] = $doc;
        }

        $this->assertEquals($this->docs, $docs);
    }

    public function testCount()
    {
        $this->assertEquals(count($this->docs), count($this->result));
    }
}
