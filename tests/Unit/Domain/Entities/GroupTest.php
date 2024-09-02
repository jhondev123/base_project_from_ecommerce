<?php

namespace Jhonattan\BaseProjectFromEcommerce\Tests\Unit\Domain\Entities;

use PHPUnit\Framework\TestCase;
use Jhonattan\BaseProjectFromEcommerce\Domain\Entities\Group;

class GroupTest extends TestCase
{
    public function testInstanceGroup()
    {
        $group = new Group('1', 'acais');
        $this->assertEquals('acais', $group->getName());
    }
}
