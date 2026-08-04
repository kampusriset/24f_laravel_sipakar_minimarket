<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTraining extends Model
{
    use HasFactory;

    protected $fillable = [
        'jumlah_data_latih',
        'jumlah_data_uji',
        'tree_json',
        'accuracy',
        'precision_avg',
        'recall_avg',
        'confusion_matrix',
        'is_active',
    ];

    protected $casts = [
        'tree_json' => 'array',
        'confusion_matrix' => 'array',
        'is_active' => 'boolean',
    ];
}
