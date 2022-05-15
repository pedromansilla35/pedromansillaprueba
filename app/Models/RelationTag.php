<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationTag extends Model
{
    use HasFactory;
    protected $fillable = array('id_post', 'id_tag','id_video');
    protected $table = 'relation_tag';
}
