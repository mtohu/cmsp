<?php
namespace app\wap\logic;

use think\Db;

class Room
{
    /**
     * 获取所有区
     */
    public static function getRegions()
    {
        $regions = Db::name('cmp_room')
            ->group('region')
            ->column('region');
        return $regions;
    }

    /**
     * 获取小区栋
     */
    public static function getBuildings($region)
    {
        $buildings = Db::name('cmp_room')
            ->where('region', $region)
            ->group('building')
            ->column('building');
        return $buildings;
    }

    /**
     * 获取单元
     */
    public static function getUnits($region, $building)
    {
        $units = Db::name('cmp_room')
            ->where('region', $region)
            ->where('building', $building)
            ->group('unit')
            ->column('unit');
        return $units;
    }

    /**
     * 获取房间
     */
    public static function getRooms($region, $building, $unit)
    {
        $rooms = Db::name('cmp_room')
            ->field('id, unit, room_no')
            ->where('region', $region)
            ->where('building', $building)
            ->where('unit', $unit)
            ->group('room_no, id')
            ->select();
        return $rooms;
    }

}