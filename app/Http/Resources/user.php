<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class user extends JsonResource
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
        'name'=>$this->name,
        'email'=>$this->email,
        'phone'=>$this->phone,
        'password'=>$this->password,
        'age'=>$this->age,
        'bank_account'=>$this->bank_account,
        'vodafone_account'=>$this->vodafone,
       ];
    }
}
