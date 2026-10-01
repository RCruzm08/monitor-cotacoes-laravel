<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class AlertRequest extends FormRequest
{
public function authorize(): bool
{
return auth()->check();
}
public function rules(): array
{
return [
'asset_id' => [
'required',
'integer',
'exists:assets,id',
],
'target_price' => [
'required',
'numeric',
'gt:0',
],
'condition' => [
'required',
Rule::in([
'above',
'below',
]),
],  
];
}
}