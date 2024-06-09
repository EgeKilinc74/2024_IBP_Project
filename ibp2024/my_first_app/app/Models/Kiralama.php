<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kiralama extends Model
{
    protected $table = 'kiralamalar';
    protected $fillable = ['user_id', 'kitap_id'];


// Kiralama modelinde
public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // user_id sütununu belirtin
}

public function kitap()
{
    return $this->belongsTo(Kitap::class, 'kitap_id'); // kitap_id sütununu belirtin
}

}
