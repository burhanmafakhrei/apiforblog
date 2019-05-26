<?php

namespace Application\Repositories\Contract;




abstract class BaseRepository
{
    protected static $model;



    /*	public function find( int $id ) {
            return static::$model::FindByKey($id);
        }

        public function all() {
            return static::$model::All();
        }

        public function paginate( int $page = 1 ) {
            return static::$model::paginate();
        }

        public function delete( int $id ) {

            return static::$model::Delete([$id]);
        }

        public function create( array $data ) {
            //return static::$model::Save($data);
            return  static::$object->Save($data);
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
        }*/





    public function find($id)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE $this->primaryKey=$id LIMIT 1");
    }

    public function delete($id)
    {

    }

    public function update($id, $data)
    {

    }

    public function create($data)
    {
        return static::$model::Save($data);
    }
}

