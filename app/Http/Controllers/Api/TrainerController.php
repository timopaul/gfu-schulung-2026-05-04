<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TrainerResource;
use App\Models\Trainer;

class TrainerController extends ApiController
{
    public function index()
    {
        $trainers = Trainer::all();

        dd($trainers);
    }

    public function get(Trainer $trainer)
    {
        return new TrainerResource($trainer);
    }
}
