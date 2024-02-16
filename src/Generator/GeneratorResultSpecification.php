<?php
namespace szhukovwork\OpenApiGenerator\Generator;

use OpenApi\Annotations\OpenApi;
use szhukovwork\OpenApiGenerator\InitableObject;

class GeneratorResultSpecification extends InitableObject
{
    /**
     * @var string Title of specification
     */
    public $title;

    /**
     * @var string ID of specification
     */
    public $id;

    /**
     * @var OpenApi
     */
    public $specification;
}
