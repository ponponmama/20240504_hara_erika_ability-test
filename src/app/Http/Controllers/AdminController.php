<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\StreamedResponse;


class AdminController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        $contacts = Contact::paginate(7);

        return view('admin', compact('contacts','categories'));

    }

    public function search(Request $request)
    {
        $categories = Category::all();

        $searchConditions = $request->only(['keyword', 'gender', 'category_id', 'date']);
        session(['search_conditions' => $searchConditions]);

        $conditions = session('search_conditions');

        $keyword = $request->keyword;
        $contacts= Contact::query()->nameOrEmailSearch($keyword);


        $gender = $request->input('gender');
        if ($gender && $gender !== 'all' ) {
        $contacts=$contacts->genderSearch($gender);
        }


        $category_id = $request->input('category_id');
        if ($category_id) {
        $contacts=$contacts->categorySearch($category_id);
        }

        $date = $request->input('date');
        if ($date) {
        $contacts=$contacts->dateSearch($date);
        }


        Session::put('search_results', [
        'keyword' => $keyword,
        'gender' => $gender,
        'category_id' => $category_id,
        'date' => $date,
        ]);


        $search_results = Session::get('search_results', []);
        $keyword = $search_results['keyword'] ?? null;
        $gender = $search_results['gender'] ?? null;
        $category_id = $search_results['category_id'] ?? null;
        $date = $search_results['date'] ?? null;

        $contacts = $contacts->paginate(7)->withQueryString();
        

        return view('admin', compact('contacts', 'categories', 'searchConditions','search_results'));
    }

    public function exportCsv(Request $request) {
           
        $search_results = Session::get('search_results', []);
        $keyword = $search_results['keyword'] ?? null;
        $gender = $search_results['gender'] ?? null;
        $category_id = $search_results['category_id'] ?? null;
        $date = $search_results['date'] ?? null;
        
        $contacts = Contact::query()
            ->nameOrEmailSearch($keyword)
            ->genderSearch($gender)
            ->categorySearch($category_id)
            ->dateSearch($date)
            ->get();

         $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=contacts.csv"
        ];

        $callback = function() use ($contacts) {
            $handle = fopen('php://output', 'w');

            $columns = ['id','category_id','first_name', 'last_name', 'gender', 'email', 'tell', 'address', 'building', 'detail','created_at','updated_at'];

             mb_convert_variables('SJIS-win', 'UTF-8', $columns);
            fputcsv($handle, $columns);

            foreach ($contacts as $contact) {
                $genderText = '';
                switch ($contact->gender) {
                    case 1:
                    $genderText = '男性';
                        break;
                    case 2:
                    $genderText = '女性';
                        break;
                    case 3:
                    $genderText = 'その他';
                        break;
                }

                $csv = [
                    $contact->id,
                    $contact->category->content ?? '',
                    $contact->first_name,
                    $contact->last_name,
                    $genderText,
                    $contact->email,
                    $contact->tell,
                    $contact->address,
                    $contact->building,
                    $contact->detail,
                    $contact->created_at->format('Y-m-d'),
                    $contact->updated_at->format('Y-m-d')
                ];
                mb_convert_variables('SJIS-win', 'UTF-8', $csv);
                fputcsv($handle, $csv);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

public function resetSearch()
   {
       session()->forget('search_conditions');

       return redirect()->route('admin.index');
   }

     public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        
        $contact->delete();

        session()->flash('success', '連絡先が正常に削除されました。');
        session()->put('redirect_success', true);

        return redirect()->route('admin.index');
    }
}