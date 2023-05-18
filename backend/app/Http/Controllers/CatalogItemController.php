<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalogItem;
use App\Http\Resources\CatalogItemResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\CatalogItem;
use App\Models\CatalogItemFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\ImageFile;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class CatalogItemController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = CatalogItem::query()
            ->with('images')
            ->with('user');

        $response = [];
        if ($request->get('paginate')) {
            $itemsCollection = $query->paginate(intval($request->get('paginate')));
            $response['total_pages'] = $itemsCollection->lastPage();
        } else {
            $itemsCollection = $query->get();
        }

        $response['items'] = CatalogItemResource::collection($itemsCollection);

        return $this->respondSuccess(__('Каталог загружен'), $response);
    }

    public function get($catalogItemSlug)
    {
        try {
            $catalogItem = CatalogItem::where('slug', $catalogItemSlug)
                ->with(['user', 'images'])
                ->firstOrFail();

            return $this->respondSuccess(__('Объявление загружено'), ['item' => new CatalogItemResource($catalogItem)]);
        } catch (ModelNotFoundException $exception) {
            return $this->respondNotFound('Объявление не найдено');
        }
    }

    public function store(StoreCatalogItem $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validated = $request->validated();

            //todo refactor on validation (doesn't work...)
            if (count($validated['images']) > 10)
                throw ValidationException::withMessages(['images' => __('Превышен лимит загрузки изображений (10)')]);

            $newCatalogItem = new CatalogItem();
            $newCatalogItem->fill($validated);
            $newCatalogItem->user()->associate(Auth::user());
            $newCatalogItem->save();

            foreach ($validated['images'] as $image) {
                $newFile = new CatalogItemFile();
                $newFile->saveFile($image);
                $newFile->catalog_item()->associate($newCatalogItem);
                $newFile->save();
            }

            return $this->respondSuccess(__('Объявление добавлено'), ['item' => new CatalogItemResource($newCatalogItem)]);
        } catch (ValidationException $exception) {
            return $this->respondValidationErrors($exception);
        } catch (\Exception $exception) {
            return $this->respondError($exception->getMessage());
        }
    }
}
