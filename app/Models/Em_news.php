<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Em_news extends Model
{
    use HasFactory;
	public $timestamps = true;

	protected $table = 'em_news';

	protected $fillable = [
	'news_title',
	'news_details',
	'news_writer',
	'news_date',
	'news_type',
	'status',
	];
}