<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    use SoftDeletes;
    protected $guarded =[];
    protected $casts =[ "recommendation"=>'integer'];

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function questionnaires(){
        return $this->hasMany(Questionnaire::class, 'section_id');
    }
    public function recommendationMessage(){
        return $this->belongsTo(Questionnaire::class, 'recommendation', 'id');
    }
    public static function createNew($name, $groupId, $description){
        $new = self::firstOrCreate(
            ['name'=>$name, 'group_id'=>$groupId],
            ['description'=>$description]
        );
    }

    public function schema(){
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'group'=>["id"=>$this->group->id, "name"=>$this->group->name, 'description'=>$this->description],
            'recommendation'=>['id'=>$this->recommendationMessage->id ?? '', 'recommendation'=>$this->recommendationMessage->question ?? ''],
            'description'=>$this->description
        ];
    }

    public function schemaWithResultRecommendation($sessionId, $finalResult=false){
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'group'=>["id"=>$this->group->id, "name"=>$this->group->name],
            'recommendation'=>$this->getRecommendation($sessionId, $this->recommendationMessage->id ?? null),
            'answer_recommendations'=> ($finalResult==false) ? [] : $this->getQuestionRecommendation($sessionId, $this->id),
             'description'=>$this->description
 ];
    }
    //get all questions that belongs to this section
    public function getQuestionRecommendation($sessionId, $sectionId){
        //get all questions in this section
        $questionnaireIds = Questionnaire::where('section_id', $sectionId)->pluck('id');
        if ($questionnaireIds == null)
            return null;
        //

        $recommendations = [];
        foreach ($questionnaireIds as $questionnaireId){
            $testRecord = DB::table('test_records')->where([['session_id', $sessionId], ['test_records.questionnaire_id', $questionnaireId]])
                ->join('questionnaire_weight_points','questionnaire_weight_points.id','=','test_records.answer')
                ->select('test_records.id','questionnaire_weight_points.remark')
                ->get();
            $recommendations[] = [
                'questionnaire_id'=>$testRecord[0]->id ?? '',
                'recommendation'=>$testRecord[0]->remark ?? ''
            ];
        }
        return $recommendations;
    }
    public function getRecommendation($sessionId, $recommendationId){
        //no recommendation question
        if ($recommendationId == null)
            return "";

        $testRecord = TestRecord::where([['session_id', $sessionId],['questionnaire_id', $recommendationId]])->first();
        if ($testRecord == null)
            return "";
        $weightPoint = QuestionnaireWeightPoint::find($testRecord->answer);
        return ($weightPoint == null) ? "" : $weightPoint->remark;
    }
    public function allQuestions(){
        $data = [];
        foreach ($this->questionnaires as $questionnaire){
            $data[] = [
                'questionnaire_id'=> $questionnaire->id,
                'question'=> $questionnaire->question,
                'weight_points'=>$questionnaire->allWeightPoints()
            ];
        }
        return $data;
    }

    protected $hidden = ['deleted_at','created_at','updated_at'];
}
