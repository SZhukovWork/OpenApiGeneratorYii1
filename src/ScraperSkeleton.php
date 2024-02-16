<?php
namespace szhukovwork\OpenApiGenerator;

use szhukovwork\OpenApiGenerator\Generator\ClassDescriber;
use szhukovwork\OpenApiGenerator\Integration\Yii1CodeScraper;
use szhukovwork\OpenApiGenerator\Scraper\PathResultWrapper;
use szhukovwork\OpenApiGenerator\Scraper\SecurityScheme\ApiKeySecurityScheme;
use szhukovwork\OpenApiGenerator\Scraper\Specification;

abstract class ScraperSkeleton extends ErrorableObject
{
    public $specificationPattern = '.+';
    public $specificationAntiPattern = false;

    public string $specificationTitle = 'API';
    public string $specificationDescription = 'API version %s';
    public string $specificationVersion = 'api';

    public array $servers = [
        'http://localhost:8080/' => 'Local server',
    ];

    public array $defaultSecurityScheme = [];
    public ?array $_securitySchemesCached = null;

    /**
     * @return ApiKeySecurityScheme[]
     */
    public function getAllSecuritySchemes(): array
    {
        return [
            'defaultAuth' => new ApiKeySecurityScheme([
                'type' => 'apiKey',
                'in'=> 'query',
                'name' => 'session_id',
                'description' => 'ID сессии',
            ]),
        ];
    }

    public function getServers()
    {
        return $this->servers;
    }

    /**
     * @param Specification $specification
     * @param string $authScheme
     * @return bool
     */
    protected function ensureSecuritySchemeAdded(Specification $specification, string $authScheme): bool
    {
        if ($this->_securitySchemesCached === null) {
            $this->_securitySchemesCached = $this->getAllSecuritySchemes();
        }

        foreach ($specification->securitySchemes as $securityScheme) {
            if ($securityScheme->id === $authScheme) {
                return true;
            }
        }

        if (isset($this->_securitySchemesCached[$authScheme])) {
            $scheme = $this->_securitySchemesCached[$authScheme];
            $scheme->id = $authScheme;
            $specification->securitySchemes[] = $scheme;
            $this->notice(
                'Added auth schema "' . $authScheme . '" to specification "' . $specification->version . '"',
                self::NOTICE_INFO
            );
            return true;
        }

        $this->notice('Auth schema ' . $authScheme . ' is not defined', self::NOTICE_ERROR);
        return false;
    }

    /**
     * Should return list of controllers
     * @return array
     */
    abstract public function scrape(string $folder): array;

    /**
     * @param string $doc
     * @param string $parameter
     * @param mixed|null $defaultValue
     * @return string|null
     */
    protected function getDocParameter(string $doc, string $parameter, ?string $defaultValue = null): ?string
    {
        if (empty($doc)) {
            return $defaultValue;
        }

        $doc = explode("\n", $doc);
        foreach ($doc as $line) {
            $line = trim($line, " *\t");
            if (strpos($line, '@'.$parameter) === 0) {
                return trim(substr($line, strlen($parameter) + 1));
            }
        }

        return $defaultValue;
    }

    /**
     * @param string $doc
     * @param string $parameter
     * @param mixed|null $defaultValue
     * @return string|null
     */
    protected function getMultiLineDocParameter(string $doc, string $parameter, ?string $defaultValue = null): ?string
    {
        if (empty($doc)) {
            return $defaultValue;
        }

        $doc = explode("\n", $doc);
        $result = null;
        foreach ($doc as $i => $line) {
            $line = trim($line, " *\t");
            if (!empty($result)) {
                if (strpos($line, '@') === 0) {
                    return $result;
                }
                $result .= $line.PHP_EOL;
            } else if (strpos($line, '@'.$parameter) === 0) {
                $result .= trim(substr($line, strlen($parameter) + 1)).PHP_EOL;
            }
        }

        return $result ?: $defaultValue;
    }

    public function getGeneratorSettings(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    public static function getAllDefaultScrapers(): array
    {
        return [
            'yii' => Yii1CodeScraper::class,
        ];
    }

    public function getArgumentExtractors(): array
    {
        return [];
    }

    public function getCommonParametersDescription(): array
    {
        return [];
    }

    public function getCustomFormats(): array
    {
        return [];
    }

    public function getClassDescribingOptions(): array
    {
        return [
            null => [
                ClassDescriber::CLASS_PUBLIC_PROPERTIES => true,
                ClassDescriber::CLASS_VIRTUAL_PROPERTIES => [
                    'property' => [
                        'enum' => true,
                        'example' => true,
                    ],
                ],
                ClassDescriber::CLASS_REDIRECTION_PROPERTY => 'schema',
            ],
        ];
    }

    protected function getDefaultResponseWrapper(): ?PathResultWrapper
    {
        return null;
    }

    public function getDefaultAlternativeResponses(): array
    {
        return [];
    }
}
