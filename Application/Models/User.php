<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/26/2017
 * Time: 6:11 PM
 */

namespace Application\Models;


class User extends BaseModel {
	protected $guarded = ['user_id'];
	protected $primaryKey='user_id';
}