<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order.billing_name'         => 'required|string|max:100',
            'order.delivery_address'     => 'required|string|max:100',
            'ordered_items' => 'required|array',
            'order_items.*.item_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('items', 'id')->where('deleted_at', null),
            ],
        ];

    }
}
