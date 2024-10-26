<?php
namespace App\Exceptions;

use Illuminate\Validation\ValidationException;

class CommonValidationException extends ValidationException
{
    public function response($request)
    {
        return response()->json([
            'message' => 'Validation failed. Please check your input.',
            'errors' => $this->validator->errors()
        ], 400);
    }
}



?>
