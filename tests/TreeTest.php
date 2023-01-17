<?php
namespace User\OborotRu;

use PHPUnit\Framework\TestCase;

final class TreeTest extends TestCase
{
    private $apple;

    protected function setUp(): void
    {
        $this->apple = new Tree('apple',10);
    }

    public function testClassConstructor (){
        $this->assertFileExists('trees.json');
    }

    public function testClassMessage() {
        $this->assertIsString($this->apple->treeHarvestCount());
        $this->assertStringContainsString('Harvest', $this->apple->treeHarvestCount());
    }
}