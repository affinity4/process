<?php
namespace Affinity4\Process\Test;

use PHPUnit\Framework\TestCase;
use Affinity4\Process\Process;

class ProcessTest extends TestCase
{
    private $actual;

    public function testRun()
    {
        $expected = 'React\Promise\PromiseInterface';
        $actual = Process::execute('dir .');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testRunThenSucceeds()
    {
        $expected = 'Success';
        Process::execute('dir .')->then(
            function ($output) {
                $this->actual = 'Success';
            },
            function ($output) {
                $this->actual = 'Failure';
            }
        );

        $this->assertEquals($expected, $this->actual);
    }
}
