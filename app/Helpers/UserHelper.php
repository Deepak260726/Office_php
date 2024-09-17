<?php

namespace App\Helpers;

use Carbon\CarbonTimeZone;

use App\User;
use Illuminate\Support\Collection;

use function Complex\add;

class UserHelper
{

    /**
     * Get Schedule
     *
     * @param  none
     * @return array
     */
    public static function getDomainList()
    {
        return [
            ['ASIA', 'ASIA'],
            ['EUROPE', 'EUROPE'],
            ['AFRICA', 'AFRICA'],
            ['OCEANIA', 'OCEANIA'],
            ['AMERICA', 'AMERICA'],
            ['USA', 'USA'],
        ];
    }



    /**
     * Get Company List
     *
     * @param  none
     * @return array
     */
    public static function getCompanyList()
    {
        return [
            ['CMA CGM', 'CMA CGM'],
            ['ANL', 'ANL'],
            ['APL', 'APL'],
            ['CNC', 'CNC'],
            ['CMA CGM Group', 'CMA CGM Group'],
        ];
    }



    /**
     * Get TimeZone List
     *
     * @param  none
     * @return array
     */
    public static function getTimeZoneList()
    {
        $tzlist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);

        $time_zones = new Collection();

        foreach ($tzlist as $item) {
            $obj = new \stdClass();

            $obj->id = $item;

            $tz = CarbonTimeZone::Create($item);
            $obj->name = '(GMT' . $tz->toOffsetName() . ') ' . $item . ' (' . strtoupper($tz->getAbbreviatedName()) . ')';

            $obj->offset = $tz->toOffsetName();
            $obj->abbreviated_name = strtoupper($tz->getAbbreviatedName());
            $obj->sort = strtoupper($tz->toOffsetName() . $item . $tz->getAbbreviatedName());

            $time_zones->push($obj);
        }

        return $time_zones->sortBy('sort');
    }



    /**
     * Get User Avatar
     *
     * @param  string first_name, string last_name
     * @return string html
     */
    public static function getUserAvatar($first_name, $last_name)
    {
        return '<div id="profileImage" class="bdrs-50p bgc-pink-500 m-0" data-toggle="tooltip" data-placement="top" title="' . $first_name . ' ' . $last_name . '">' . substr($first_name, 0, 1) . substr($last_name, 0, 1) . '</div>';
    }



    /**
     * Get User Project Team id
     *
     * @param  int user_id
     * @return int team_id
     */
    public static function getUserProjectTeamId($user_id)
    {
        if ($user_id == null)
            return null;
        
        $user = User::find($user_id);

        if ($user == null)
            return null;

        return $user->team;
    }
}
