<?php

namespace Helper;

use Baka\Database\Apps;
use Baka\Http\Request\Phalcon as PhalconRequest;
use Codeception\Module;
use Codeception\TestInterface;
use Kanvas\Guild\Tests\Support\Models\Users;
use Phalcon\Di;
use Phalcon\DI\FactoryDefault as PhDI;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Mvc\Model\Metadata\Memory;

// here you can define custom actions
// all public methods declared in helper class will be available in $I
class Integration extends Module
{
    /**
     * @var null|PhDI
     */
    protected $diContainer = null;
    protected $savedModels = [];
    protected $savedRecords = [];
    protected $config = [
        'rollback' => false
    ];

    /**
     * Test initializer.
     */
    public function _before(TestInterface $test)
    {
        PhDI::reset();
        $this->diContainer = new Di();
        $this->setDi($this->diContainer);
        $this->diContainer->setShared('userData', new Users());
        $this->diContainer->setShared('userProvider', new Users());
        $this->diContainer->setShared('app', new Apps());
        $this->diContainer->setShared('request', new PhalconRequest());

        $this->savedModels = [];
        $this->savedRecords = [];
    }

    public function _after(TestInterface $test)
    {
    }

    protected function setDi()
    {
        $this->diContainer->setShared(
            'modelsManager',
            function () {
                return new ModelsManager();
            }
        );

        $this->diContainer->setShared(
            'modelsMetadata',
            function () {
                return new Memory();
            }
        );
        $providers = include __DIR__ . '/../../providers.php';
        foreach ($providers as $provider) {
            (new $provider())->register($this->diContainer);
        }
    }
}
