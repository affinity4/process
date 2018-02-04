<?php
namespace Affinity4\Process;

/**
 * --------------------------------------------------
 * Class Command
 * --------------------------------------------------
 *
 * @author Luke Watts <luke@affinity4.ie>
 *
 * @since 0.2.0
 *
 * @package Affinity4\Process
 */
class Command
{
    /**
     * --------------------------------------------------
     * Create
     * --------------------------------------------------
     *
     * Command string factory
     *
     * Usage:
     *
     * ```
     *
     * $core = new Affinity4\Process\Command::create('git init', ['-q'], ['--bare']); // git init --bare -q
     *
     * ```
     *
     * @author Luke Watts <luke@affinity4.ie>
     *
     * @since 0.2.0
     *
     * @param       $cmd
     * @param array $options
     * @param array $defaults
     *
     * @return string
     */
    public static function create($cmd, array $options = [], array $defaults = [])
    {
        $args = '';
        if (!empty($options) || !empty($defaults)) {
            $params = array_merge($defaults, $options);
            $args = sprintf(' %s', implode(' ', $params));
        }

        return $cmd . $args;
    }
}