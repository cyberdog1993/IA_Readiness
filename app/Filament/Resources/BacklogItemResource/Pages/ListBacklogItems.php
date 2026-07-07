<?php

namespace App\Filament\Resources\BacklogItemResource\Pages;

use App\Filament\Resources\BacklogItemResource;
use Filament\Resources\Pages\ListRecords;

class ListBacklogItems extends ListRecords
{
    protected static string $resource = BacklogItemResource::class;
}

