<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    protected $table = 'productos';
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function pedidos(): BelongsToMany
    {
        return $this->belongsToMany(Pedido::class, 'detalle_pedidos')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal')
                    ->withTimestamps();
    }
}
