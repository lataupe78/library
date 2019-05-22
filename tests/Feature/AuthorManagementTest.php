<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function an_author_can_be_created()
	{
		$this->withoutExceptionHandling();

		$this->post('/author', [
			'name' => 'Author Name',
			'birth_date' => '28-02-1978'
		]);



		$this->assertCount(1, Author::all());
		$author= Author::first();
		$this->assertInstanceOf(Carbon::class, $author->birth_date);
		$this->assertEquals('1978/02/28', $author->birth_date->format('Y/m/d'));

	}
}
