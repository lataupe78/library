<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Reservation;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BookCheckoutTest extends TestCase
{

	use RefreshDatabase;

	/** @test */
	public function a_book_can_be_checked_out_by_a_signed_user()
	{
		$this->withoutExceptionHandling();


		$book = factory(Book::class)->create();
		$user = factory(User::class)->create();
		$this->actingAs($user)
		->post('/checkout/'. $book->id);


		$this->assertCount(1, Reservation::all());
		$reservation = Reservation::first();
		$this->assertEquals($user->id, $reservation->user_id);
		$this->assertEquals($book->id, $reservation->book_id);
		$this->assertEquals(now(), $reservation->checked_out_at);
		$this->assertNull($reservation->checked_in_at);

	}

	/** @test */
	public function only_signed_user_can_checkout_a_book()
	{
        //$this->withoutExceptionHandling();
		$book = factory(Book::class)->create();

		$this->post('/checkout/'. $book->id)
		->assertRedirect('/login');

		$this->assertCount(0, Reservation::all());

	}

	/** @test */
	public function only_signed_user_can_checkin_a_book()
	{
        //$this->withoutExceptionHandling();
		$book = factory(Book::class)->create();

		$this->actingAs(factory(User::class)->create())
		->post('/checkout/'. $book->id);

		Auth::logout();

		$this->post('/checkin/'. $book->id)
		->assertRedirect('/login');

		$this->assertCount(1, Reservation::all());
		$reservation = Reservation::first();
		$this->assertNull($reservation->checked_in_at);

	}



	/** @test */
	public function only_real_book_can_be_checked_out()
	{

		$user = factory(User::class)->create();
		$this->actingAs($user)
		->post('/checkout/'. 123)
		->assertStatus(404);
		$this->assertCount(0, Reservation::all());

	}


	/** @test */
	public function only_real_book_can_be_checked_in()
	{

		$user = factory(User::class)->create();
		$this->actingAs($user)
		->post('/checkin/'. 123)
		->assertStatus(404);
		$this->assertCount(0, Reservation::all());

	}


	/** @test */
	public function a_book_can_be_checked_in_by_a_signed_user()
	{
		$this->withoutExceptionHandling();
		$book = factory(Book::class)->create();
		$user = factory(User::class)->create();

		$this->actingAs($user)
		->post('/checkout/'. $book->id);

		$this->actingAs($user)
		->post('/checkin/'. $book->id);



		$this->assertCount(1, Reservation::all());
		$reservation = Reservation::first();
		$this->assertEquals($user->id, $reservation->user_id);
		$this->assertEquals($book->id, $reservation->book_id);
		$this->assertEquals(now(), $reservation->checked_in_at);

	}

	/** @test */
	public function an_404_is_thrown_if_a_book_is_not_checked_out_first()
	{
		//$this->withoutExceptionHandling();
		$book = factory(Book::class)->create();
		$user = factory(User::class)->create();

		$this->actingAs($user)
		->post('/checkin/'. $book->id)
		->assertStatus(404);

		$this->assertCount(0, Reservation::all());


	}
}
