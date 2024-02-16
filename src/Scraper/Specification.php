<?php
namespace szhukovwork\OpenApiGenerator\Scraper;

use szhukovwork\OpenApiGenerator\InitableObject;
use szhukovwork\OpenApiGenerator\Scraper\SecurityScheme\ApiKeySecurityScheme;

class Specification extends InitableObject
{
    /**
     * @var string|null Specification version
     */
    public $version;

    /**
     * @var string Specification title
     */
    public $title;

    /**
     * @var string Specification description
     */
    public $description;

    /**
     * @var Tag[]
     */
    public $tags = [];

    /**
     * @var Endpoint[]
     */
    public $endpoints = [];

    /**
     * @var Server[] List of servers
     */
    public $servers = [];

    /**
     * @var ApiKeySecurityScheme[] List of security schemes
     */
    public $securitySchemes = [];

    /**
     * @var string|null URL to external page
     */
    public $externalDocs;
}
