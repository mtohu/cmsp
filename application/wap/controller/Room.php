<?php
namespace app\wap\controller;

class Room extends Base
{
    /**
     * 获取小区楼栋
     */
    public function getBuildings()
    {
        $region = input('region');
        if(empty($region)){
            $this->error_data['ErrorMsg'] = 'region不能为空';
            return $this->error_data;
        }

        $buildings = \app\wap\logic\Room::getBuildings($region);
        $units = \app\wap\logic\Room::getUnits($region, $buildings[0]);
        $rooms = \app\wap\logic\Room::getRooms($region, $buildings[0], $units[0]);

        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data']['buildings'] = $buildings;
        $this->error_data['Data']['units'] = $units;
        $this->error_data['Data']['rooms'] = $rooms;
        return $this->error_data;
    }

    /**
     * 获取楼栋单元
     */
    public function getUnits()
    {
        $region = input('region');
        if(empty($region)){
            $this->error_data['ErrorMsg'] = 'region不能为空';
            return $this->error_data;
        }
        $building = input('building');
        if(empty($building)){
            $this->error_data['ErrorMsg'] = 'building不能为空';
            return $this->error_data;
        }

        $units = \app\wap\logic\Room::getUnits($region, $building);
        $rooms = \app\wap\logic\Room::getRooms($region, $building, $units[0]);

        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data']['units'] = $units;
        $this->error_data['Data']['rooms'] = $rooms;
        return $this->error_data;
    }

    /**
     * 获取楼栋单元
     */
    public function getRooms()
    {
        $region = input('region');
        if(empty($region)){
            $this->error_data['ErrorMsg'] = 'region不能为空';
            return $this->error_data;
        }
        $building = input('building');
        if(empty($building)){
            $this->error_data['ErrorMsg'] = 'building不能为空';
            return $this->error_data;
        }
        $unit = input('unit');
        if(empty($unit)){
            $this->error_data['ErrorMsg'] = 'unit不能为空';
            return $this->error_data;
        }

        $rooms = \app\wap\logic\Room::getRooms($region, $building, $unit);

        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data']['rooms'] = $rooms;
        return $this->error_data;
    }

}