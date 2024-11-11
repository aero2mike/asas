<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        switch ($request->input('points_type')) {
            case 'Donation Points':
                return [
                    'account_id' => ['required'],
                    'char_id' => ['required'],
                    'points_type' => ['required'],
                    'amount' => ['required', 'numeric']
                ];
            case 'Vote Points':
                return [
                    'account_id' => ['required'],
                    'points_type' => ['required'],
                    'amount' => ['required', 'numeric']
                ];
        }
    }
}
