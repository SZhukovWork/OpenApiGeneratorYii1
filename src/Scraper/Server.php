<?php
namespace szhukovwork\OpenApiGenerator\Scraper;

use szhukovwork\OpenApiGenerator\InitableObject;

class Server extends InitableObject
{
    /**
     * @var string URL of server
     */
    public $url;

    /**
     * @var string|null Description of server
     */
    public $description;
}
