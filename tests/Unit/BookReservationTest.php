<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use App\Models\Reservation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function a_book_can_be_checked_out()
	{
		$this->withoutExceptionHandling();

		$book = factory(Book::class)->create();
		$user = factory(User::class)->create();
		$book->checkout($user);

		$this->assertCount(1, Reservation::all());
		$reservation = Reservation::first();
		$this->assertEquals($user->id, $reservation->user_id);
		$this->assertEquals($book->id, $reservation->book_id);
		$this->assertEquals(now(), $reservation->checked_out_at);
		$this->assertNull($reservation->checked_in_at);

	}




	/** @test */
	public function a_book_can_be_checked_in()
	{
		//$this->withoutExceptionHandling();

		$book = factory(Book::class)->create();
		$user = factory(User::class)->create();

		$book->checkout($user);
		$this->assertCount(1, Reservation::all());


		$book->checkin($user);


		$this->assertCount(1, Reservation::all());
		$reservation = Reservation::first()->fresh();

		$this->assertEquals($user->id, $reservation->user_id);
		$this->assertEquals($book->id, $reservation->book_id);
		$this->assertNotNull($reservation->checked_in_at);
		$this->assertEquals(now(), $reservation->checked_in_at);
	}


	/** @test */
	public function if_not_check_out_exception_is_thrown(){
		$this->expectException(\Exception::class);

		$book = factory(Book::class)->create();
		$user = factory(User::class)->create();

		$book->checkin($user);
	}

	/** @test */
	public function a_user_can_checked_out_a_book_twice()
	{
		$book = factory(Book::class)->create();
		$user = factory(User::class)->create();

		$book->checkout($user);
		$this->assertCount(1, Reservation::all());


		$book->checkin($user);
		$book->checkout($user);

		$this->assertCount(2, Reservation::all());
		//$reservation = Reservation::first()->fresh();

	}

}


