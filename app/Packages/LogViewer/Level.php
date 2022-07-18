<?php

namespace App\Packages\LogViewer;

/**
 * Class Level
 * @package Rap2hpoutre\LaravelLogViewer
 */
class Level
{
    /**
     * @var array
     */
    private $levels_classes = [
        'debug' => 'blue-500',
        'info' => 'blue-500',
        'notice' => 'blue-500',
        'warning' => 'warning-900',
        'error' => 'danger-500',
        'critical' => 'danger-500',
        'alert' => 'danger-500',
        'emergency' => 'danger-500',
        'processed' => 'blue-500',
        'failed' => 'warning-900',
    ];

    /**
     * @var array
     */
    private $levels_imgs = [
        'debug' => 'info-circle',
        'info' => 'info-circle',
        'notice' => 'info-circle',
        'warning' => 'exclamation-triangle',
        'error' => 'exclamation-triangle',
        'critical' => 'exclamation-triangle',
        'alert' => 'exclamation-triangle',
        'emergency' => 'exclamation-triangle',
        'processed' => 'info-circle',
        'failed' => 'times-circle'
    ];

    /**
     * @return array
     */
    public function all()
    {
        return array_keys($this->levels_imgs);
    }

    /**
     * @param $level
     * @return string
     */
    public function img($level)
    {
        return $this->levels_imgs[$level];
    }

    /**
     * @param $level
     * @return string
     */
    public function cssClass($level)
    {
        return $this->levels_classes[$level];
    }
}
