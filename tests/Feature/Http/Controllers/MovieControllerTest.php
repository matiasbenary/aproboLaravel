<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function test_user_can_see_list_of_movies(): void
    {
        $this->seed();
        $this->get(route('movies.index'))
            ->assertOk()
            ->assertJsonStructure([
                ['id', 'name', 'director', 'release_year']
            ]);
    }
}
