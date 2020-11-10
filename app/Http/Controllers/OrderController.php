<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Item;
use App\Modules\Orders\Entities\OrderLines;
use App\Order;
use App\OrderedItem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;


class OrderController extends Controller
{
    public function __construct()
    {
    }

    public function placeOrder(Request $request)
    {
        $this->checkValidation($request);
        $requestAttributes = $request->all();
        DB::beginTransaction();
        $order = $this->generateOrder($requestAttributes['order']);
        $orderedItems = $this->prepareOrderedItems($requestAttributes['ordered_items']);
        $order->orderedItems()->saveMany($orderedItems);
        DB::commit();
        return response()->json([
            "message" => "Order is placed successfully"
        ], 200);
    }

    /**
     * @param $request
     * @return Application|ResponseFactory|Response
     */
    private function checkValidation($request)
    {
        $validator = Validator::make($request->all(), [
            'order.billing_name'         => 'required|string|max:100',
            'order.delivery_address'     => 'required|string|max:100',
            'ordered_items' => 'required|array',
            'ordered_items.*.item_id' => [
                'bail',
                'required',
                'integer',
                Rule::exists('items', 'id')->where('deleted_at', null),
            ],
            'ordered_items.*.quantity' => 'required|int|min:1',
        ]);

        if ($validator->fails()) {
            return response([
                'errors' => $validator->errors()
            ], 403);
        }
    }

    private function generateOrder($data)
    {
        $data['user_id']      = 1;
        $data['order_number'] = $this->generateUniquePrefixOrderNumber();
        $data['ordered_on']   = now();

        return Order::create($data);
    }


    private function generateUniquePrefixOrderNumber(string $prefix = 'Service'): string
    {
        return sprintf('%s-%s', $prefix, date('Y').date('m'));
    }


    private function prepareOrderedItems($data)
    {
        $orderedItems = array_map(
            function ($lines) {
                $orderedItemsData = [];

                $item = Item::find($lines['item_id']);
                $mapData = [
                    'item_id' => $lines['item_id'],
                    'quantity'=> $lines['quantity'],
                    'rate' => $item->rate,
                    'amount' => $item->rate * $lines['quantity']
                ];
                array_push($orderedItemsData, new OrderedItem($mapData));

                return $orderedItemsData;
            },
            $data
        );
        $orderedItems = Arr::flatten($orderedItems);

        return $orderedItems;
    }

}
