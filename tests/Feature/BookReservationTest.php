<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'A song of ice and fire',
            'author' => 'George R.R.Martin'
        ]);

        $this->assertCount(1, Book::all());
        //$response->assertStatus(200);
    }


    /** @test */
    public function title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'George R.R.Martin'
        ]);

        $response->assertSessionHasErrors('title');
    }


    /** @test */
    public function author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'A song of ice and fire',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }


    /** @test */
    public function book_can_be_updated()
    {
        $this->post('/books', [
            'title' => 'A song of ice and fire',
            'author' => 'George R.R.Martin'
        ]);
        $book = Book::first();

        $response = $this->patch('/books/'.$book->id, [
            'title' => 'title updated',
            'author' => 'George R.R.Martin'
        ]);

        $this->assertEquals('title updated', $book->fresh()->title);
        $response->assertRedirect($book->fresh()->path());
    }


    /** @test */
    public function book_can_be_deleted()
    {
        $this->post('/books', [
            'title' => 'A song of ice and fire',
            'author' => 'George R.R.Martin'
        ]);
        $this->assertCount(1, Book::all());

        $book = Book::first();
        $response = $this->delete('/books/'.$book->id);
        $this->assertCount(0, Book::all());
    }
}
