<?php

namespace Application\Repositories\Contract;


use Application\Services\Database\DBConnection;

abstract class BaseRepository {
	protected static $model;

	public function find( int $id ) {
		return static::$model::find($id);
	}

	public function all() {
		return static::$model::all();
	}

	public function paginate( int $page = 1 ) {
		return static::$model::paginate();
	}

	public function delete( int $id ) {

		return static::$model::destroy([$id]);
	}

	public function create( array $data ) {
		return static::$model::create($data);
	}

	public function update( int $id, array $data ) {
		$item = self::find($id);
		return $item->update($data);
	}

	public function findBy(array $criteria,bool $single) {
		$query = static::$model::query();
		foreach ($criteria as $key => $value)
		{
			$query->where($key,$value);

		}
		return $single ? $query->first() : $query->get();
	}
}