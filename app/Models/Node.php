<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    public $timestamps = false;

    protected $fillable = ['hostname', 'accesskey'];
}