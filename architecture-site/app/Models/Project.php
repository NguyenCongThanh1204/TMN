<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Project extends Model {
 protected $fillable=['category_id','title','slug','client_name','location','area_sqm','year','structural_type','timeline','cover_image','body_content','is_featured','status'];
 protected $casts=['is_featured'=>'boolean','area_sqm'=>'decimal:2'];
 public function category(): BelongsTo { return $this->belongsTo(ProjectCategory::class,'category_id'); }
 public function media(): HasMany { return $this->hasMany(ProjectMedia::class)->orderBy('sort_order'); }
 public function scopeFeatured($q){ return $q->where('is_featured',true); }
 public function getRouteKeyName(){return 'slug';}
}
