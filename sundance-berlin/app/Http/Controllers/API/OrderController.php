<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public function storeOrder(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'street'   => 'required',
            'postcode' => 'required',
            'city'     => 'required',
            'country'  => 'required',
            'email'    => 'required|email',
            'cart'     => 'required',
          ]);
        
        $order = new Order();
        $order->name = $request->name;
        $order->street = $request->street;
        $order->postcode = $request->postcode;
        $order->city = $request->city;            
        $order->country = $request->country;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->cart = serialize($request->cart);
        $order->totalPrice = $request->totalPrice;
        $order->save();          
    }

    public function index()
    {
        $orders = Order::paginate(2);
        return $orders;
    }

    public function search(){
      // if condition to check that search input is't empty and the axios request has a search variable
        if ($search = \Request::get(trim('search'))) {
          $orders = Order::where('name', 'LIKE', "%$search%")
                  ->orWhere('street', 'LIKE', "%$search%")
                  ->orWhere('postcode', 'LIKE', "%$search%")
                  ->orWhere('country', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%")
                  ->orWhere('cart', 'LIKE', "%$search%")->orderBy('created_at', 'desc')->paginate(2);
        }else{
          $orders = Order::paginate(2);
        }
        return $orders;
    }

    public function setChecked($id){
      $order = Order::findOrFail($id);
      $order->unchecked = false;
      $order->save();
    }

    public function selectUnChecked(){
      $orders = Order::where('unchecked', 1)->orderBy('created_at', 'DESC')->paginate(2);
        return $orders;
    }

    public function printOrder($id) {
      
      $order = Order::where('id', $id)->get();
        return $order;

    }
}
