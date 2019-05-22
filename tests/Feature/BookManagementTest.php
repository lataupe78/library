<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{

    use RefreshDatabase;


    private function data(){

        return [
            'title' => 'A song of ice and fire',
            'author_id' => [
                'first_name' => 'George R.R',
                'last_name' => 'Martin'
            ]
        ];
    }


    /** @test */
    public function a_book_can_be_added()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());

        $this->assertCount(1, Book::all());
        $this->assertCount(1, Author::all());

        $this->assertEquals('Martin', Author::first()->last_name);
        //$response->assertStatus(200);
    }


    /** @test */
    public function title_is_required()
    {
        //$this->withoutExceptionHandling();
        $response = $this->post('/books', array_merge($this->data(), [
            'title' => '']));

        $response->assertSessionHasErrors('title');
    }


    /** @test */
    public function author_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', array_merge($this->data(), [
            'author_id' => []]));
        // dump($this->app['session.store']);
        $response->assertSessionHasErrors('author_id');
    }


    /** @test */
    public function author_last_name_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', array_merge($this->data(), [
            'author_id' => ['last_name' => null ]
        ]));

        //dump($this->app['session.store']);
        //dump($this->app['session.errors']);
        $response->assertSessionHasErrors('author_id.last_name');
    }


    /** @test */
    public function book_can_be_updated()
    {
        $this->post('/books', $this->data());
        $book = Book::first();

        $response = $this->patch($book->path(),array_merge($this->data(), [
            'title' => 'title updated']));

        $this->assertEquals('title updated', $book->fresh()->title);
        $response->assertRedirect($book->fresh()->path());
    }


    /** @test */
    public function book_can_be_deleted()
    {
        $this->post('/books', $this->data());
        $this->assertCount(1, Book::all());

        $book = Book::first();
        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }


    /** @test */
    public function a_new_author_is_automatically_added(){
       $this->post('/books', $this->data());

       $book = Book::first();
       $author = Author::first();

       $this->assertCount(1, Book::all());
       $this->assertEquals($author->id, $book->author_id);
   }

}
