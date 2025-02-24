<?php
namespace App\Filament\Resources\ObjectLocationResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\ObjectLocationResource;
use App\Filament\Resources\ObjectLocationResource\Api\Requests\UpdateObjectLocationRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = ObjectLocationResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update ObjectLocation
     *
     * @param UpdateObjectLocationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateObjectLocationRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}