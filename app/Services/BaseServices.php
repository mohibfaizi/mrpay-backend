<?php

namespace App\Services;
// use Illuminate\Database\Schema\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class BaseServices
{
    /**
     * Retrieves a paginated list of results from the given query.
     *
     * @param Builder $query The query builder instance to retrieve results from.
     * @param int|null $perPage The number of results per page. If null, no pagination is applied.
     * @param string $column The column to sort the results by.
     * @param string $sort The direction of sorting, either 'asc' for ascending or 'desc' for descending.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated results.
     */
    public static function list(Builder $query, int | null $perPage = 50, string $column, string $sort)
    {
        if ($perPage > 1000) {
            $perPage = 1000;
        }
        // Get the table name from the Builder instance
        $table = $query->getModel()->getTable();

        // Check if the column exists in the table
        if (!Schema::hasColumn($table, $column)) {
            throw new \InvalidArgumentException("The column '$column' does not exist in the table '$table'.");
        }
        return $query
            ->orderBy($column, $sort)
            ->paginate($perPage);
    }
}