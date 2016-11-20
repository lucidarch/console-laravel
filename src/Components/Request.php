<?php


namespace Lucid\Console\Components;


/**
 * Class Request
 *
 * @author Bernat Jufré <info@behind.design>
 *
 * @package Lucid\Console\Components
 */
class Request extends Component
{
    public function __construct($title, $service, $namespace, $file, $path, $relativePath, $content)
    {
        $this->setAttributes([
            'request' => $title,
            'service' => $service,
            'namespace' => $namespace,
            'file' => $file,
            'path' => $path,
            'relativePath' => $relativePath,
            'content' => $content,
        ]);
    }
}