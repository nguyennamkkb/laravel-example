<?php

namespace App\Http\Resources;
use App\Http\Controllers\Api\CmdController;
use Illuminate\Http\Resources\Json\JsonResource;

class ExportResource extends JsonResource
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
            'freight' =>CmdController::formatNumberCur($this->freight),
            'totalmoney' => CmdController::formatNumberCur($this->totalmoney),
            'note' => $this->note,
            'prepay' => CmdController::formatNumberCur($this->prepay),
            'status' => $this->status,
            'item' =>  inputDetailResource::collection($this->exportdetail),
        ];
    }
}
