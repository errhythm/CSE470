<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reviews;
use App\Models\Faculties;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewsController extends Controller
{
    // show the reviews of an user (faculty) with pagination of 5
    public function show_faculty($user)
    {
        return view('reviews.index', [
            'reviews' => Reviews::where('user_id', $user)->latest()->paginate(5),
            'user' => $user,
        ]);
    }


    // show the reviews of an user (faculty) as api
    public function show_faculty_api($user)
    {
        $faculty = Faculties::where('user_id', $user)->first();
        return Reviews::where('faculty_id', $faculty->id)->where('isApproved', 1)->paginate(5);
    }

    // make function to see reviews of a faculty by paginate and load more button where faculty_id = faculties->id and isApproved=1
    public function show_faculty_api_load_more($user, $page)
    {
        $faculty = Faculties::where('user_id', $user)->first();
        return Reviews::where('faculty_id', $faculty->id)->where('isApproved', 1)->paginate(5, ['*'], 'page', $page);
    }
}