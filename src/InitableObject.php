<?php
namespace szhukovwork\OpenApiGenerator;

class InitableObject
{
    public function __construct(array $options = [])
    {
        foreach ($options as $option_name => $option_value) {
            if (property_exists($this, $option_name)) {
                $this->{$option_name} = $option_value;
            }
        }
    }
}