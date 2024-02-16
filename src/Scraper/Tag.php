<?php
namespace szhukovwork\OpenApiGenerator\Scraper;

use szhukovwork\OpenApiGenerator\InitableObject;

class Tag extends InitableObject
{
    /**
     * @var string Name of tag
     */
    public $name;

    /**
     * @var string|null Description of tag
     */
    public $description;

    /**
     * @var string|null URL to external page
     */
    public $externalDocs;
}
