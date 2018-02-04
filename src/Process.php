<?php
namespace Affinity4\Process;

use React\Promise;
use Symfony\Component\Process as SymfonyProcess;

/**
 * --------------------------------------------------
 * Class Process
 * --------------------------------------------------
 *
 * @author Luke Watts <luke@affinity4.ie>
 *
 * @since 0.1.0
 *
 * @package Affinity4\Process
 */
class Process implements Promise\PromiseInterface
{
    /**
     * --------------------------------------------------
     * Execute
     * --------------------------------------------------
     *
     * @deprecated Deprecated in favour of Process:run
     *
     * Runs command using Symfony/Process but return a
     * React/Promise
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.1.0
     *
     * @param        $process
     * @param string $input
     * @param null   $dir
     *
     * @return $this|null|\React\Promise\FulfilledPromise|\React\Promise\Promise|\React\Promise\RejectedPromise|static
     */
    public static function execute($process, $input = '', $dir = null)
    {
        $spec = [
            ['pipe', 'r'],
            ['pipe', 'w'],
            ['pipe', 'w']
        ];
        $pipes = [];
        $process = proc_open($process, $spec, $pipes, $dir);

        $output = [];

        if (is_resource($process)) {
            fputs($pipes[0], $input);
            fclose($pipes[0]);

            while ($f = fgets($pipes[1])) {
                $output[] = $f;
            }
            fclose($pipes[1]);

            while ($f = fgets($pipes[2])) {
                $output[] = $f;
            }
            fclose($pipes[2]);

            proc_close($process);

            return Promise\resolve(implode('', $output));
        } else {
            return Promise\reject('Process `' . $process . '` failed.');
        }
    }

    /**
     * --------------------------------------------------
     * Run
     * --------------------------------------------------
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.2.0
     *
     * @param $cmd
     *
     * @return $this|null|\React\Promise\FulfilledPromise|\React\Promise\Promise|\React\Promise\PromiseInterface|\React\Promise\RejectedPromise|static
     */
    public static function run($cmd)
    {
        $process = new SymfonyProcess\Process($cmd);
        $process->run();

        if (!$process->isSuccessful()) {
            return Promise\reject(new SymfonyProcess\Exception\ProcessFailedException($process));
        } else {
            return Promise\resolve($process->getOutput());
        }
    }

    /**
     * --------------------------------------------------
     * Then
     * --------------------------------------------------
     *
     * Simply used for intellisense completion. Not
     * strictly necessary since run and execute return
     * both return a promise
     *
     * @param callable|null $onFulfilled
     * @param callable|null $onRejected
     * @param callable|null $onProgress
     *
     * @return void
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null)
    {
        if ($onFulfilled) {
            $onFulfilled();
        }

        if ($onRejected) {
            $onRejected();
        }

        if ($onProgress) {
            $onProgress();
        }
    }
}