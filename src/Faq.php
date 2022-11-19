<?php

namespace Elementcore\Faq;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = "faq";
    protected $primaryKey = 'Faq_ID';

    protected $fillable = [
        'FAQ_Question',
        'FAQ_Answer'
    ];
}
