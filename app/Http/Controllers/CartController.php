<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;


class CartController extends Controller
{
    //
    function show()
    {
    	return view('cart.show');
    }
    function add(Request $request, $id)
    {
    	//Cart::destroy();
    	$product = Product::find($id);
    	//return $product;
    	if($product->qty>0)
    	{

    		Cart::add(['id' => $product->id,
    	 	'name' => $product->name, 
    	 	'qty' => 1, 
    	 	'price' => $product->price, 
    	 	'options' => ['thumbnail' =>  $product->thumbnail, 'max_qty' => $product->qty]
    		]);
    	}
    	/*else
    	{
    		return redirect('cart')->with('warning', 'Xin lỗi! Sản phẩm này đã hết hàng!');
    	}

    	return redirect('cart')->with('status', 'Thêm sản phẩm vào giỏ hàng thành công!');*/
    	return redirect('cart');


    	//Cart::add('293ad', 'Product {$id}', 1, 9.99);
    	//echo "<pre>";
    	//print_r(Cart::content());


    	//return "thêm giỏ hành số {$id} thành công";
    }
    function remove($row_Id){
        Cart::remove($row_Id);
        //return redirect('cart')->with('status', 'Bạn đã xóa sản phẩm khỏi giỏ hàng thành công!');
        return redirect('cart');
    }

    function destroy(){
        Cart::destroy();
        //return redirect('cart')->with('status', 'Bạn đã xóa toàn bộ sản phẩm thành công!');
        return redirect('cart');
    }
    function update(Request $request)
    {
        $data = $request->get('qty');
        foreach($data as $k => $v){
            Cart::update($k, $v);
        }
        //return redirect('cart')->with('status', 'Cập nhật giỏ hàng thành công!');
        return redirect('cart');

    }
    function update_ajax(Request $request){
        $sub_total = 0;
        $rowId = $request->rowId;
        $qty = $request->qty;
        /*if(Cart::count()>0){
            foreach(Cart::content() as $item){
                $item->qty = $qty;
                $sub_total += $item->subtotal;
            }
        }

        */
        
        Cart::update( $rowId, $qty );

        $data = [
            'sub_total' => number_format(Cart::get($rowId)->subtotal, 0, '', '.')."đ",
            'total' => Cart::subtotal(0, '', '.')."đ",
            'num_order' => Cart::count()
        ];
        return json_encode($data);
        
        /*$id = request()->id;
        $qty = request()->qty;
        Cart::update( $id, $qty );
        $data = array(
                'sub_total'=>number_format( Cart::get( $id )->subtotal, 0, ',', '.' ).'đ',
                'total'=>Cart::total().'Đ',
                'num_order'=>Cart::count());
        echo json_encode( $data );
        */
    }
}
