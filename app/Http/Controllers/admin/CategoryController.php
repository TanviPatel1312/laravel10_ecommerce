<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @var categoryRepository
     */
    public $categoryRepository;

    /**
     * LotRepository constructor.
     */
    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

    public function index(Request $request)
    {
        try {
            $category = $this->categoryRepository->categoryList($request);
            return view('admin.category.list', compact('category'));
        } catch (Exception $e) {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(CategoryRequest $request)
    {
        // Create a new category using validated data
        try {
            $this->categoryRepository->categoryCreate($request);
            return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
        } catch (Exception $e) {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $category = Category::find($id);
            return view('admin.category.create', compact('category'));
        } catch (Exception $e) {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        try {
            $this->categoryRepository->categoryUpdate($request, $id);
            return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
        } catch (Exception $e) {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Category::destroy($id);
            return redirect()->back()->with('success', 'Category deleted successfully.');
        } catch (Exception $e) {
            Session::flash('error', $e->getmessage());
            return redirect()->back();
        }
    }
}
