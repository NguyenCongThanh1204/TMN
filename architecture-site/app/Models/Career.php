<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Career extends Model {
 protected $fillable=['job_title','department','location','salary_range','description','deadline','status'];
 protected $casts=['deadline'=>'date'];
 public function scopeOpen($q){return $q->where('status','open')->where(fn($x)=>$x->whereNull('deadline')->orWhereDate('deadline','>=',today()));}
}
