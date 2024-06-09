<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kitap extends Model
{
    use HasFactory;
    protected $table = 'kitaplar';
    protected $fillable = ['id','kitap_adi','yazar'];

    // Bir kitabın birden fazla kiralama kaydı olabilir
    public function kiralamalar()
    {
        return $this->hasMany(Kiralama::class);
    }


    public function scopeMevcut($query)
    {
        return $query->where('mevcutluk', '>', 0);
    }

    public function kiralanabilir()
    {
        return $this->mevcutluk > 0;
    }

}
