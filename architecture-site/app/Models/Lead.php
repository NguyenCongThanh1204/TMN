<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Lead extends Model {
 protected $fillable=['type','full_name','phone','email','project_type','estimated_budget','attachment_path','position','message','status'];
}
