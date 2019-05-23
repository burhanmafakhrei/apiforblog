<?php
namespace Application\Repositories;

use Application\Models\User;
use Application\Repositories\Contract\BaseRepository;

class UserRepository extends BaseRepository {

	protected static $model = User::class;


}