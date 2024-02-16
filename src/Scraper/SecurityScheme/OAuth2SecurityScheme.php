<?php
namespace szhukovwork\OpenApiGenerator\Scraper\SecurityScheme;

class OAuth2SecurityScheme extends \szhukovwork\OpenApiGenerator\InitableObject {
    /**
     * @var string ID of security scheme
     */
    public $id;

    /**
     * @var string Description of security scheme
     */
    public $description;

    /**
     * @var array Flows of OAuth2.0
     */
    public $flows;
}
