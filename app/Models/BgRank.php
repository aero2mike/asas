<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BgRank extends Model
{
    use HasFactory;
    protected $table = 'rank_bg';
    protected $primaryKey = 'char_id';
    public $timestamps  = false;


    public function scopeFilter($query, $filterType, $class, $querySearch)
    {

        $classes = explode(',', $class);
        // dd($filterType);
        $rankTypes = [
            "GW" => "rank_bg.win",
            "GT" => "rank_bg.tie",
            "GL" => "rank_bg.lost",
            "KC" => "rank_bg.kill_count",
            "DC" => "rank_bg.death_count",
            "DD" => "rank_bg.damage_done",
            "DR" => "rank_bg.damage_received",
            "GSS" => "rank_bg.support_skills_used",
            "WSS" => "rank_bg.wrong_support_skills_used",
            "TGH" => "rank_bg.healing_done",
            "TWH" => "rank_bg.wrong_healing_done",
            "HPP" => "rank_bg.hp_heal_potions",
            "SPP" => "rank_bg.sp_heal_potions",
            "YGU" => "rank_bg.yellow_gemstones",
            "RGU" => "rank_bg.red_gemstones",
            "BGU" => "rank_bg.blue_gemstones",
            "ACC" => "rank_bg.acid_demostration",
            "AU" => "rank_bg.ammo_used"
        ];
        $type = $rankTypes[$filterType] ?? null;
        
        if (!in_array('All', $classes)) {
            $query = $query->whereIn('char.class', $classes);
        }

        $query = $query->where('char.name', 'like', '%'.$querySearch.'%');
        $query = $query->orderBy($type, 'DESC');

        return $query;
    }
}
