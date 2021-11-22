<?php

namespace App\Http\Controllers\API\v1\Client;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = Book::all();
        $payload = [
            'data' => $data
        ];
        return $this->successResponse($payload, 'Selamat datang di Perpustakaan Sederhana');
    }
}
