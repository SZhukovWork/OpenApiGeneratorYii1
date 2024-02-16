<?php
namespace szhukovwork\OpenApiGenerator\Scraper\SecurityScheme;

class OpenIdConnectSecurityScheme extends \szhukovwork\OpenApiGenerator\InitableObject
{
    /**
     * @var string ID of security scheme
     */
    public $id;

    /**
     * @var string URL of the discovery endpoint
     */
    public $openIdConnectUrl;
}
