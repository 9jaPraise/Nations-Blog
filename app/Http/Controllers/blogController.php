<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Category;


class blogController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('index', 'show');
    }
    //To blog Page
    public function index(Request $request){
        if($request->search){
            $posts = Post::where('title', 'like', '%' . $request->search . '%')
            ->orwhere('body', 'like', '%' . $request->search . '%')->latest()->paginate(2);
        }elseif($request->category){
            $posts=Category::where('name', $request->category)->firstOrfail()->posts()->paginate(1)->withQueryString();
        }else{
            $posts= Post::latest()->paginate(2); //Display all post on blog Page
        }

        $categories= Category::all(); //Display all category on blog Page
        return view('blogPosts.blog', compact('posts','categories'));
    }

    //To create blog post for admin
    public function create(){
        $categories= Category::all();
        return view('blogPosts.create-blog-post', compact('categories'));
    }

    //To save blog post to DB
    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'image'=>'required | image',
            'body' => 'required',
            'category_id' => 'required',

        ],

        [
            'category_id.required' => 'category field is required'
        ]);



        $title = $request->input('title');
        $category_id = $request->input('category_id');
        if (Post::latest()->first()!==null) {
            $postId=Post::latest()->first()->id+1;
        } else {
            $postId=1;
        }
        $slug = Str::slug($title, '-') . '-' . $postId;
        $user_id = Auth::user()->id;
        $body = $request->input('body');

        //file uplaod
       $Imagepath = 'storage/'.$request->file('image')->store('postImages','public');

        //creating post to DB
        $post = new Post();

        $post -> title = $title;
        $post -> category_id =$category_id;
        $post -> slug = $slug;
        $post -> user_id = $user_id;
        $post -> body = $body;
        $post -> Imagepath = $Imagepath;

        $post->save();

        return redirect()->back()->with('status', 'Post Created Successfully');

    }

        //  To show single blog post
    // public function show($slug){
    //     $post=Post::where('slug', $slug)->first();
    //     return view('blogPosts.single-blog-post',compact('post'));
    // }

    //using route model binding for a single post
    public function show(Post $post){
        $category = $post->category;
        $relatedPosts=$category->posts()->where('id', '!=', $post->id)->latest()->take(3)->get();
        return view('blogPosts.single-blog-post',compact('post', 'relatedPosts'));
    }

    //To edit post
    public function edit(Post $post){
        if(auth()->user()->id!==$post->user->id) {
            abort(403);
        }
        return view('blogPosts.edit-blog-post',compact('post'));
    }

      //To edit post
    public function update(Request $request, Post $post){
        if(auth()->user()->id!==$post->user->id) {
            abort(403);
        }

        $request->validate([
            'title'=>'required',
            'image'=>'required | image',
            'body' => 'required'

        ]);

        $title = $request->input('title');
        $postId= $post->id;
        $slug = Str::slug($title, '-') . '-' . $postId;
        $body = $request->input('body');

        //file uplaod
       $Imagepath = 'storage/'.$request->file('image')->store('postImages','public');

        $post -> title = $title;
        $post -> slug = $slug;
        $post -> body = $body;
        $post -> Imagepath = $Imagepath;

        $post->save();

        return redirect()->back()->with('status', 'Post Updated Successfully');

    }

       //To edit post
    public function destroy(Post $post){
        $post->delete();

        return redirect()->back()->with('status', 'Post Deleted Successfully');
    }

}
