<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);
       return [
           'id'=>$this->id,
           'p_name'=>$this->p_name,
           'description'=>$this->description,
           'num_bids'=>$this->num_bids,
           'deposite' =>$this->deposite     ,
           'old_price'   =>$this->old_price    ,
           'new_price'   =>$this->new_price    ,
          'start_date'  =>$this->start_date   ,
          'end_date'    =>$this->end_date    ,
           'location'    =>$this->location     ,
           'created_at'  =>$this-> created_at ,
           'updated_at'  =>$this->updated_at  ,

       ];
    }
}
