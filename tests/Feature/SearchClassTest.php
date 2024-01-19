<?php

namespace Dlogon\QuickCrudForLaravel\Tests\Feature;

use Dlogon\QuickCrudForLaravel\Helpers\Search;
use Dlogon\QuickCrudForLaravel\Models\Blog;
use Dlogon\QuickCrudForLaravel\Tests\TestCase;

class SearchClassTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

    }

    public function test_that_search_find_model_by_like(): void
    {
        //given the search class and the query params

        $queryParams = [
            'name' => \json_encode([
                'type' => 'text',
                'value' => 'dlogon',
            ]),
        ];

        //when search a model with type text and name dlogon

        $models = Search::searchByQueryParamsWithArray((new Blog)::query(), $queryParams);
        //then assert that you find a query with a model with id 11 and content Hello from quick-crud
        //dd(Blog::all()->toArray());
        $blog = $models->first();
        $this->assertSame(11, $blog->id);
        $this->assertSame('Hello from quick-crud', $blog->content);
    }
}
