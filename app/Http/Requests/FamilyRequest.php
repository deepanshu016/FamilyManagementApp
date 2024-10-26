<?php

namespace App\Http\Requests;

use App\Exceptions\CommonValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
class FamilyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator){
        throw new CommonValidationException($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,
     */

    public function rules(): array
    {
        $routeName = $this->route()->getName();
        switch ($routeName) {
            case 'family.head.save':
                return $this->saveFamilyHead();
            case 'family.member.save':
                return $this->saveFamilyMember();
            default:
                return [];
        }
    }

    public function saveFamilyHead(): array{
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'dob' => ['required', 'date', function ($attribute, $value, $fail) {
                $birthdate = Carbon::parse($value);
                $age = $birthdate->age;
                if ($age < 21) {
                    $fail('The birth date must indicate an age of at least 21.');
                }
            }],
            'mobile' => 'required|regex:/^[0-9]{10}$/',
            'address' => 'required|string|max:500',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => 'required|string|regex:/^[0-9]{5,6}$/',
            'marital_status' => 'required|in:married,unmarried',
            'hobbies' => 'array',
            'hobbies.*' => 'nullable|string|max:255',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
    public function saveFamilyMember(): array{
        return [
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'marital_status' => 'required|in:married,unmarried',
            'education'=> 'required',
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048'
        ];
    }
}
