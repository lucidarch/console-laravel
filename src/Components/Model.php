<?php

namespace Lucid\Console\Components;


/**
 * Class Model
 *
 * @author Bernat Jufré <info@behind.design>
 *
 * @package Lucid\Console\Components
 */
class Model extends Component
{
    public function __construct($title, $namespace, $file, $path, $relativePath, $content)
    {
        $this->setAttributes([
            'model' => $title,
            'namespace' => $namespace,
            'file' => $file,
            'path' => $path,
            'relativePath' => $relativePath,
            'content' => $content,
        ]);
    }
}