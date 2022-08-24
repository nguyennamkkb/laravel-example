<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnterpriseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'shortName' => $this->shortName,
            'employees' => $this->employees,
            'user_id' => $this->user_id,
            // 'created_at' => (string)$this->created_at,
            // 'updated_at' => (string)$this->updated_at,
        ];
    }
}
