<?php
class Admin_Controller extends Controller {

	public $restful = true;
	public $layout = 'layouts.admin';

	function __construct()
	{
		parent::__construct();
		$this->filter('before','auth')->except(['login','install']);
		$this->layout->title = 'Admin Dashboard';
	}

	function get_index()
	{
		$data['tags'] = array_map(function($item){
			return '"'.$item->name.'"';
		},Tag::get());
		$this->layout->content = View::make('admin.index',$data);
	}

	function post_index()
	{
		$data = Input::get();
		Input::flash();

		$val = Validator::make($data,Post::rules());

		if ($val->fails()) {
			return Redirect::to('admin')->with_errors($val);
		}

		$time = new MongoDate;
		$counter = 0;

		foreach (explode(',',$data['tags']) as $tag) {
			$tagSlug = Str::slug($tag);
			$tags[$counter] = Tag::where('slug',$tagSlug)->first();
			if (!$tags[$counter]->exists) {
				$tags[$counter] = Tag::create([
					'name' => $tag,
					'slug' => $tagSlug,
					'created_at' => $time,
					'updated_at' => $time
				]);
			} else {
				$tags[$counter]->updated_at = $time;
				$tags[$counter] = $tags[$counter]->save();
			}
			$counter++;
		}

		$more = strpos($data['message'], '<!--more-->');
		$excerpt = substr($data['message'], 0, $more);

		try {
			$post = Post::create([
				'title' => $data['title'],
				'slug' => Str::slug($data['title']),
				'excerpt' => trim($excerpt),
				'message' => $data['message'],
				'tag_ids' => array_map(function($tag){
												return $tag['_id'];
											},$tags),
				'created_at' => $time,
				'updated_at' => $time
			]);
			Input::flush();

			// I know, improper use of "errors"
			return Redirect::to(URL::current())->with_errors(new Laravel\Messages([
				'title' => 'Post successfully created! '.HTML::link(URL::to($post['slug']),'Click Here').' to see the post.'
			]));
		} catch (Exception $e) {
			//Gotcha, duplicate title!
			if ($e->getCode() == 11000) {
				return Redirect::to(URL::current())->with_errors(new Laravel\Messages([
					'title' => 'Duplicate title, change it!!!'
				]));
			}
			dd($e);
			//if it's something else
			Log::exception($e);
		}

	}

	function get_login()
	{
		if (Auth::user()) {
			return Redirect::to('admin');
		}
		$this->layout->content = View::make('admin.login');
	}

	function post_login()
	{
		$data = Input::get();
		Input::flash();

		$val = Validator::make($data,User::rules());

		if ($val->fails()) {
			return Redirect::to(URL::current())->with_errors($val);
		}
		$credentials = [
			'username' => $data['username'],
			'password' => $data['password'],
			'remember' => true
		];

		if (!Auth::attempt($credentials)) {
			$errors = new Laravel\Messages([
				'username' => 'Incorrect Username',
				'password' => 'Incorrect Password'
			]);
			return Redirect::to(URL::current())->with_errors($errors);
		}

		return Redirect::to('admin');
	}

	function get_logout()
	{
		Auth::logout();
		return Redirect::to('admin/login');
	}

	function get_newtag()
	{
		$this->layout->content = View::make('admin.newtag');
	}

	function post_newtag()
	{
		$data = Input::all();
		Input::flash();

		$val = Validator::make($data,Tag::rules());

		if ($val->fails()) {
			return Redirect::to(URL::current())->with_errors($val);
		}

		$time = new MongoDate;

		try {
			Tag::create([
				'name' => $data['name'],
				'slug' => Str::slug($data['name']),
				'description' => $data['description'],
				'created_at' => $time,
				'updated_at' => $time
			]);
			Input::flush();

			return Redirect::to(URL::current())->with_errors(new Laravel\Messages([
				'name' => 'New tag created: <strong>'.$data['name'].'</strong>'
			]));
		} catch (Exception $e) {
			//Gotcha, duplicate title!
			if ($e->getCode() == 11000) {
				return Redirect::to(URL::current())->with_errors(new Laravel\Messages([
					'name' => 'Duplicate tag name, change it!!!'
				]));
			}
			//if it's something else
			Log::exception($e);
		}
	}

	function get_posts($slug = null)
	{
		$currentPage = Input::get('page',1);
		$perPage = IoC::resolve('site')->per_page;

		if (is_null($slug)) {
			$posts = Post::take($perPage)->skip(($currentPage-1)*$perPage)->get();
			$data['posts'] = Paginator::make($posts,Post::count(),$perPage);

			$this->layout->content = View::make('admin.posts',$data);
		} else {
			$data['post'] = Post::where('slug',$slug)->first();
			if (!$data['post']->exists) {
				return Response::error(404);
			}
		}
	}

	function get_tags($slug = null)
	{
		$currentPage = Input::get('page',1);
		$perPage = IoC::resolve('site')->per_page;

		if (is_null($slug)) {
			$tags = Tag::take($perPage)->skip(($currentPage-1)*$perPage)->get();
			$data['tags'] = Paginator::make($tags,Tag::count(),$perPage);

			$this->layout->content = View::make('admin.tags',$data);
		} else {
			$tag= Tag::where('slug',$slug)->first();
			if (!$tag->exists) {
				return Response::error(404);
			}
			$data['name'] = $tag->name;
			$data['description'] = $tag->description;
			$this->layout->content = View::make('admin.tag',$data);
		}
	}

	function post_tags($slug)
	{
		$tag= Tag::where('slug',$slug)->first();
		if (!$tag->exists) {
			return Response::error(404);
		}
		$data = Input::all();
		Input::flash();

		$val = Validator::make($data,Tag::rules());
		if ($val->fails()) {
			return Redirect::to(URL::current())->with_errors($val);
		}

		try {
			$tag->update($data);
			return Redirect::to('admin/tags/'.Str::slug($data['name']))->with_errors(new Laravel\Messages([
				'name' => 'Tag successfully updated! '
			]));
		}catch (Exception $e) {
			if ($e->getCode() == 11000) {
				return Redirect::to(URL::current())->with_errors(new Laravel\Messages([
					'name' => 'Duplicate tag name, change it!!!'
				]));
			}
		}
	}

	/**
	 * Uncomment the lines if first time configuring.
	 * @return mixed
	 */
	function get_install()
	{
		// return Response::error(404);
		$username = '';
		$password = '';

		Post::connection()->execute(
			'db.users.insert({
				"username": "'.$username.'",
				"password": "'.Hash::make($password).'"
			})'
		);

		// To avoid duplicates
		Post::connection()->ensure_index(Post::$collection,'slug',['unique'=>true]);
		Tag::connection()->ensure_index(Tag::$collection,'slug',['unique'=>true]);

		$this->layout->content = '<div class="alert alert-info"><h4>Installation Successful</h4>. <p>Alright Sparky, start posting and blog rolling and whatever they call it!</div>';
	}
}