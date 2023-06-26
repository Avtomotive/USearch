<?php

namespace AmotiveTech\UnifiedSearch\responseObjects;

class UsBrandOem extends Base
{
    /**
     * @var string
     */
    public $detailId;

    /**
     * @var string
     */
    public $brand;

    /**
     * @var string
     */
    public $oem;

    protected function getFields()
    {
        return [
            'detailId' => 'string',
            'brand' => 'string',
            'oem' => 'string',
        ];
    }
}