<?php

namespace Tests\Browser;

use App\Models\Post;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManagePostTest extends DuskTestCase
{
    use DatabaseTruncation;

    /** @test */
    public function user_can_create_a_post()
    {
        // User opens the Post list page
        // Enters the title and content, then submits the form
        // Expects to be redirected to the Post list page
        // Expects the created post to be visible in the post list
        // Expects the created post to be stored in the database

        $post = [
            'title' => 'My First Post',
            'content' => 'This is my first post today',
        ];

        $this->browse(function (Browser $browser) use ($post) {
            $browser->visitRoute('posts.index')
                ->clickLink('Create Post')

                ->assertRouteIs('posts.create')

                ->type('title', $post['title'])
                ->type('content', $post['content'])
                ->press('Submit')

                ->assertRouteIs('posts.index')
                
                ->assertSee($post['title'])
                ->assertSee($post['content']);
        });

        $this->assertDatabaseHas('posts', [
            'title' => $post['title'],
            'content' => $post['content'],
        ]);
    }

    /** @test */
    public function post_entry_fails_with_empty_fields()
    {
        // Submit form to create new post with empty title and content
        // Make sure we redirected back to the post form
        // Check if there is an error in the title and content field

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('posts.index')
                ->clickLink('Create Post')

                ->assertRouteIs('posts.create')

                ->type('title', '')
                ->type('content', '')
                ->press('Submit')

                ->assertRouteIs('posts.create')

                ->assertSee('The title field is required.')
                ->assertSee('The content field is required.');
        });
    }

    /** @test */
    public function user_can_browse_posts_on_the_index_page()
    {
        // Generate 3 post record by factory.
        // User open Post list page.
        // User see three post in the page.

        $posts = Post::factory()->count(3)->create();

        $this->browse(function (Browser $browser) use ($posts) {
            $browser
                ->visitRoute('posts.index')
    
                ->assertSee($posts[0]->title)
                ->assertSee($posts[0]->content)
                ->assertSee($posts[1]->title)
                ->assertSee($posts[1]->content)
                ->assertSee($posts[2]->title)
                ->assertSee($posts[2]->content);
        });
    }

    /** @test */
    public function user_can_edit_an_existing_post()
    {
        // Generate one post record by factory.
        // Visit post list page.
        // Click edit post button
        // Make sure we redirected to the edit page
        // Make sure the action of the update form pointing to the correct route (update route)
        // Make sure there is already a value in the title and content field
        // User submit edited value
        // Make sure we redirected back to the post list page
        // Make sure the data updated in the database
        
        $post = Post::factory()->create();

        $newValue = [
            'title' => 'Updated Post',
            'content' => 'Updated post content',
        ];

        $this->browse(function (Browser $browser) use($post, $newValue) {
            $browser
                ->visitRoute('posts.index')
            
                ->clickLink('Edit')

                ->assertRouteIs('posts.edit', $post->id)

                ->assertAttribute('form', 'action', route('posts.update', $post->id))

                ->assertInputValue('title', $post->title)
                ->assertInputValue('content', $post->content)

                ->type('title', $newValue['title'])
                ->type('content', $newValue['content'])
                ->press('Submit')

                ->assertRouteIs('posts.index')
                ;
        });

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $newValue['title'],
            'content' => $newValue['content'],
        ]);
    }

    /** @test */
    public function user_can_delete_an_existing_post()
    {
        // Generate one record of post.
        // User open post list page.
        // User click Delete button.
        // Make sure we redirected back to the post list page
        // Make sure the record removed from our database
        
        $post = Post::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser
                ->visitRoute('posts.index')
        
                ->click('form#delete-form > button[type=submit]')
        
                ->assertRouteIs('posts.index');
        });

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
