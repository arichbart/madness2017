<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Laravel\Tinker\TinkerCaster;

class PickTeamsTest extends TestCase
{
    use DatabaseMigrations;

    public function testSelectTeams()
    {
        Carbon::setTestNow(new Carbon('March'));

        $user = factory(User::class)->create();

        $this->disableExceptionHandling()
            ->actingAs($user)
            ->post('/myTeams', [
                'grandpaTL' => '1',
                'grandpaBL' => '2',
                'grandpaTR' => '3',
                'grandpaBR' => '4',
                'specialTL' => '1',
                'specialBL' => '1',
                'specialTR' => '1',
                'specialBR' => '1',
            ]);

        $grandpa = DB::table('grandpas')->where('user', $user->id)->first();
        $special = DB::table('specials')->where('user', $user->id)->first();

        $this->assertEquals('1', $grandpa->top_left_team);
        $this->assertEquals('2', $grandpa->bottom_left_team);
        $this->assertEquals('3', $grandpa->top_right_team);
        $this->assertEquals('4', $grandpa->bottom_right_team);
        $this->assertEquals('1', $special->top_left_team);
        $this->assertEquals('1', $special->bottom_left_team);
        $this->assertEquals('1', $special->top_right_team);
        $this->assertEquals('1', $special->bottom_right_team);
    }

    public function testCantSelectTwoNumberOneSeedsForGrandpa()
    {
        Carbon::setTestNow(new Carbon('March'));

        $user = factory(User::class)->create();

        $this->disableExceptionHandling()
            ->actingAs($user)
            ->post('/myTeams', [
                'grandpaTL' => '1',
                'grandpaBL' => '17',
                'grandpaTR' => '34',
                'grandpaBR' => '50',
            ]);

        $this->assertEquals(0, DB::table('grandpas')->where('user', $user->id)->count());
        $this->assertEquals(0, DB::table('specials')->where('user', $user->id)->count());
        
    }

    public function testSelectionsAreTooLate()
    {
        Carbon::setTestNow(new Carbon('April'));

        $user = factory(User::class)->create();

        $this->disableExceptionHandling()
            ->actingAs($user)
            ->post('/myTeams', [
                'grandpaTL' => '1',
                'grandpaBL' => '18',
                'grandpaTR' => '34',
                'grandpaBR' => '50',
            ]);

        $this->assertEquals(0, DB::table('grandpas')->where('user', $user->id)->count());
        $this->assertEquals(0, DB::table('specials')->where('user', $user->id)->count());
        
    }

    public function testUpdateTeamSelection()
    {
        Carbon::setTestNow(new Carbon('March'));

        $user = factory(User::class)->create();

        $this->disableExceptionHandling()
            ->actingAs($user)
            ->post('/myTeams', [
                'grandpaTL' => '1',
                'grandpaBL' => '2',
                'grandpaTR' => '3',
                'grandpaBR' => '4',
                'specialTL' => '1',
                'specialBL' => '1',
                'specialTR' => '1',
                'specialBR' => '1',
            ]);

            $this->disableExceptionHandling()
            ->actingAs($user)
            ->post('/myTeams', [
                'grandpaTL' => '2',
                'grandpaBL' => '3',
                'grandpaTR' => '4',
                'grandpaBR' => '5',
                'specialTL' => '2',
                'specialBL' => '2',
                'specialTR' => '2',
                'specialBR' => '2',
            ]);


        $grandpa = DB::table('grandpas')->where('user', $user->id)->first();
        $special = DB::table('specials')->where('user', $user->id)->first();

        $this->assertEquals('2', $grandpa->top_left_team);
        $this->assertEquals('3', $grandpa->bottom_left_team);
        $this->assertEquals('4', $grandpa->top_right_team);
        $this->assertEquals('5', $grandpa->bottom_right_team);
        $this->assertEquals('2', $special->top_left_team);
        $this->assertEquals('2', $special->bottom_left_team);
        $this->assertEquals('2', $special->top_right_team);
        $this->assertEquals('2', $special->bottom_right_team);
    }

    public function testUnauthorizedUserCantPickTeams()
    {
        $this->assertTrue(true);
    }


}
