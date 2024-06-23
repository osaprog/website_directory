<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the websites with their categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $websites = Website::with('categories')->get();

        return response()->json($websites);
    }

    /* @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search_engine(Request $request){
        $websites = Website::search($request->input('search'))
            ->get()
            ->map(function ($website) {
                return [
                    'id' => $website->id,
                    'name' => $website->name,
                    'url' => $website->url,
                    'description' => $website->description,
                    'votes_count' => $website->votes()->count(),
                    'categories' => $website->categories()->get(),
                ];
            });

        return response()->json(['data' => $websites]);
    }

    /**
     * Store a newly created website with categories in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url|unique:websites',
            'categories' => 'required|array', // Assuming categories are submitted as an array of IDs
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Create the website
        $website = Website::create([
            'url' => $request->url,
            'name' => $request->name,
            'description' => $request->description
        ]);

        // Attach categories
        $website->categories()->attach($request->categories);

        // Load the categories after attaching them
        $website->load('categories');

        return response()->json($website, 201);
    }

    /**
     * Delete the specified website.
     *
     * @param  \App\Models\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function destroy(Website $website)
    {
        // Check if the authenticated user can delete the website
        if (Auth::user()->hasPermissionTo('delete website')) {
            $website->categories()->detach(); // Remove relationships first
            $website->delete();
            return response()->json(['message' => 'Website deleted successfully']);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    /**
     * Search websites based on categories, ranking, and keywords.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Implement search logic based on request parameters (categories, ranking, keywords)
        $query = Website::query()
            ->leftJoin('votes', 'websites.id', '=', 'votes.website_id')
            ->select('websites.*', \DB::raw('COUNT(votes.id) as votes_count'))
            ->groupBy('websites.id');


        if ($request->has('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('id', $request->category_id);
            });
        }

        // Search by ranking (sort by votes)
        if ($request->has('rank')) {
            $query->orderBy('votes_count', 'desc');
        }

        // Search by keywords (in website name or description)
        if ($request->has('keywords')) {
            $keywords = $request->keywords;
            $query->where(function ($q) use ($keywords) {
                $q->where('name', 'like', '%' . $keywords . '%')
                    ->orWhere('description', 'like', '%' . $keywords . '%');
            });
        }

        $websites = $query->with('categories')->get();

        return response()->json($websites);
    }
}
