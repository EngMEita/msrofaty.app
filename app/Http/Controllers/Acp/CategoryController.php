<?php

namespace App\Http\Controllers\Acp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Acp\CategoryStoreRequest;
use App\Http\Requests\Acp\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = auth()->user()->household()->categories()->get();
        $list       = $this->categorisList();
        return view('acp.category.index', compact('categories', 'list'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('acp.category.create');
    }

    /**
     * @param \App\Http\Requests\Acp\CategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create(array_merge($request->validated(), ['household_id' => auth()->user()->household()->id]));

        $request->session()->flash('category.id', $category->id);

        return redirect()->route('acp.category.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Category $category)
    {
        abort_unless($category->household_id === auth()->user()->household()->id, 404);
        return view('acp.category.show', compact('category'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = auth()->user()->household()->categories()->get();
        $current    = Category::findOrFail($id);
        abort_unless($current->household_id === auth()->user()->household()->id, 404);
        $list       = $this->categorisList();
        return view('acp.category.index', compact('categories', 'current', 'list'));
    }

    /**
     * @param \App\Http\Requests\Acp\CategoryUpdateRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        abort_unless($category->household_id === auth()->user()->household()->id, 404);
        $category->update($request->validated());

        $request->session()->flash('category.id', $category->id);

        return redirect()->route('acp.category.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        abort_unless($category->household_id === auth()->user()->household()->id, 404);
        $category->delete();

        return redirect()->route('acp.category.index');
    }

    ///

    private function categorisList($parent_id = null, $level = 1, $output = [])
    {
        if (is_null($parent_id)) {
            $categories = Category::where('household_id', auth()->user()->household()->id)->whereNull('category_id')->get();
        } else {
            $categories = Category::where('household_id', auth()->user()->household()->id)->where('category_id', $parent_id)->get();
        }

        foreach ($categories as $i => $category) {
            $category->level = $level;
            $output[$level.'.'.$category->id] = $category;
            if ($category->subcategories->count() > 0) {
                $level++;
                $output = $this->categorisList($category->id, $level, $output);
                $level--;
            }
        }
        return $output;
    }
}
