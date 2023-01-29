<?php

namespace App\Http\Controllers;

use App\Imports\ProductImporter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function productImport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => ['required', 'mimes:csv'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation Failed.!', 'data' => $validator->errors()->all()], 422);
        }

        try {
            //code...
            Excel::import(new ProductImporter, request()->file('file'));

            /** 
             * checking wether the request from API or not
             * API request response 
             */
            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'data' => [], 'message' => 'Product inported successfully']);
            }

            /** HTTP request response  */
            return redirect()->route('home')->with('success', 'Product inported successfully');
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Something went wrong, Please try again']);
        }
    }

    public function list(Request $request)
    {
        try {
            //code...
            $limit = 10;

            $products = Product::orderBy('name', 'ASC')->paginate($limit);

            /** 
             * checking wether the request from API or not
             * API request response 
             */
            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'data' => $products, 'message' => 'Products list fetched sucessfully']);
            }

            return response()->json(['success' => true, 'data' => $products, 'message' => 'Products list fetched sucessfully']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Something went wrong, Please try again']);
        }
    }
}
