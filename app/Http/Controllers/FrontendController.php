<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Review;
use App\Models\Video;
use App\Models\Blog;
use App\Models\News;
use Validator;
use Redirect;
use DB;

class FrontendController extends Controller
{
    static function get_views(){

        $views = DB::table('website_views')->pluck('total_views')->first();
        $new_views = $views + 1;
        DB::table('website_views')->update(['total_views' => $new_views]);

        return $new_views;

    }

    public function index()
    {
        $total_views = self::get_views();

        $breaking_news = News::where('breaking_news', 1)->orderBy('id', 'DESC')->take(5)->get();
        $recent_news = News::take(7)->orderBy('id', 'DESC')->get();
        $latest_news = News::take(1)->orderBy('id', 'DESC')->first();
        $trending_news = News::take(8)->where('type', 'trending')->get();
        $popular_news = News::take(8)->where('type', 'popular')->get();

        $blogs = Blog::take(8)->get();

        $videos = Video::take(10)->get();
        //categoreis
        $latest_categories = Category::take(3)->orderBy('id', 'DESC')->get();



        return view('welcome', compact('breaking_news', 'recent_news', 'latest_news', 'popular_news', 'latest_categories', 'trending_news', 'blogs' ,'videos', 'total_views'));
    }

    public function about()
    {
        $breaking_news = News::where('breaking_news', 1)->orderBy('id', 'DESC')->take(5)->get();
        $total_views = DB::table('website_views')->pluck('total_views')->first();
        return view('frontend.aboutus', compact('total_views', 'breaking_news'));
    }

    public function contact()
    {
        $breaking_news = News::where('breaking_news', 1)->orderBy('id', 'DESC')->take(5)->get();
        $total_views = DB::table('website_views')->pluck('total_views')->first();
        return view('frontend.contactus', compact('total_views','breaking_news'));
    }
   
   

    public function contactStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $contact = new Contact();
        $contact['name'] = $request->name;
        $contact['email'] = $request->email;
        $contact['comment'] = $request->comment;
        $contact['subject'] = $request->subject;
        $contact['user_id'] = auth()->user()->id;
        $contact->save();
        return redirect()->back()->with('message', '?????????? ?????????????? ???? ???????? ?????? ???? ????????');

    }

    public function categories()
    {
        $breaking_news = News::where('breaking_news', 1)->orderBy('id', 'DESC')->take(5)->get();

        $total_views = DB::table('website_views')->pluck('total_views')->first();
        $categories = Category::paginate(4);
        $recent_categories = Category::take(8)->orderBy('id', 'DESC')->get();

        return view('frontend.categories', compact('categories', 'recent_categories', 'total_views', 'breaking_news'));
    }

    public function categoryDetail($slug)
    {
        $total_views = DB::table('website_views')->pluck('total_views')->first();

        $category = Category::where('slug', $slug)->first();
        $news = News::where('cat_id', $category->id)->paginate(6);

        return view('frontend.category_detail', compact('news', 'category', 'total_views'));
    }

    public function newsDetail($slug)
    {

        $breaking_news = News::where('breaking_news', 1)->orderBy('id', 'DESC')->take(5)->get();

        $total_views = DB::table('website_views')->pluck('total_views')->first();
        $news = News::where('slug', $slug)->first();

        $previous_clicks = News::where('id', '=', $news->id)->pluck('clicks')->first();
        $new_clicks = $previous_clicks + 1;
        News::where('id', '=', $news->id)->update(['clicks' => $new_clicks]);

        $recent_news = News::take(5)->orderBy('id', 'DESC')->get();
        $news = News::find($news->id);

        $category = Category::find($news->cat_id);
        $categories = Category::take(8)->orderBy('id', 'DESC')->get();
        //get reviews
        $reviews = Review::where('post_id', '=', $news->id)->where('type', 'news')->get();

        return view('frontend.news_detail', compact( 'breaking_news', 'recent_news', 'news', 'category', 'categories', 'reviews', 'total_views'));

    }

    public function blog()
    {
        $total_views = DB::table('website_views')->pluck('total_views')->first();
        $breaking_news = News::where('breaking_news', 1)->orderBy('id', 'DESC')->take(5)->get();

        $blog = Blog::paginate(5);
        $recent_categories = Category::take(8)->orderBy('id', 'DESC')->get();
        $recent_blog = Blog::take(5)->orderBy('id', 'DESC')->get();
        return view('frontend.blog', compact('blog', 'recent_categories', 'recent_blog', 'total_views', 'breaking_news'));
    }

    public function blogDetail($slug)
    {
        $total_views = DB::table('website_views')->pluck('total_views')->first();
        $breaking_news = News::where('breaking_news', 1)->orderBy('id', 'DESC')->take(5)->get();

        $blog_detail = Blog::where('slug', $slug)->first();

        $previous_clicks = Blog::where('id', '=', $blog_detail->id)->pluck('total_clicks')->first();
        $new_clicks = $previous_clicks + 1;
        Blog::where('id', '=', $blog_detail->id)->update(['total_clicks' => $new_clicks]);

        $blog = Blog::find($blog_detail->id);
        $categories = Category::take(8)->orderBy('id', 'DESC')->get();
        $recent_blog = Blog::take(5)->orderBy('id', 'DESC')->get();
        $reviews = Review::where('post_id', '=', $blog_detail->id)->where('type', 'blog')->get();

        return view('frontend.blog_detail', compact('blog', 'categories', 'recent_blog', 'reviews', 'total_views', 'breaking_news'));
    }

    public function postReview(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $user_id = auth()->user();
        if ($user_id) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = '0';
        }

        $review = new Review();

        if ($request->type == 'news') {
            $review['post_id'] = $request->news_id;
            $review['type'] = 'news';
        } else {
            $review['post_id'] = $request->blog_id;
            $review['type'] = 'blog';
        }

        $review['name'] = $request->name;
        $review['email'] = $request->email;
        $review['comment'] = $request->comment;
        $review['user_id'] = $user_id;
        $review->save();

        return redirect()->back()->with('message', '?????????? ?????????????? ???? ???????? ?????? ???? ?????? ????????');

    }

    public function terms()
    {
        $total_views = DB::table('website_views')->pluck('total_views')->first();

        $recent_news = News::take(5)->orderBy('id', 'DESC')->get();
        return view('frontend.terms', compact('recent_news', 'total_views'));
    }

    public function privacyPolicy()
    {
        $total_views = DB::table('website_views')->pluck('total_views')->first();

        $recent_news = News::take(5)->orderBy('id', 'DESC')->get();
        return view('frontend.privacy_policy', compact('recent_news', 'total_views'));

    }

    public function staff()
    {
        $breaking_news = News::where('breaking_news', 1)->orderBy('id', 'DESC')->take(5)->get();
        $total_views = DB::table('website_views')->pluck('total_views')->first();

        return view('frontend.staff', compact('total_views', 'breaking_news'));
    }

    public function search(Request $request)
    {

        $data= News::where('title','LIKE','%'.$request->search."%")->get();
        return Response($data);
    }


}
