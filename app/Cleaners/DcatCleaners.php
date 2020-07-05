<?php

namespace App\Cleaners;

use Hhxsv5\LaravelS\Illuminate\Cleaners\BaseCleaner;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;

class DcatCleaners extends BaseCleaner
{
    const ADMIN_CLASS = 'Dcat\Admin\Admin';

    private $reflection;

    protected $properties = [
        'deferredScript' => [],
        'script' => [],
        'style' => [],
        'css' => [],
        'js' => [],
        'menu' => [],
        'headerJs' => [],
        'jsVariables' => [],
    ];

    public function __construct(Container $currentApp, Container $snapshotApp)
    {
        parent::__construct($currentApp, $snapshotApp);
        $this->reflection = new \ReflectionClass(self::ADMIN_CLASS);
    }

    public function clean()
    {
        foreach ($this->properties as $name => $value) {
            if (property_exists(self::ADMIN_CLASS, $name)) {
                $this->reflection->setStaticPropertyValue($name, $value);
            }
        }
        $this->currentApp->forgetInstance(self::ADMIN_CLASS);
        Facade::clearResolvedInstance(self::ADMIN_CLASS);
    }
}
