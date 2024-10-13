<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['user'])->paginate(20); // Assuming a relationship exists in OrderItem for products

        if ($orders->isEmpty()) {
            return response()->json([
                'message' => 'There are no orders'
            ], 404); // Return 404 status if no orders are found
        }

        // Process the orders to include product names
        foreach ($orders as $order) {
            foreach ($order->items as $order_item) {
                // Assuming you have a 'product' relationship in the OrderItem model
                $order_item->product_name = $order_item->product ? $order_item->product->name : 'Unknown Product';
            }
        }

        return response()->json([
            'message' => 'List of all orders',
            'data' => $orders->items()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            // Fetch the user's location
            $location = Location::where('user_id', Auth::id())->first();

            // If no location is found, return an error
            if (!$location) {
                return response([
                    'message' => 'Location not found for this user'
                ], 400);
            }

            // Validate the request, including the 'order_items' array and its contents
            $validatedData = $request->validate([
                'order_items' => 'required|array', // Ensure order_items is an array
                'quantity' => 'required|integer|min:1', // Ensure quantity is an integer
                'date_of_delivery' => 'required|date', // Ensure the delivery date is provided
                'total_price' => 'required|numeric|min:0', // Ensure total price is a valid number
            ]);

            // Create a new order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->location_id = $location->id;
            $order->total_price = $request->total_price;
            $order->date_of_delivery = $request->date_of_delivery;
            $order->save();

            // Loop through the validated order items and save each one
            foreach ($request->order_items as $item) {
                $orderItem = new Order_items(); // Make sure this matches your model name
                $orderItem->order_id = $order->id; // Associate with the current order
                $orderItem->product_id = $item['product_id'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->save();

                // Optional: Update the product's quantity in stock
                $product = Products::find($item['product_id']); // Ensure this model matches your setup
                if ($product) {
                    $product->quantity -= $item['quantity']; // Decrement quantity by the ordered amount
                    $product->save();
                }
            }


            // Return a success response
            return response([
                'message' => 'Order created successfully',
                'data' => $order
            ], 201);

        } catch (ValidationException $exception) {
            // If validation fails, return validation errors in the response
            return response([
                'message' => 'Validation error',
                'errors' => $exception->errors() // Include validation errors
            ], 422); // Unprocessable Entity status code for validation errors

        } catch (\Exception $exception) {
            // Return an error response with the exception message
            return response([
                'message' => $exception->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('user')->findOrFail($id);
        if (!$order){
            return response([
                'message' => 'Order not found'
            ],404);
        }else{
            return response([
                'message' => 'Order details',
                'data' => $order
            ],200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order=Order::find($id);
        if (!$order){
            return response([
                'message' => 'Order not found'
            ],404);
        }else{
            $order->update(['status'=>$request->status]);
            return response([
                'message' => 'Order updated successfully',
                'data' => $order
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function get_order_items( string $id)
    {
        $order_items=Order_items::where('order_id', $id)->get();
        if (!$order_items) {
            return response([
                'message' => 'Order items not found'
            ],404);
        }else{
           foreach ($order_items as $order_item) {
               $product=Products::where('id',$order_item->product_id)->pluck('name');
               $order_item->product_name=$product[0];
           }
           return response([
               'message' => 'List of all order items',
               'data' => $order_items
           ]);
        }
    }
    public function get_user_orders(Request $request, string $id)
    {
        $orders=Order::where('user_id', $id)::with('items',function($query){
           $query->orderBy('created_at', 'desc');
        })->get();
        if(!$orders){
            return response([
                'message' => 'Order not found'
            ],404);
        }else{

            foreach ($orders as $order_item) {
                $product=Products::where('id',$order_item->product_id)->pluck('name');
                $order_item->product_name=$product[0];
            }
            return response([
                'message' => 'List of all orders',
                'data' => $orders
            ]);
        }
    }

}
