<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\inputDetailResource;
use App\Http\Controllers\Api\CmdController;

class InputResource extends JsonResource
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
            'date' => $this->date,
            'category' =>  $this->category->name,
            'customer' =>  $this->customer->name,
            'importer' => $this->importer->name,
            'carrier' => $this->carrier->name,
            'totalmoney' => CmdController::formatNumberCur($this->totalmoney),
            'note' => $this->note,
            'prepay' => CmdController::formatNumberCur($this->prepay),
            'status' => $this->status,
            'status_export' => $this->status_export,
            'item' =>  inputDetailResource::collection($this->inputdetail),
        ];
    }
}
