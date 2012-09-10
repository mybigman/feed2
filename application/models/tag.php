<?php
class Tag extends Mongor\Model {

	public static $collection = 'tags';

	static function create(array $data)
	{
		$document = new static;

		foreach ($data as $datum => $value) {
			$document->$datum = $value;
		}

		return $document->save(['safe'=>true]);
	}

	function update(array $data)
	{
		foreach ($data as $datum => $value) {
			$this->$datum = $value;
		}
		$this->slug = Str::slug($data['name']);
		$this->updated_at = new MongoDate;

		return $this->save(['safe'=>true]);
	}

	static function rules()
	{
		return [
			'name' => 'required',
			'description' => 'required'
		];
	}
}