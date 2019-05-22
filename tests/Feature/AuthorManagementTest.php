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
			'last_name' => 'Hugo',
			'first_name' => 'Victor',
			'birth_date' => '26-02-1802',
			'death_date' => '22-05-1885'
		]);



		$this->assertCount(1, Author::all());

		$author= Author::first();

		$this->assertEquals('Victor', $author->first_name);
		$this->assertEquals('Hugo', $author->last_name);
		$this->assertInstanceOf(Carbon::class, $author->birth_date);
		$this->assertInstanceOf(Carbon::class, $author->death_date);
		$this->assertEquals('1802/02/26', $author->birth_date->format('Y/m/d'));

	}
}
