<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition()
    {
        return [
            'program' => $this->faker->randomElement(['HSC', 'Degree', 'Honours']),
            'group' => $this->faker->word,
            'session' => $this->faker->year,
            'sNameBangla' => 'টেস্ট স্টুডেন্ট',
            'sNameEnglish' => $this->faker->name,
            'sMobileNo' => '01' . $this->faker->numerify('#########'),
            'pinCode' => strtoupper(Str::random(8)),
            'status' => 0,
        ];
    }
}
