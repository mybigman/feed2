<?php
/**
 * TODO:
 * 	- Pagination
 *  - Date Formatting in single and index
 */
class Home_Controller extends Base_Controller {

	public $layout = 'layouts.public';
	public $restful = true;

	function get_index()
	{
		$site = IoC::resolve('site');
		$currentPage = Input::get('page',1);
		$perPage = $site->per_page;

		$posts = Post::sort(['created_at'=>-1])->take($perPage)->skip(($currentPage-1)*$perPage)->get();
		try {
			$data['posts'] = Paginator::make($posts,Post::count(),$perPage);
		} catch (PageNotFoundException $e) {
			return Response::error(404);
		}		

		$this->layout->title = 'Home - '.$site->name;
		$this->layout->description = $site->description;
		$this->layout->content = View::make('home.index', $data);
	}

	function get_single($slug)
	{
		$data['post'] = Post::with('tags')->where('slug',$slug)->first();

		if (!$data['post']->exists) {
			return Event::first('404');
		}
		$data['post']->message = Cache::get('p.'.$data['post']->_id->{'$id'}, function() use ($data){
			Bundle::start('sparkdown');

			$content = Sparkdown\Markdown($data['post']->message);
			Cache::put('p.'.$data['post']->_id->{'$id'}, $content, 10000);

			return $content;
		});

		$this->layout->title = $data['post']->title.' - '.IoC::resolve('site')->name;
		$this->layout->description = strip_tags($data['post']->md_excerpt);
		$this->layout->content = View::make('home.single', $data);
	}

	function get_tag($slug)
	{
		$tag = Tag::where('slug',$slug)->first();

		if (!$tag->exists) {
			return Event::fire('404');
		}

		$site = IoC::resolve('site');
		$currentPage = Input::get('page',1);
		$perPage = $site->per_page;

		$posts = Post::sort(['created_at'=>-1])->take($perPage)->skip(($currentPage-1)*$perPage)->where('tag_ids',$tag->_id)->get();
		try {
			$data['posts'] = Paginator::make($posts,Post::count(),$perPage);
		} catch (PageNotFoundException $e) {
			return Event::fire('404');
		}		

		$data['title'] = $tag->name.' Articles';
		$this->layout->title = $tag->name.' Articles - '.$site->name;
		$this->layout->description = $tag->description;
		$this->layout->content = View::make('home.archive', $data);
	}

	public function get_rss()
	{
		$site = IoC::resolve('site');

		$data['title'] = $site->rss['title'];
		$data['description'] = $site->rss['description'];
		$data['posts'] = Post::sort(array('created_at'=>-1))->take(5)->get();
		return Response::make(
			View::make('tools.rss',$data)->render(),
			200,
			["Content-Type"=>"text/xml"]
		);
	}

}