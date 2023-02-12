<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;

class DatatableController extends Controller
{

    public function products(Request $request)
    {
        $totalData = Product::filters($request->all())->count();

        $totalFiltered = $totalData;

        $start = $request->length == -1 ? 0 : $request->start;
        $limit = $request->length == -1 ? $totalData : $request->length;

        try {

        }
        catch (\Exception $e) {
            return response()->json([
                'draw' => $request->draw,
                'recordsTotal' => $totalData,
                'recordsFiltered' => $totalFiltered,
                'data' => [],
                'error' => $e->getMessage()
            ]);
        }

        $products = Product::filters($request->all());

        if (empty($request->input('search.value'))) {
            $products = $products->offset($start)->limit($limit)->get();
        }
        $data = [];



        foreach ($products as &$product) {
            $product->actions = "";
            $status = $product->ignored == 1 ? 'checked' : '';
            $product->ignored = '<input type="checkbox" name="ignore_status" class="form-check-input ignore_status" data-id="' . $product->id . '" ' . $status . '><span class="form-check-label">Ignore</span>';

            $product->soft_cap = '<input type="text" class="form-control soft_cap" value="' . $product->soft_cap . '" data-id="' . $product->id . '">';

            $delete = '<form method="post" action="' . route('products.destroy', $product->id) . '" style="display: inline"
                        onsubmit="return confirmSubmission(this, \'Are you sure?\')">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn text-danger" href="' . route('products.destroy', $product->id) . '"><i class="fa fa-trash"></i></button>
                    </form>';

            $product->actions .= $delete;
            $data[] = $product;
        }

        $data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalData,
            "recordsFiltered" => $totalFiltered,
            'data' => $data,
        ];

        return response()->json($data);


    }


}
