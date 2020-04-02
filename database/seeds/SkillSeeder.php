<?php

use Illuminate\Database\Seeder;
use App\Skill;
class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = Skill::create(['name' => 'Php']);
        $settings = Skill::create(['name' => 'Laravel']);
        $settings = Skill::create(['name' => 'CI']);
        $settings = Skill::create(['name' => 'Developer']);
        $settings = Skill::create(['name' => 'Designer']);
        $settings = Skill::create(['name' => 'HTML']);
        $settings = Skill::create(['name' => 'CSS']);
        $settings = Skill::create(['name' => 'Javascript']);
        $settings = Skill::create(['name' => 'PSD']);
        $settings = Skill::create(['name' => 'Logo Maker']);
    }
}
