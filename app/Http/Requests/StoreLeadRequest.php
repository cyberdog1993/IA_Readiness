<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'ruc' => ['required', 'string', 'max:20'],
            'industry' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'company_size' => ['required', 'string', 'max:100'],
            'repetitive_process_count' => ['required', 'integer', 'min:0', 'max:1000'],
            'manual_hours_weekly' => ['required', 'integer', 'min:0', 'max:10000'],
            'process_documentation_level' => ['required', 'integer', 'min:0', 'max:100'],
            'digital_system_usage' => ['required', 'integer', 'min:0', 'max:100'],
            'excel_dependency' => ['required', 'integer', 'min:0', 'max:100'],
            'system_integration_level' => ['required', 'integer', 'min:0', 'max:100'],
            'manual_report_generation' => ['required', 'integer', 'min:0', 'max:100'],
            'has_kpis' => ['required', 'boolean'],
            'key_person_dependency' => ['required', 'integer', 'min:0', 'max:100'],
            'automation_interest' => ['required', 'integer', 'min:0', 'max:100'],
            'privacy_consent' => ['accepted'],
        ];
    }
}
