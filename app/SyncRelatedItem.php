<?php

namespace App; // <- important

class SyncRelatedItem
{
    protected $model;
    protected $schema;
    protected $collection;
    protected $relatedKeyId;
    protected $arrFn;
    protected $comparingIdOnly;

    public $items;
    public $requestItem;

    function __construct($model, $collectionName, $relatedKeyId = 'id', $arrFn = null, $comparingIdOnly = true)
    {
        $this->model = $model;
        $this->schema = call_user_func(array($model, $collectionName));
        $this->collection = $model[$collectionName];
        $this->relatedKeyId = $relatedKeyId;
        $this->arrFn = $arrFn;
        $this->comparingIdOnly = $comparingIdOnly;

        $this->onNewItem = empty($this->arrFn['new']) ? function ($item) {
            return [$this->relatedKeyId => $item];
        } : $this->arrFn['new'];
    }

    function syncItems($requestItems)
    {
        $this->requestItems = $requestItems;
        $this->items = $this->preparedSyncItem($requestItems, $this->collection);

        $schema = $this->schema;
        $onNewItem = $this->onNewItem;

        $this->items['new']->each(function ($item) use ($onNewItem, $schema) {
            $schema->create($onNewItem($item));
        });

        $this->filterCollection($this->collection, $this->relatedKeyId, $this->items['delete'])->each(function ($item) {
            $item->delete();
        });
    }

    function filterCollection($collection, $id_name, $ids)
    {
        return $collection->filter(function ($item) use ($id_name, $ids) {
            return $ids->first(function ($id) use ($item, $id_name) {
                return $id == $item[$id_name];
            });
        });
    }


    // accept array or collection of ID
    function turn_to_collection($item)
    {
        if (gettype($item) == 'array') {
            return collect($item);
        } else if (gettype($item) == 'object' && get_class($item) == 'Illuminate\Support\Collection') {
            return $item;
        }
        return $item;
    }

    function preparedSyncItem($requestItems, $currentItems)
    {
        $currentItemsId = $currentItems->pluck($this->relatedKeyId);
        $requestItems = $this->turn_to_collection($requestItems);

        if (gettype($requestItems[0]) == 'integer' || gettype($requestItems[0]) == 'string') {
            $requestItemsId = $requestItems;
        } else if (gettype($requestItems[0]) == 'array') {
            $requestItemsId = $requestItems->pluck($this->relatedKeyId);
        }

        $item = [
            'new' => collect(),
            'update' => collect(),
            'delete' => collect(),
            'donothing' => collect(),
        ];

        $item['delete'] = $currentItemsId->diff($requestItemsId); // if item exist on CurrentItem not on RequestItem => delete item
        $item['sameBaseOnId'] = $requestItemsId->intersect($currentItemsId);

        if ($this->comparingIdOnly == true) {
            $item['new'] = $requestItemsId->diff($currentItemsId); // if item exist on RequestItem and not On CurrentItem => new item
        } else {
            $compareFn = $this->arrFn['compare'];
            $item['new'] = $compareFn['new']($requestItems, $currentItems, $requestItemsId, $currentItemsId);
        }
        return $item;
    }
}
