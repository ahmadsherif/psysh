<?php

/*
 * This file is part of Psy Shell
 *
 * (c) 2013 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Readline;

use Psy\Readline\GNUReadline;

class GNUReadlineTest extends \PHPUnit_Framework_TestCase
{
    private $historyFile;
    private $readline;

    public function setUp()
    {
        if (!function_exists('readline_list_history')) {
            $this->markTestSkipped('GNUReadline not enabled');
        }

        readline_clear_history();
        $this->historyFile = tempnam(sys_get_temp_dir().'/psysh/test/', 'history');
        $this->readline    = new GNUReadline($this->historyFile);
    }

    public function testHistory()
    {
        $this->assertEmpty($this->readline->listHistory());
        $this->readline->addHistory('foo');
        $this->assertEquals(array('foo'), $this->readline->listHistory());
        $this->readline->addHistory('bar');
        $this->assertEquals(array('foo', 'bar'), $this->readline->listHistory());
        $this->readline->addHistory('baz');
        $this->assertEquals(array('foo', 'bar', 'baz'), $this->readline->listHistory());
        $this->readline->clearHistory();
        $this->assertEmpty($this->readline->listHistory());
    }
}
