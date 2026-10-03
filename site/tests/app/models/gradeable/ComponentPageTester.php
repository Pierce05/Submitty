<?php

namespace tests\app\models\gradeable;

use app\models\gradeable\Component;
use PHPUnit\Framework\TestCase;

class ComponentPageTester extends TestCase {
    public function testValidPages(): void {
        $cases = [
            [-1, '-1'],
            [0, '0'],
            [5, '5'],
            [-7, '-1'],
            ['-1', '-1'],
            ['0', '0'],
            ['3', '3'],
            ['3-3', '3-3'],
            ['3-5', '3-5'],
            ['3,5', '3,5'],
            ['3-4,10', '3-4,10'],
            [' 3-4 , 10 ', '3-4,10'],
        ];
        foreach ($cases as [$input, $expected]) {
            $this->assertSame($expected, Component::normalizePage($input), 'input: ' . var_export($input, true));
        }
    }

    public function testInvalidPages(): void {
        $cases = ['', 'abc', '5-3', '3-', '-3', '-2', ',3', '3,', '3,,4', '0-3', '03', '1.5', '3-4-5', null, [], 2.5];
        foreach ($cases as $input) {
            try {
                Component::normalizePage($input);
                $this->fail('expected an exception for: ' . var_export($input, true));
            }
            catch (\InvalidArgumentException $e) {
                $this->addToAssertionCount(1);
            }
        }
    }
}