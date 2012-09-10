<?php
class Post extends Mongor\Model {

	public static $collection = 'posts';
	
	static function rules()
	{
		return [
			'title' => 'required',
			'message' => 'required',
			'tags' => 'required'

		];
	}

	static function create(array $data)
	{
		$document = new static;

		foreach ($data as $datum => $value) {
			$document->$datum = $value;
		}

		return $document->save(['safe'=>true]);
	}

	function tags()
	{
		return $this->has_one_or_many('Tag','tag_ids');
	}

	public function __get($key)
	{
		if (array_key_exists($key, $this->attributes))
		{
			return $this->attributes[$key];
		}
		// Is the requested item a model relationship that has already been loaded?
		// All of the loaded relationships are stored in the "ignore" array.
		elseif (array_key_exists($key, $this->ignore))
		{
			return $this->ignore[$key];
		}
		// Is the requested item a model relationship? If it is, we will dynamically
		// load it and return the results of the relationship query.
		elseif (method_exists($this, $key))
		{
			$query = $this->$key();
			return $this->ignore[$key] = (in_array($this->relating, array('has_one', 'belongs_to'))) ? $query->first() : $query->get();
		}

		elseif ($key == 'md_excerpt') {
			return Cache::get('e.'.$this->_id->{'$id'},function() {
				Bundle::start('sparkdown');
				$excerpt = Sparkdown\Markdown($this->excerpt);
				Cache::put('e.'.$this->_id->{'$id'},$excerpt,10000);
				return $excerpt;
			});
		}
	}

}