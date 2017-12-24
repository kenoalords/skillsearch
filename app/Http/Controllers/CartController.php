<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use App\Transformers\GigTransformer;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(Request $request, Gig $gig)
    {
    		$cart = $this->getCartItems($request, $gig);
    		return view('cart.cart')->with( ['items'=>$cart['inCart'], 'total'=>$cart['total'] ]);
    }

    public function getCartItems(Request $request, Gig $gig) 
    {
    		$inCart = [];
    		$cart = $request->session()->get('cart.gigs');
    		$total = 0;
    		$cart = (!is_array($cart)) ? (array) $cart : $cart;
    		if ( $cart ){

    			$gigs = $gig->whereIn('uid', $cart)->get();
    			$inCart = fractal()->collection($gigs)
    							->transformWith(new GigTransformer)
    							->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                   ->toArray();
               $map = $gigs->map(function($item, $key) use (&$total) {
               	$total += $item->sale_price;
               });
               return [ 'inCart'=>$inCart, 'total' => $total ];
    		} 
    		return false;
    }

    public function addToCart(Request $request, Gig $gig)
    {
    		$request->session()->push('cart.gigs', $gig->uid);
    		// dd($request->session()->get('cart.gigs'));
    		$request->session()->flash('status', 'I will ' . $gig->title . ' added to cart');
    		return redirect()->route('gig', ['gig'=>$gig->uid, 'slug'=>$gig->slug]);
    }

    public function deleteFromCart(Request $request, Gig $gig)
    {
    		// dd($request->session()->has('cart.gigs'));
    		if ( $request->session()->has('cart.gigs') ) {
    			$cart = (array)$request->session()->get('cart.gigs');
    			// dd($cart);
    			$key = array_search($gig->uid, $cart);
    			// dd($key);
    			$request->session()->forget('cart');
    			unset($cart[$key]);
    			$request->session()->put('cart.gigs', $cart);
    		}
    		$request->session()->flash('status', 'I will ' . $gig->title . ' removed from cart');
    		return redirect()->route('cart');
    }

    public function checkout(Request $request, Gig $gig)
    {
    		$items = $this->getCartItems($request, $gig);
    		$order_id = 'GIG-'.$items['total'].'-'.time();
    		return view('cart.checkout')->with([ 
    						'cart'			=>$items['inCart'], 
    						'amount'			=>$items['total'],
    						'order_id'		=> $order_id,
    						'amount_kobo'		=> (int)$items['total'] * 100,
    					]);
    }
}
