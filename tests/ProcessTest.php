<?php
namespace Affinity4\Process\Test;

use PHPUnit\Framework\TestCase;
use Affinity4\Process\Process;

class ProcessTest extends TestCase
{
    private $actual;

    public function testExecute()
    {
        $expected = 'React\Promise\PromiseInterface';
        $actual = Process::execute('dir .');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testExecuteThenSucceeds()
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

    public function testRun()
    {
        $expected = 'React\Promise\PromiseInterface';
        $process = Process::run('dir .');

        $this->assertInstanceOf($expected, $process);

        $process->then(function ($onSuccess) {
            $this->actual = 'Pass';
        }, function ($onFail) {
            $this->actual = 'Fail';
        });
        $expected = 'Pass';

        $this->assertEquals($expected, $this->actual);
    }
}
