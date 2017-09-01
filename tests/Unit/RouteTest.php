<?php

namespace Tests\Unit;

use App\clicks;
use App\Records;
use App\tracker;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RouteTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;
    protected $userTwo;
    protected $tracker;
    protected $trackerTwo;

    function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->userTwo = factory(User::class)->create();
        $this->tracker = factory(tracker::class)->create(['c_id' => $this->user->id]);
        $this->trackerTwo = factory(tracker::class)->create(['c_id' => $this->user->id]);

        factory(Records::class)->create(['t_id' => $this->tracker->t_id, 'Time' => '2017-08-23 11:20:14']);
        factory(Records::class)->create(['t_id' => $this->tracker->t_id,'Time' => '2017-08-23 11:23:14']);
        factory(Records::class)->create(['t_id' => $this->tracker->t_id,'Time' => '2017-08-23 11:29:14']);
        factory(Records::class)->create(['t_id' => $this->trackerTwo->t_id,'Time' => '2017-08-23 11:21:14']);
        factory(clicks::class)->create(['t_id' => $this->tracker->t_id,'Time' => '2017-08-23 11:25:14']);
        factory(clicks::class)->create(['t_id' => $this->tracker->t_id,'Time' => '2017-08-23 11:29:14']);
        factory(clicks::class)->create(['t_id' => $this->trackerTwo->t_id,'Time' => '2017-08-23 11:26:14']);

    }

    /**
     * A basic test example.
     *
     * @return void
     */

    public function testTopClick(){

      $response = $this->actingAs($this->user)
            ->get('/stats/topClick');

        $response->assertStatus(200)
                ->assertJson([
                    't_id' => $this->tracker->t_id,
                    'total' => 2
                ]);

    }

    public function testTrackerGenerationPositive(){

        $response = $this->actingAs($this->user)
                    ->post('/tracker',['token' => $this->user->token]);

        $response->assertRedirect('/home');
        $this->assertEquals(3,tracker::count());

    }

    public function testTrackerGenerationNegative(){

        $response = $this->actingAs($this->user)
            ->post('/tracker',['token' => $this->userTwo->token]);

        $response->assertStatus(500);
    }


    public function testTrackerOpenPositive(){

        $initCount = Records::count();

        $this->get('/open/'.$this->tracker->t_id)
                ->assertStatus(200);

        $this->assertEquals($initCount+1,Records::count());

    }


    public function testTrackerClickPositive(){

        $initCount = clicks::count();

        $this->get('/click/'.$this->tracker->t_id)
            ->assertStatus(200);

        $this->assertEquals($initCount+1,clicks::count());

    }

//    public function testUniqueClickRate(){
//        $this->get("/stats/rate?type=1?id=$this->tracker->t_id")
//            ->assertJson(['data' => 100]);
//    }

}
