<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealImage extends Model
{
  protected $fillable = ['deal_id', 'path', 'is_primary'];

 public function deal()
  {
    return $this->belongsTo(Deal::class);
  }
}
