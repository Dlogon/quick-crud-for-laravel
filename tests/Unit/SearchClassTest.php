<?php

namespace Dlogon\QuickCrudForLaravel\Tests\Unit;

use Dlogon\QuickCrudForLaravel\Helpers\Search;
use Dlogon\QuickCrudForLaravel\Models\Blog;
use Dlogon\QuickCrudForLaravel\Tests\TestCase;
use Illuminate\Http\Request;

class SearchClassTest extends TestCase
{
    private $queryParams;

    protected function setUp(): void
    {
        parent::setUp();

    }

    public function test_that_request_call_has(): void
    {
        $request = $this->createMock(Request::class);

        $request->expects($this->once())->method('has');

        Search::searchByQueryParams(new Blog, $request);
    }

    public function test_that_query_calls_wheres(): void
    {
        $queryParams = [
            'name' => \json_encode([
                'type' => 'text',
                'value' => 'dlogon',
            ]),
            'content' => \json_encode([
                'type' => 'related',
                'value' => 's',
            ]),
            'created_at' => \json_encode([
                'type' => 'single-date',
                'value' => 's',
            ]),
        ];
        $query = $this->createMock((new Blog())::query()::class);
        $query->expects($this->exactly(2))->method('where');
        //$query->expects($this->once())->method("whereDate");

        Search::searchByQueryParamsWithArray($query, $queryParams);
    }
}
