<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidatureResource extends JsonResource
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
            'user_id' => $this->user->id,
            'mecano' => $this->user->mecano,
            'orientation' => $this->orientation,
            'type_piece' => $this->type_piece,
            'no_card' => $this->no_card,
            'cgrae_no' => $this->cgrae_no,
            'phone_number' => $this->phone_number,
            'lastname' => $this->user->lastname,
            'firstname' => $this->user->firstname,
            'birth_date' => dateFr($this->birth_date),
            'date_inscription' => $this->date_inscription ? dateFr($this->date_inscription) : '',
        ];
    }
}
