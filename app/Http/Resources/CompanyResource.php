<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public $info;

    public function __construct($info)
    {
        parent::__construct($info);
        $this->info = $info;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "company_name"         => $this->info['company_name'],
            "company_email"        => $this->info['company_email'],
            "company_phone"        => $this->info['company_phone'],
            "company_website"      => $this->info['company_website'],
            "company_city"         => $this->info['company_city'],
            "company_state"        => $this->info['company_state'],
            "company_country_code" => $this->info['company_country_code'],
            "company_zip_code"     => $this->info['company_zip_code'],
            "company_address"      => $this->info['company_address'],
        ];
    }
}
