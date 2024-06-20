<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentAddress;
use App\Models\StudentAchievement;
use App\Models\StudentSchoolChoice;
use App\Models\StudentGraduatedSchool;
use App\Models\StudentFinalScore;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $schools = DB::table('schools')->pluck('name')->toArray();

        $subdistricts = ['Kota', 'Pesantren', 'Mojoroto'];
        $district = 'Kediri';

        // Define latitudes and longitudes ranges for each subdistrict
        $coordinates = [
            'Kota' => ['lat' => [-7.831, -7.806], 'lng' => [111.984, 112.013]],
            'Pesantren' => ['lat' => [-7.870, -7.843], 'lng' => [111.971, 112.009]],
            'Mojoroto' => ['lat' => [-7.815, -7.790], 'lng' => [111.968, 112.000]]
        ];

        // Create 5 classes of graduated students with each class having 30-34 students for batch 2021
        for ($class = 1; $class <= 5; $class++) {
            $students = User::where('usertype', 'student')->skip(($class - 1) * 34)->take(34)->get();
            foreach ($students as $user) {
                $subdistrict = $faker->randomElement($subdistricts);
                $lat_range = $coordinates[$subdistrict]['lat'];
                $lng_range = $coordinates[$subdistrict]['lng'];

                $student = Student::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'gender' => $faker->randomElement(['male', 'female']),
                    'batch_year' => 2021,
                    'class' => "Class $class",
                    'place_of_birth' => $faker->city,
                    'date_of_birth' => $faker->date,
                    'nisn' => $faker->unique()->numberBetween(100000, 999999),
                    'phone_number' => $faker->phoneNumber,
                    'email' => $user->email,
                    'status' => 'graduated',
                ]);

                StudentAddress::create([
                    'student_id' => $student->id,
                    'street' => $faker->streetAddress,
                    'subdistrict' => $subdistrict,
                    'district' => $district,
                    'city' => 'Kediri',
                    'province' => 'Jawa Timur',
                    'postal_code' => $faker->postcode,
                    'location_type' => $faker->randomElement(['urban', 'rural']),
                    'latitude' => $faker->latitude($lat_range[0], $lat_range[1]),
                    'longitude' => $faker->longitude($lng_range[0], $lng_range[1]),
                ]);

                // Determine if the student has achievements and how many
                if ($faker->boolean(15)) { // 15% chance to have achievements
                    $achievementCount = $faker->numberBetween(1, 3);
                    for ($i = 0; $i < $achievementCount; $i++) {
                        StudentAchievement::create([
                            'student_id' => $student->id,
                            'achievement_type' => $faker->randomElement(['academic', 'non-academic']),
                            'activity_name' => $faker->sentence,
                            'level' => $faker->randomElement(['school', 'district', 'province', 'national', 'international']),
                            'achievement' => $faker->randomElement(['First Place', 'Second Place', 'Third Place', 'Other']),
                            'achievement_year' => $faker->year,
                        ]);
                    }
                }

                do {
                    $first_choice = $faker->randomElement($schools);
                    $second_choice = $faker->randomElement($schools);
                    $third_choice = $faker->randomElement($schools);
                } while ($first_choice === $second_choice || $second_choice === $third_choice || $first_choice === $third_choice);

                $selected_school = $faker->randomElement([$first_choice, $second_choice, $third_choice]);
                $accepted_school = $faker->randomElement([$selected_school, $faker->randomElement($schools)]);

                StudentSchoolChoice::updateOrCreate(
                    ['student_id' => $student->id],
                    [
                        'first_choice' => $first_choice,
                        'second_choice' => $second_choice,
                        'third_choice' => $third_choice,
                    ]
                );

                if ($student->status === 'graduated') {
                    StudentGraduatedSchool::create([
                        'student_id' => $student->id,
                        'selected_school' => $selected_school,
                        'accepted_school' => $accepted_school,
                    ]);
                }

                StudentFinalScore::create([
                    'student_id' => $student->id,
                    'mathematics' => $faker->numberBetween(76, 100),
                    'science' => $faker->numberBetween(76, 100),
                    'english' => $faker->numberBetween(76, 100),
                    'indonesian' => $faker->numberBetween(76, 100),
                    'civics' => $faker->numberBetween(76, 100),
                    'religion' => $faker->numberBetween(76, 100),
                    'physical_education' => $faker->numberBetween(76, 100),
                    'arts_and_crafts' => $faker->numberBetween(76, 100),
                    'local_content' => $faker->numberBetween(76, 100),
                ]);
            }
        }

        // Create 1 class of students for batch 2022 with 30-34 students
        $students = User::where('usertype', 'student')->skip(170)->take(34)->get();
        foreach ($students as $user) {
            $subdistrict = $faker->randomElement($subdistricts);
            $lat_range = $coordinates[$subdistrict]['lat'];
            $lng_range = $coordinates[$subdistrict]['lng'];

            $student = Student::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'gender' => $faker->randomElement(['male', 'female']),
                'batch_year' => 2022,
                'class' => "Class 1",
                'place_of_birth' => $faker->city,
                'date_of_birth' => $faker->date,
                'nisn' => $faker->unique()->numberBetween(100000, 999999),
                'phone_number' => $faker->phoneNumber,
                'email' => $user->email,
                'status' => 'active',
            ]);

            StudentAddress::create([
                'student_id' => $student->id,
                'street' => $faker->streetAddress,
                'subdistrict' => $subdistrict,
                'district' => $district,
                'city' => 'Kediri',
                'province' => 'Jawa Timur',
                'postal_code' => $faker->postcode,
                'location_type' => $faker->randomElement(['urban', 'rural']),
                'latitude' => $faker->latitude($lat_range[0], $lat_range[1]),
                'longitude' => $faker->longitude($lng_range[0], $lng_range[1]),
            ]);

            // Determine if the student has achievements and how many
            if ($faker->boolean(15)) { // 15% chance to have achievements
                $achievementCount = $faker->numberBetween(1, 3);
                for ($i = 0; $i < $achievementCount; $i++) {
                    StudentAchievement::create([
                        'student_id' => $student->id,
                        'achievement_type' => $faker->randomElement(['academic', 'non-academic']),
                        'activity_name' => $faker->sentence,
                        'level' => $faker->randomElement(['school', 'district', 'province', 'national', 'international']),
                        'achievement' => $faker->randomElement(['First Place', 'Second Place', 'Third Place', 'Other']),
                        'achievement_year' => $faker->year,
                    ]);
                }
            }

            do {
                $first_choice = $faker->randomElement($schools);
                $second_choice = $faker->randomElement($schools);
                $third_choice = $faker->randomElement($schools);
            } while ($first_choice === $second_choice || $second_choice === $third_choice || $first_choice === $third_choice);

            $selected_school = $faker->randomElement([$first_choice, $second_choice, $third_choice]);
            $accepted_school = $faker->randomElement([$selected_school, $faker->randomElement($schools)]);

            StudentSchoolChoice::updateOrCreate(
                ['student_id' => $student->id],
                [
                    'first_choice' => $first_choice,
                    'second_choice' => $second_choice,
                    'third_choice' => $third_choice,
                ]
            );

            if ($student->status === 'graduated') {
                StudentGraduatedSchool::create([
                    'student_id' => $student->id,
                    'selected_school' => $selected_school,
                    'accepted_school' => $accepted_school,
                ]);
            }

            StudentFinalScore::create([
                'student_id' => $student->id,
                'mathematics' => $faker->numberBetween(76, 100),
                'science' => $faker->numberBetween(76, 100),
                'english' => $faker->numberBetween(76, 100),
                'indonesian' => $faker->numberBetween(76, 100),
                'civics' => $faker->numberBetween(76, 100),
                'religion' => $faker->numberBetween(76, 100),
                'physical_education' => $faker->numberBetween(76, 100),
                'arts_and_crafts' => $faker->numberBetween(76, 100),
                'local_content' => $faker->numberBetween(76, 100),
            ]);
        }
    }
}
