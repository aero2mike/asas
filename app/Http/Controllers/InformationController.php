<?php

namespace App\Http\Controllers;

use App\Models\CartInventory;
use App\Models\Char;
use App\Models\ItemDB;
use App\Models\VendingItems;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Vendings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InformationController extends Controller
{
    public $mvp_id = [
        4047,
        4054,
        4121,
        4123,
        4128,
        4131,
        4132,
        4134,
        4135,
        4137,
        4142,
        4143,
        4144,
        4145,
        4146,
        4147,
        4148,
        4168,
        4174,
        4198,
        4236,
        4276,
        4302,
        4305,
        4318,
        4324,
        4330,
        4342,
        4352,
        4354,
        4357,
        4359,
        4361,
        4363,
        4365,
        4367,
        4372,
        4374,
        4376,
        4386,
        4399,
        4403,
        4407,
        4408,
        4419,
        4425,
        4430,
        4441,
        4565,
        4563,
        4561,
    ];
    private function getTotal($table, $nameid)
    {
        return DB::table($table)
            ->select(DB::raw('COALESCE(SUM(`amount`), 0) AS total'))
            ->whereIn('nameid', [$nameid])
            ->orWhere('card0', $nameid)
            ->first()
            ->total;
    }

    /**
     *   Fetching all the game accounts that belong to the logged in user.
     * 
     *  @return \Inertia\Response 
     * */
    public function mvp_cards()
    {
        $mvp_cards = Cache::remember('mvp_cards', 60*24, function () {
            $data = [];

            foreach ($this->mvp_id as $value) {
                $nameid = $value;

                $inventoryTotal = $this->getTotal('inventory', $nameid);
                $cartTotal = $this->getTotal('cart_inventory', $nameid);
                $storageTotal = $this->getTotal('storage', $nameid);
                $guildStorageTotal = $this->getTotal('guild_storage', $nameid);

                $total = $inventoryTotal + $cartTotal + $storageTotal + $guildStorageTotal;
                if($total == 0) continue;

                $data[] = [
                    'nameid' => $nameid,
                    'total'  => $total,
                ];
            }

            return $data;
        });

        return Inertia::render('Information/MvpCards', ['mvp_cards' => $mvp_cards]);
    }

    public function general(Request $request)
    {
        return Inertia::render('Information/General');
    }

    public function whosell(Request $request)
    {
        $querySearch = $request->input('q', '');
        $itemType = $request->input('filter_type', '');
        $vending = Vendings::with('vendingItems')->get();

        // Aplicar el filtro de búsqueda si se proporciona un valor
        if (!empty($querySearch)) {
            $vending = $vending->filter(function ($vending) use ($querySearch) {
                // Filtrar por algún criterio relacionado con el valor de búsqueda
                // Por ejemplo, si deseas filtrar por nombre de artículo:
                $foundItem = $vending->vendingItems->filter(function ($vendingItem) use ($querySearch) {
                    $itemId = CartInventory::find($vendingItem->cartinventory_id);
                    $itemName = ItemDB::find($itemId->nameid)->name_english ?? 'Unknown';
                    return stripos($itemName, $querySearch) !== false;
                });

                return $foundItem->isNotEmpty();
            });
        }

        $perPage = 25; // Number of items per page
        $currentPage = request()->query('page', 1); // Get the current page from the query string

        $offset = ((int)$currentPage - 1) * $perPage;
        $currentPageItems = $vending->slice($offset, $perPage);

        $itemsShop = [];

        foreach ($currentPageItems as $vending) {
            $vendingItems = [];

            foreach ($vending->vendingItems as $vendingItem) {
                $itemId = CartInventory::find($vendingItem->cartinventory_id);
                $vendingItems[] = [
                    'item_id' => $itemId->nameid ?? 512,
                    'item_name' => ItemDB::find($itemId->nameid)->name_english ?? 'Unknown',
                    'amount' => $vendingItem->amount,
                    'price' => $vendingItem->price,
                ];
            }

            $itemsShop[] = [
                'item_id' => $vendingItems[0]['item_id'],
                'item_name' => $vendingItems[0]['item_name'],
                'amount' => $vendingItems[0]['amount'],
                'price' => $vendingItems[0]['price'],
                'shop' => [
                    'map' => $vending->map,
                    'x' => $vending->x,
                    'y' => $vending->y,
                    'char_name' => Char::find($vending->char_id)->name,
                    'title' => $vending->title,
                    'vend_type' => $vending->extended_vending_item,
                ],
                'vendingItems' => $vendingItems,
            ];
        }

        $totalItems = $vending->count();

        $paginator = new LengthAwarePaginator(
            $itemsShop,
            $totalItems,
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );

        return Inertia::render('Information/WhoSell', ['vendings' => $paginator]);
    }
}
