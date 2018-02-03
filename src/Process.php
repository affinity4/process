<?php
namespace Affinity4\Process;

use React\Promise;

class Process
{
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
}