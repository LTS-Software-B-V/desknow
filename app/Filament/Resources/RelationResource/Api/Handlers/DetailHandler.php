<?php

namespace App\Filament\Resources\RelationResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\RelationResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\RelationResource\Api\Transformers\RelationTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = RelationResource::class;


    /**
     * Show Relation
     *
     * @param Request $request
     * @return RelationTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new RelationTransformer($query);
    }
}
