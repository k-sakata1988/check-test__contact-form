<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function index(Request $request)
{
    $query = Contact::query();

    if ($request->filled('keyword')) {
        $keyword = $request->input('keyword');
        $query->where(function($q) use ($keyword) {
            $q->where('last_name', 'like', "%{$keyword}%")
              ->orWhere('first_name', 'like', "%{$keyword}%")
              ->orWhereRaw("CONCAT(last_name, first_name) like ?", ["%{$keyword}%"])
              ->orWhere('email', 'like', "%{$keyword}%");
        });
    }

    if ($request->filled('gender') && $request->gender !== 'all') {
        $query->where('gender', $request->gender);
    }
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $contacts = $query->paginate(7)->withQueryString();;

    return view('admin.admin', compact('contacts'));
}


    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin.contacts.index')->with('success', '削除しました');
    }

    public function export(Request $request)
    {
        $query = Contact::query();

        // if ($request->filled('name')) {
        //     $name = $request->input('name');
        //     $query->where(function($q) use ($name) {
        //         $q->where('first_name', 'like', "%{$name}%")
        //           ->orWhere('last_name', 'like', "%{$name}%")
        //           ->orWhereRaw("CONCAT(last_name, first_name) like ?", ["%{$name}%"]);
        //     });
        // }
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                  ->orWhere('last_name', 'like', "%{$keyword}%")
                  ->orWhereRaw("CONCAT(last_name, first_name) like ?", ["%{$keyword}%"]);
            });
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->input('email')}%");
        }
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->input('gender'));
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        $contacts = $query->get();

        $genders = [1 => '男性', 2 => '女性', 3 => 'その他'];

        $csvData = [];
        $csvData[] = ['ID', '姓', '名', '性別', 'メール', '住所', '建物', 'お問い合わせ種類', '内容', '登録日時'];
        foreach ($contacts as $c) {
            $csvData[] = [
                $c->id,
                $c->last_name,
                $c->first_name,
                // $c->gender,
                $genders[$c->gender] ?? '未設定',
                $c->email,
                $c->address,
                $c->building,
                // $c->category_id,
                $c->category->content ?? '',
                $c->detail,
                $c->created_at
            ];
        }

        $filename = "contacts_" . date('YmdHis') . ".csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function() use ($csvData) {
            $fp = fopen('php://output', 'w');
            foreach ($csvData as $line) {
                fputcsv($fp, $line);
            }
            fclose($fp);
        };

        return Response::stream($callback, 200, $headers);
    }
}
