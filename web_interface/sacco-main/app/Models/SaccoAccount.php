<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaccoAccount extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'saccoaccount'; // Replace 'your_table_name' with the actual name of your database table
    protected $fillable = ['interestRate'];
}
