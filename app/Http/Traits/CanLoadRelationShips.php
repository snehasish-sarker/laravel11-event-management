<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait CanLoadRelationShips
{
    public function loadRelationships(
        Model|EloquentBuilder|QueryBuilder|HasMany $for,
        ?array $relations = null) : Model|EloquentBuilder|QueryBuilder|HasMany
    {
        $relations = $relations ?? $this->relations ?? [];
        foreach($relations as $relation){
            $for->when(
                $this->shouldIncludeRelation($relation),
                fn($q)=> $for instanceof model ? $for->load($relation) : $q->with($relation)
            );
        }

        return $for;
    }

    private function shouldIncludeRelation(String $relation)
    {
        $include = request()->query('include');

        if(!$include){
            return false;
        }

        $relations = array_map('trim', explode(',', $include));

        return in_array($relation, $relations);
    }

}
