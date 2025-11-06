<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'initial_amount',
        'current_value',
        'investment_date',
        'expected_return',
        'status',
        'description',
        'user_id'
    ];

    protected $casts = [
        'investment_date' => 'date',
        'initial_amount' => 'decimal:2',
        'current_value' => 'decimal:2',
        'expected_return' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper para calcular o retorno atual
    public function getCurrentReturnAttribute()
    {
        if ($this->initial_amount > 0) {
            return (($this->current_value - $this->initial_amount) / $this->initial_amount) * 100;
        }
        return 0;
    }

    // Helper para calcular o retorno em valor
    public function getReturnAmountAttribute()
    {
        return $this->current_value - $this->initial_amount;
    }

    // Helper para formatação do tipo
    public function getTypeFormattedAttribute()
    {
        $types = [
            'stocks' => 'Ações',
            'funds' => 'Fundos',
            'treasury' => 'Tesouro Direto',
            'fixed_income' => 'Renda Fixa',
            'crypto' => 'Criptomoedas',
            'others' => 'Outros'
        ];
        
        return $types[$this->type] ?? $this->type;
    }
}