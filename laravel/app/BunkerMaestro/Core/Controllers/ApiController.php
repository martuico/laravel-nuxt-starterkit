<?php

namespace App\BunkerMaestro\Core\Controllers;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

abstract class ApiController extends Controller
{
    use Helpers;

    abstract protected function getResourceType(): string;

    protected function item(Model $model, TransformerAbstract $transformer, array $parameters = [])
    {
        return $this->response->item(
            $model,
            $transformer,
            array_merge_recursive(['key' => $this->getResourceType()], $parameters)
        );
    }
}
