<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    protected $casts = ['result_color'=>'json'];

    public function sections(){
        return $this->hasMany(Section::class, 'group_id')
            ->orderBy('name','asc');
    }

    public static function createNew($request){
        $new = self::firstOrCreate(
          ['name'=>ucwords(strtolower($request->name))],
          [
              'color'=>$request->color,
              'icon'=>$request->icon,
              'description'=>$request->description
          ]
        );
    }

    public function detail(){
        return [
          'id'=>$this->id,
            'name'=>$this->name,
            'color'=>$this->color,
            'icon'=>$this->icon,
            'description'=>$this->description,
        ];
    }

    public function allSections(){
        $data = [];
        $sections = Section::where('group_id', $this->id)
            ->orderBy('name', 'asc')->get();
        foreach ($sections as $section){
            $data[] = [
                'section_id'=> $section->id,
                'name'=> $section->name,
                'questions'=>$section->allQuestions()
            ];
        }
        return $data;
    }
    protected $hidden = ['deleted_at','created_at','updated_at'];

}
