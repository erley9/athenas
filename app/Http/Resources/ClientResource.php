<?php

namespace App\Http\Resources;

use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'category' => $this->category,
            'classification' => $this->getClassification($this->category)
        ];
    }

    public function getClassification($category)
    {
        return $classification = match($category) {
            1 => 'Ouro',
            2 => 'Ouro',
            default => 'Prata'
        };
    }
}
