<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

abstract class GearAbstractController extends Controller
{
    /**
     * Get local Splatdata JSON file(s)
     * 
     * @param string $dataType specify which data file to get ('Head', 'Clothes', 'Shoes', 'Skills', or 'All')
     * @return array|null array of the data, null if invalid string passed
     */
    public static function getSplatdata($dataType = 'All')
    {
        if ($dataType == 'All') {
            // get headgear, clothing, and shoes, AND skills data

            $headgears = Storage::disk('local')->get('splatdata/GearInfo_Head.json');
            $headgears = json_decode($headgears, true);

            $clothes = Storage::disk('local')->get('splatdata/GearInfo_Clothes.json');
            $clothes = json_decode($clothes, true);

            $shoes = Storage::disk('local')->get('splatdata/GearInfo_Shoes.json');
            $shoes = json_decode($shoes, true);

            $skills = Storage::disk('local')->get('splatdata/Skills.json');
            $skills = json_decode($skills, true);

            return [$headgears, $clothes, $shoes, $skills];
        }
        else if ($dataType == 'Skills') {
            // only get skills data

            $skills = Storage::disk('local')->get('splatdata/Skills.json');
            $skills = json_decode($skills, true);

            return $skills;
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
     * Get each skill from a gear piece (main, sub 1, sub 2, sub 3)
     * 
     * @param GearPiece $gearpiece
     * @return array 4 skill names
     */
    public function getGearPieceSkills($gearpiece)
    {
        if ($gearpiece === null) {
            return null;
        }


        // skills data array
        $skills = $this->getSplatdata('Skills');


        // get each skill
        $skillNames[] = $this->getSkillName($gearpiece, $skills, 'gear_piece_main');
        $skillNames[] = $this->getSkillName($gearpiece, $skills, 'gear_piece_sub_1');
        $skillNames[] = $this->getSkillName($gearpiece, $skills, 'gear_piece_sub_2');
        $skillNames[] = $this->getSkillName($gearpiece, $skills, 'gear_piece_sub_3');
        


        return $skillNames;
    }

    /**
     * Get a skill name from a gear piece
     * 
     * @param GearPiece $gearpiece
     * @param array $skills from the Splatdata skill file
     * @param string $col name of the column
     * 
     * @return string the skill name, or 'unknown' name
     */
    private function getSkillName($gearpiece, $skills, $col)
    {
        if ($gearpiece->$col !== null) {
            foreach ($skills as $skill) {
                if ($skill['id'] == $gearpiece->$col) {
                    return $skill['skill'];
                }
            }
        }
        else {
            return 'unknown';
        }
    }
}
