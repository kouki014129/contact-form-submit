<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactController extends Controller
{
    private const GENDER_LABELS = [
        1 => '男性',
        2 => '女性',
        3 => 'その他',
    ];

    private const CSV_HEADERS = [
        'お名前',
        '性別',
        'メールアドレス',
        '電話番号',
        '住所',
        '建物名',
        'お問い合わせの種類',
        'お問い合わせ内容',
        '作成日',
    ];

    public function index(): \Illuminate\Contracts\View\View
    {
        $categories = Category::orderBy('id')->get();

        return view('contact.index', compact('categories'));
    }

    public function confirm(ContactRequest $request): \Illuminate\Contracts\View\View
    {
        $form = $request->except('_token');
        $request->session()->flash('contact_input', $form);

        return view('contact.confirm', [
            'form' => $form,
            'category' => Category::find($form['category_id']),
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $form = $request->session()->get('contact_input');

        if (!$form) {
            return redirect('/');
        }

        $contact = [
            'category_id' => $form['category_id'],
            'first_name' => $form['first_name'],
            'last_name' => $form['last_name'],
            'gender' => $form['gender'],
            'email' => $form['email'],
            'tel' => $form['tel1'] . $form['tel2'] . $form['tel3'],
            'address' => $form['address'],
            'building' => $form['building'] ?? '',
            'detail' => $form['detail'],
        ];

        Contact::create($contact);

        $request->session()->forget('contact_input');

        return redirect('/thanks');
    }

    public function thanks(): \Illuminate\Contracts\View\View
    {
        return view('contact.thanks');
    }

    public function admin(Request $request): \Illuminate\Contracts\View\View
    {
        $categories = Category::orderBy('id')->get();
        $selectedContact = null;

        $contacts = Contact::with('category')
            ->keywordSearch($request->keyword)
            ->genderSearch($request->gender)
            ->categorySearch($request->category_id)
            ->dateSearch($request->date)
            ->orderByDesc('id')
            ->paginate(7)
            ->appends($request->query());

        if ($request->filled('detail_id')) {
            $selectedContact = Contact::with('category')->find($request->input('detail_id'));
        }

        return view('admin.index', compact('categories', 'contacts', 'selectedContact'));
    }

    public function search(Request $request)
    {
        $categories = Category::orderBy('id')->get();
        $contacts = Contact::with('category')
            ->keywordSearch($request->keyword)
            ->genderSearch($request->gender)
            ->categorySearch($request->category_id)
            ->dateSearch($request->date)
            ->orderByDesc('id')
            ->paginate(7)
            ->appends($request->query());

        $selectedContact = null;
        if ($request->filled('detail_id')) {
            $selectedContact = Contact::with('category')->find($request->input('detail_id'));
        }

        return view('admin.index', compact('categories', 'contacts', 'selectedContact'));
    }

    public function export(Request $request): StreamedResponse
    {
        $contacts = Contact::with('category')
            ->keywordSearch($request->keyword)
            ->genderSearch($request->gender)
            ->categorySearch($request->category_id)
            ->dateSearch($request->date)
            ->orderByDesc('id')
            ->get();

        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($contacts) {
            $stream = fopen('php://output', 'w');

            fputcsv($stream, self::CSV_HEADERS);

            foreach ($contacts as $contact) {
                fputcsv($stream, [
                    $contact->first_name . ' ' . $contact->last_name,
                    $this->formatGender($contact->gender),
                    $contact->email,
                    $contact->tel,
                    $contact->address,
                    $contact->building,
                    optional($contact->category)->content,
                    $contact->detail,
                    optional($contact->created_at)->format('Y-m-d'),
                ]);
            }

            fclose($stream);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function destroy(Request $request, Contact $contact): \Illuminate\Http\RedirectResponse
    {
        $contact->delete();

        $query = array_filter([
            'keyword' => $request->input('keyword'),
            'gender' => $request->input('gender'),
            'category_id' => $request->input('category_id'),
            'date' => $request->input('date'),
        ], static fn($value) => $value !== null && $value !== '');

        if ($query !== []) {
            return redirect()->to('/search?' . http_build_query($query));
        }

        return redirect('/admin');
    }

    private function formatGender(int $gender): string
    {
        return self::GENDER_LABELS[$gender] ?? self::GENDER_LABELS[3];
    }
}
