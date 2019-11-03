<?php
/**
 * 数据类型维护
 * 特别注意：这里的数据类型包含但不限于常规数据类型，可能会存在系统自己定义的数据类型
 * @since   2017/03/01 创建
 * @author  zhaoxiang <zhaoxiang051405@gmail.com>
 */

namespace app\api\entity;

class DataType {

    const TYPE_STRING = 1;
    const TYPE_INTEGER = 2;
    const TYPE_FLOAT = 3;
    const TYPE_BOOLEAN = 4;
    const TYPE_FILE = 5;
    const TYPE_ENUM = 6;
    const TYPE_JSON = 7;
    const TYPE_OBJECT = 8;
    const TYPE_ARRAY = 9;
}
