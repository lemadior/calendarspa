<?php

namespace App\Services\Api\V1\Calendar;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Calendar\Status;
use App\Models\Calendar\Type;


class DataService
{
    public function getTypes(int $typeId = null): Type|Collection
    {
        return $typeId
            ? Type::select(['id', 'name'])->where('id', $typeId)->get()
            : Type::All(['id', 'name']);
    }

    public function getStatuses(int $statusId = null): Status|Collection
    {
        return $statusId
            ? Status::select(['id', 'name'])->where('id', $statusId)->get()
            : Status::All(['id', 'name']);
    }
}
