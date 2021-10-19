<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Section;
use Illuminate\Database\Seeder;

class GroupAndSectionColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupColors = array(
            "Jack"=> ["primary"=>"#1F5DCC","light"=>"#EEF4FF"],
            "Level Of Readiness"=> ["primary"=>"#1F5DCC","light"=>"#EEF4FF"],
            "Puter"=> ["primary"=>"#DE6926","light"=>"#F5EFEB"],
            "Banky"=> ["primary"=>"#10AB7B","light"=>"#E9F2EF"],
            "Brainy"=> ["primary"=>"#DE6926","light"=>"#F5EFEB"],
            "Temperate"=> ["primary"=>"#10AB7B","light"=>"#E9F2EF"]
        );

        /*foreach ( $groupColors as $group=>$color){
            Group::where('name', $group)->update(['result_color'=>json_encode($color)]);
        }*/

        $sectionData = array(
            "Competition"=> ["primary"=>"#000","light"=>"#000",'icon'=>'competition'],
            "Imagination"=> ["primary"=>"#7A9EDE","light"=>"#E2E6EC",'icon'=>'atom'],
            "Distraction"=> ["primary"=>"#000","light"=>"#000",'icon'=>'robot'],
            "Practice"=> ["primary"=>"#000","light"=>"#000",'icon'=>'practice'],
            "Demotivation"=> ["primary"=>"#7A9EDE","light"=>"#E2E6EC","icon"=>"focal-point"],
            "Sports And Games"=> ["primary"=>"#000","light"=>"#000",'icon'=>"ball"],
            "Music And Dance"=> ["primary"=>"#000","light"=>"#000","icon"=>'music'],
            "Asking Questions"=> ["primary"=>"#000","light"=>"#000",'icon'=>'question'],
            "Objective Thinking"=> ["primary"=>"#F1A355","light"=>"#F9E2BF",'icon'=>'thinking'],
            "Research And Experiment"=> ["primary"=>"#000","light"=>"#000",'icon'=>'search'],
            "Reflective Thinking"=> ["primary"=>"#F1A355","light"=>"#F9E2BF","icon"=>"reflective"],
            "Reading"=> ["primary"=>"#000","light"=>"#000",'icon'=>''],
            "Writing"=> ["primary"=>"#000","light"=>"#000",'icon'=>'writing'],
            "Fluency Of The Language Of Learning"=> ["primary"=>"#F1A355","light"=>"#F9E2BF",'icon'=>'language'],
            "Listening"=> ["primary"=>"#000","light"=>"#000",'icon'=>'ear'],
            "Memorisation And Cramming"=> ["primary"=>"#000","light"=>"#000",'icon'=>'brain'],
            "Humility"=> ["primary"=>"#000","light"=>"#000",'icon'=>'reflective'],
            "Ability To Admit And Correct Mistakes"=> ["primary"=>"#000","light"=>"#000",'icon'=>'exclaim'],
            "Self-discipline"=> ["primary"=>"#000","light"=>"#000",'icon'=>'idea-light']
        );

        foreach ($sectionData as $item=>$value){
            Section::where('name', $item)->update([
                'result_color'=>json_encode(['primary'=>$value['primary'],'light'=>$value['light']]),
                'icon'=>$value['icon'],
                'graph_description'=>$item.', Donec tristique, augue interdum vestibulum convallis, ante ex accumsan nisi, et condimentum massa tortor quis massa.'
            ]);
        }

    }
}
