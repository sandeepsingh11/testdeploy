<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

abstract class GearAbstractController extends Controller
{
    /**
     * Get local Splatdata JSON file(s)
     * 
     * @param string $dataType specify which data file to get ('Head', 'Clothes', 'Shoes', 'Skills', 'Weapons', or 'All'')
     * @return array|null array of the data, null if invalid string passed
     */
    public static function getSplatdata($dataType = 'All')
    {
        if ($dataType == 'All') {
            // get headgear, clothing, shoes, skills, AND weapons data

            $headgears = Storage::disk('local')->get('splatdata/GearInfo_Head.json');
            $headgears = json_decode($headgears, true);

            $clothes = Storage::disk('local')->get('splatdata/GearInfo_Clothes.json');
            $clothes = json_decode($clothes, true);

            $shoes = Storage::disk('local')->get('splatdata/GearInfo_Shoes.json');
            $shoes = json_decode($shoes, true);

            $skills = Storage::disk('local')->get('splatdata/Skills.json');
            $skills = json_decode($skills, true);
            
            $weapons = Storage::disk('local')->get('splatdata/WeaponInfo_Main.json');
            $weapons = json_decode($weapons, true);

            return [$headgears, $clothes, $shoes, $skills, $weapons];
        }
        else if ($dataType == 'Skills') {
            // only get skills data

            $skills = Storage::disk('local')->get('splatdata/Skills.json');
            $skills = json_decode($skills, true);

            return $skills;
        }
        else if ($dataType == 'Weapons') {
            // only get weapons

            $weapons = Storage::disk('local')->get('splatdata/WeaponInfo_Main.json');
            $weapons = json_decode($weapons, true);

            return $weapons;
        }
        else if ( ($dataType == 'Head') || ($dataType == 'Clothes') || ($dataType == 'Shoes') ) {
            // only get headgear, clothing, OR shoes data

            $gear = Storage::disk('local')->get('splatdata/GearInfo_' . $dataType . '.json');
            $skills = json_decode($gear, true);

            return $skills;
        }
        else {
            // invalid arg passed, return null

            return null;
        }
    }

    /**
     * Get each skill from a gear (main, sub 1, sub 2, sub 3)
     * 
     * @param Gear $gear
     * @return array 4 skill names
     */
    public function getGearSkills($gear)
    {
        if ($gear === null) {
            return null;
        }


        // skills data array
        $skills = $this->getSplatdata('Skills');


        // get each skill
        $skillNames[] = $this->getSkillName($gear, $skills, 'gear_main');
        $skillNames[] = $this->getSkillName($gear, $skills, 'gear_sub_1');
        $skillNames[] = $this->getSkillName($gear, $skills, 'gear_sub_2');
        $skillNames[] = $this->getSkillName($gear, $skills, 'gear_sub_3');
        


        return $skillNames;
    }

    /**
     * Get a skill name from a gear
     * 
     * @param Gear $gear
     * @param array $skills from the Splatdata skill file
     * @param string $col name of the column
     * 
     * @return string the skill name, or 'unknown' name
     */
    private function getSkillName($gear, $skills, $col)
    {
        if ($gear->$col !== null) {
            foreach ($skills as $skill) {
                if ($skill['id'] == $gear->$col) {
                    return $skill['skill'];
                }
            }
        }
        else {
            return 'unknown';
        }
    }
}
