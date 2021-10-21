<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'price' => 'required|numeric',
            'image' => 'required|image',
        ]);

        // Image Processing
        if ($request->hasFile('image')) {
            $get_name = $request->file('image')->getClientOriginalName();
            $get_extension = $request->file('image')->getClientOriginalExtension();
            $names = md5($get_name) . "." . $get_extension;
            $imagePath = 'assets/image';
            Storage::putFileAs('public/' . $imagePath, $request->file('image'), $names);
            $request->image = $imagePath . "/" . $names;
        }

        try {
            $book = new Book;
            $book->title = $request->title;
            $book->author = $request->author;
            $book->price = $request->price;
            $book->image  = $request->image;
            $book->save();

            return $this->successResponse($book, 'Sukses simpan data buku');
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

        // Image Processing
        if ($request->hasFile('image')) {

            // Get data from car id
            $book = Book::find($request->id);

            // Delete car image
            Storage::delete('/public' . '/' . $book->image);

            $get_name = $request->file('image')->getClientOriginalName();
            $get_extension = $request->file('image')->getClientOriginalExtension();
            $names = md5($get_name) . "." . $get_extension;

            $imagePath = 'assets/image';
            Storage::putFileAs('public/' . $imagePath, $request->file('image'), $names);

            $payload['image'] = $imagePath . "/" . $names;
        }

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
            $response = Book::find($request->id);

            // Delete car image
            Storage::delete('/public' . '/' . $response->image);

            $response->delete();

            return $this->successResponse($response, 'Sukses hapus data buku');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Gagal hapus data buku');
        }
    }

}
