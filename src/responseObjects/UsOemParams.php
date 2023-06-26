<?php

namespace AmotiveTech\UnifiedSearch\responseObjects;

class UsOemParams extends Base
{
    /**
     * @var string
     */
    public $catalog;

    /**
     * @var string
     */
    public $vehicleId;

    /**
     * @var string
     */
    public $ssd;

    protected function getFields()
    {
        return [
            'catalog' => 'string',
            'vehicleId' => 'string',
            'ssd' => 'string',
        ];
    }
}