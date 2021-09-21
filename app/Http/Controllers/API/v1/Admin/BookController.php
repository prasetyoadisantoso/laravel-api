<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function index()
    {
        $data = Book::all();
        $payload = [
            'data' => $data
        ];
        return $this->successResponse($payload, 'Selamat datang di Perpustakaan Sederhana');
    }

    public function createBook(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $payload = $request->all();

        try {
            $response = Book::create($payload);
            return $this->successResponse($response, 'Sukses simpan data buku');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Gagal menambahkan data buku');
        }

    }

    public function editBook(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required|string',
            'author' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $payload = $request->all();

        try {
            $book = Book::find($request->id);
            $response = $book->update($payload);
            return $this->successResponse($response, 'Sukses update data buku');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Gagal update data buku');
        }
    }

    public function deleteBook(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
        ]);

        try {
            $response = Book::find($request->id)->delete();
            return $this->successResponse($response, 'Sukses hapus data buku');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Gagal hapus data buku');
        }
    }

}
