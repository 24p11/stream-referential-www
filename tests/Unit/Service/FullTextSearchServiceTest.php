<?php

namespace Tests\Service;

use App\Service\FullTextSearchService;
use PHPUnit\Framework\TestCase;

class FullTextSearchServiceTest extends TestCase
{
    private $fullTextSearchService;

    public function testSingle()
    {
        // Given
        $search = 'Tést';

        // When
        $expected = $this->fullTextSearchService->prepareSearchingWords($search);

        // Then
        self::assertEquals('+test* ', $expected);
    }

    public function testMultiple()
    {
        // Given
        $search = 'search Test,Other, Term';

        // When
        $expected = $this->fullTextSearchService->prepareSearchingWords($search);

        // Then
        self::assertEquals('+search*  +test*  +other*  +term* ', $expected);
    }

    public function testSpecialCharacter()
    {
        // Given
        $search = 'search Test+-~';

        // When
        $expected = $this->fullTextSearchService->prepareSearchingWords($search);

        // Then
        self::assertEquals('+search*  +"test+-~" ', $expected);
    }

    public function testQuote()
    {
        // Given
        $search = "'search'";

        // When
        $expected = $this->fullTextSearchService->prepareSearchingWords($search);

        // Then
        self::assertEquals("+(\'search\'*) ", $expected);
    }

    protected function setUp(): void
    {
        $this->fullTextSearchService = new FullTextSearchService();

        parent::setUp();
    }

}
