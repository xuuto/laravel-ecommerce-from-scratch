<?php

namespace App\Http\Controllers\Site;

use App\Contract\ProductContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    protected $productRepository;

    public function __construct (ProductContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->listProducts();

        return view('site.pages.homepage', compact('products'));
    }
}
