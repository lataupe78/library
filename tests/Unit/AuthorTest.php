<?php

namespace Tests\Unit;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
	use RefreshDatabase;

    /** @test
    public function first_name_and_last_name_are_required()
    {
        Author::firstOrCreate([
        	'first_name' => '',
        	'last_name' => 'Hugo'
        ]);


        Author::firstOrCreate([
        	'first_name' => 'Victor',
        	'last_name' => '',
        ]);

         $authors =  Author::all();
         dump($authors);
         $this->assertCount(0, $authors);
    }
    */

    /** @test */
    public function birth_date_is_nullable()
    {
        Author::firstOrCreate([
        	'first_name' => 'Victor',
        	'last_name' => 'Hugo'
        ]);

         $this->assertCount(1, Author::all());
    }
}
