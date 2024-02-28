<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepository;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MovieEloquentRepository implements MovieRepository
{
    public function all()
    {
        return Movie::all();
    }

    public function withRelations(array $relations, ?string $searchParams)
    {
        $query = Movie::with($relations);

        if (isset($searchParams)) {
            $query->where('title', 'LIKE', '%' . strtolower($searchParams) . '%');
        }

        return $query->paginate(3);
    }

    public function findOrFail(int $id)
    {
        return Movie::findOrFail($id);
    }

    public function create(array $data)
    {
        DB::transaction(function() use ($data) {
            $movie = Movie::create($data);
            $movie->genres()->attach($data['genre_id'] ?? []);
        });
    }

    public function update(int $id, array $data)
    {
        return Movie::findOrFail($id)->update($data);
    }

    public function delete(int $id)
    {
        return Movie::findOrFail($id)->delete();
    }
}
