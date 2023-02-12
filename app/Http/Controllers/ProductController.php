<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Rap2hpoutre\FastExcel\FastExcel;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pages.product.index', get_defined_vars());
    }

    function create()
    {
        return view('pages.product.add');

    }

    function store(Request $request)
    {
        Product::create([
            'soft_cap' => $request->get('soft_cap'),
            'eshop_id' => $request->get('product_id'),
            'url' => $request->get('link')
        ]);

        return back()->with('success', 'Product created successfully.');
    }

    function scrape()
    {

        $url = "https://www.skroutz.gr/s/23600384/Sony-PlayStation-5.html";
//        $url = $request->url;
//        if($url == null){
//            return redirect()->back()->with('error', 'Please enter a valid url');
//        }
//        $url = "https://app.scrapingbee.com/api/v1/?api_key=M0X68R92D437A7AZ1WA5AOO0QGVWJTI9FHEPCRYZBF41163TYLFV24LH97TCCM05SQZNVNRCCN1K3KK4&url=$url&wait=3";

//        dd($url);
        $url = "http://localhost:65/";
        $client = new Client();
        $crawler = $client->request('GET', $url);
        echo $crawler->html();
        $crawler->filter('#prices')->each(function ($node) use ($crawler) {

            $products = new Crawler($node->html());
            $count = 1;
            $products->filter('li')->each(function ($product) use (&$count) {

                $product_price = $product->filter('.dominant-price')->text();
//                $product_shop = $product->filter('.shop-name')->text();
//                $product_type = $product->filter('.pro-badge-btn');
//                $product_type = $product_type->count() > 0 ? 1 : 0;
                echo sprintf('%d) Price: %s', $count, $product_price) . "<hr>";
                $count++;
                //store the data in database
                Product::create([
                    'price' => $product_price
                ]);

            });

        });
    }

    public function destroy(Product $product)
    {
        $product->delete();
        Session::flash('success', 'Product deleted successfully');
        return redirect()->back();
    }

    //function to update soft cap




    public function softcap(Product $product, Request $request)
    {
        $new_value = request('soft_cap_new_val');
        $product->soft_cap = $new_value;
        $product->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Softcap successfully updated to ' . $new_value
        ]);
    }

    public function ignore_status(Product $product, Request $request)
    {
        $new_value = request('ignore_status');
        $product->ignored = $new_value;
        $product->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully updated'
        ]);
    }
}
