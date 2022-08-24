<?php

namespace App\Http\Resources;

use App\Http\Controllers\Api\CmdController;
use Illuminate\Http\Resources\Json\JsonResource;

class ExportDetailResource extends JsonResource
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
            'categorychildren' => $this->categorychildren->name,
            'price' =>CmdController::formatNumberCur( $this->price),
            'unit' => $this->unit,
            'weight' =>CmdController::formatNumberCur( $this->weight), 
            'total' => CmdController::formatNumberCur( $this->total), 
        ];
    }
}
