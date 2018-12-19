<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 30.04.2016
 */

namespace models\_base;


interface iModel
{
    public static function tableName();
    public static function pkField();
    public static function connectionName();
    public function getPk();
}