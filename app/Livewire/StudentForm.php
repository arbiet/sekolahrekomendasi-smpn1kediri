<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentAddress;
use App\Models\StudentSchoolChoice;
use App\Models\StudentGraduatedSchool;

class StudentForm extends Component
{
    public $step = 1;
    public $user_id;
    public $name;
    public $email;
    public $gender;
    public $batch_year;
    public $class;
    public $place_of_birth;
    public $date_of_birth;
    public $nisn;
    public $phone_number;
    public $status;
    public $address = [
        'street' => '',
        'subdistrict' => '',
        'district' => '',
        'city' => '',
        'province' => '',
        'postal_code' => '',
    ];
    public $school_choice = [
        'first_choice' => '',
        'second_choice' => '',
        'third_choice' => '',
    ];
    public $graduated_school = [
        'selected_school' => '',
        'accepted_school' => '',
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'gender' => 'required|string|max:255',
        'batch_year' => 'required|integer',
        'class' => 'required|string|max:255',
        'place_of_birth' => 'required|string|max:255',
        'date_of_birth' => 'required|date',
        'nisn' => 'required|string|max:255',
        'phone_number' => 'required|string|max:255',
        'status' => 'required|in:active,graduated',
        'address.street' => 'required|string|max:255',
        'address.subdistrict' => 'required|string|max:255',
        'address.district' => 'required|string|max:255',
        'address.city' => 'required|string|max:255',
        'address.province' => 'required|string|max:255',
        'address.postal_code' => 'required|string|max:255',
        'school_choice.first_choice' => 'required_if:status,active|string|max:255',
        'school_choice.second_choice' => 'nullable|string|max:255',
        'school_choice.third_choice' => 'nullable|string|max:255',
        'graduated_school.selected_school' => 'required_if:status,graduated|string|max:255',
        'graduated_school.accepted_school' => 'nullable|string|max:255',
    ];

    public function render()
    {
        return view('livewire.student-form');
    }

    public function submit()
    {
        $this->validate();

        if ($this->step === 1) {
            // Create or update the user
            $user = User::updateOrCreate(
                ['email' => $this->email],
                ['name' => $this->name, 'password' => bcrypt('password')]
            );

            $this->user_id = $user->id;
            $this->step = 2;
        } elseif ($this->step === 2) {
            // Save student data
            $student = Student::create([
                'user_id' => $this->user_id,
                'name' => $this->name,
                'gender' => $this->gender,
                'batch_year' => $this->batch_year,
                'class' => $this->class,
                'place_of_birth' => $this->place_of_birth,
                'date_of_birth' => $this->date_of_birth,
                'nisn' => $this->nisn,
                'phone_number' => $this->phone_number,
                'email' => $this->email,
                'status' => $this->status,
            ]);

            StudentAddress::create([
                'student_id' => $student->id,
                'street' => $this->address['street'],
                'subdistrict' => $this->address['subdistrict'],
                'district' => $this->address['district'],
                'city' => $this->address['city'],
                'province' => $this->address['province'],
                'postal_code' => $this->address['postal_code'],
            ]);

            if ($this->status == 'graduated') {
                StudentGraduatedSchool::create([
                    'student_id' => $student->id,
                    'selected_school' => $this->graduated_school['selected_school'],
                    'accepted_school' => $this->graduated_school['accepted_school'],
                ]);
            } else {
                StudentSchoolChoice::create([
                    'student_id' => $student->id,
                    'first_choice' => $this->school_choice['first_choice'],
                    'second_choice' => $this->school_choice['second_choice'],
                    'third_choice' => $this->school_choice['third_choice'],
                ]);
            }

            // Reset form for new entry
            $this->reset();
            $this->step = 1;
        }
    }

    public function back()
    {
        $this->step--;
    }
}
