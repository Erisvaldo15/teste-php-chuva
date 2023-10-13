<?php

namespace Chuva\Tests\Unit\WebScrapping\WebScrapping\Entity;

use Chuva\Php\WebScrapping\Library\SpoutLibrary;
use PHPUnit\Framework\TestCase;

/**
 * Tests requirements for Paper.
 */
class SpoutLibraryTest extends TestCase
{

  /**
   * Test createSpreadSheet().
   */
  public function testCreateSpeadSheet()
  {

    $data = [];

    $this->expectExceptionMessage("Data Variable Empty");

    SpoutLibrary::createSpeadSheet($data);
  }
}