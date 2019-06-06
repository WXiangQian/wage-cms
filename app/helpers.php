<?php
/**
 * 全局函数调用文件
 */

/**
 * 冒泡排序（数组排序）
 * @param $array
 * @return bool
 *
 */
function bubbleSort($array)
{
    $count = count( $array);
    if ($count <= 0 ) return false;
    for($i=0 ; $i<$count; $i ++){
        for($j=$count-1 ; $j>$i; $j--){
            if ($array[$j] < $array [$j-1]){
                $tmp = $array[$j];
                $array[$j] = $array[ $j-1];
                $array [$j-1] = $tmp;
            }
        }
    }
    return $array;
}

/**
 * 快速排序（数组排序）
 * @param $array
 * @return bool
 *
 */
function quickSort($array)
{
    $count = count( $array);
    if ($count <= 0 ) return false;
    for($i=0 ; $i<$count; $i ++){
        for($j=$count-1 ; $j>$i; $j--){
            if ($array[$j] < $array [$j-1]){
                $tmp = $array[$j];
                $array[$j] = $array[ $j-1];
                $array [$j-1] = $tmp;
            }
        }
    }
    return $array;
}

/**
 * 加密手机号
 * @param $data
 * @return mixed
 */
function encryptedPhoneNumber($data)
{
    return substr_replace($data, '****', 3, 4);
}

/**
 * 加密身份证
 * @param $data
 * @return string
 */
function encryptedIdNumber($data)
{
    $start = substr($data, 0, 1);
    $end = substr($data, -1, 1);
    $asterisk = '****************';
    return $start . $asterisk . $end;
}

/**
 * 加密银行卡号
 * @param $data
 * @return string
 */
function encryptedBankCardNumber($data)
{
    $start = substr($data, 0, 1);
    $end = substr($data, -1, 1);
    $asterisk = '********';
    return $start . $asterisk . $end;
}

/**
 * 加密基本薪资
 * @param $data
 * @return string
 */
function encryptedBasicWage($data)
{
    return substr_replace($data, '****', 1, 5);
}

/**
 * 生成无限极分类树
 * @param $arr
 * @param string $primary
 * @param string $parentId
 * @return array
 */
function makeTree($arr,$primary = 'id', $parentId = 'pid'){
    $refer = [];
    $tree = [];
    foreach($arr as $k => $v){
        $refer[$v[$primary]] = & $arr[$k]; //创建主键的数组引用
    }
    foreach($arr as $k => $v){
        $pid = $v[$parentId];  //获取当前分类的父级id
        if($pid == 0){
            $tree[] = & $arr[$k];  //顶级栏目
        }else{
            if(isset($refer[$pid])){
                $refer[$pid]['sub'][] = & $arr[$k]; //如果存在父级栏目，则添加进父级栏目的子栏目数组中
            }
        }
    }
    return $tree;
}

/**
 * 距离换算
 * @param $distance 距离
 * @return string
 */
function distanceUnitTransform($distance)
{
    if ($distance < 1000) {
        // 距离取整百
        return intval($distance / 100) * 100 . "m";
    }


    if ($distance >= 1000) {
        // 精确到小数点后1位
        return  floor( ($distance / 1000 * 0.95)* 10 ) / 10 . "km";

    }

}
/**
 * 移除内容中的HTML标签
 * @param $string 内容
 * @param $sublen 长度
 * @return string
 */
function removeHtml($string, $sublen)
{
    $string = strip_tags($string);
    $string = preg_replace ('/\n/is', '', $string);
    $string = preg_replace ('/ |　/is', '', $string);
    $string = preg_replace ('/&nbsp;/is', '', $string);

    preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $t_string);
    if(count($t_string[0]) - 0 > $sublen) $string = join('', array_slice($t_string[0], 0, $sublen))."…";
    else $string = join('', array_slice($t_string[0], 0, $sublen));

    return $string;
}

/**
 * 从redis中取出手机号数据
 * @param $mobile 手机号
 * @param $type 类型
 * @return \Illuminate\Cache\CacheManager|mixed
 * @throws Exception
 */
function findSmsCacheValue($mobile, $type)
{
    //从缓存中拿到验证码sms中的数据
    $cacheKey = $mobile . '_' . $type;
    $cacheValue = cache($cacheKey);
    return $cacheValue;
}

/**
 * 当数字小于10000时，用0在左边补全
 * @param $num 数字
 * @return string
 */
function encryptNumber($num)
{
    $date = date('Ymd', time());
    $rand = rand(0,9);

    if ($num < 10000) {
        $num = str_pad($num,4,"0",STR_PAD_LEFT);
    }

    $num = $date.$num.$rand;
    return $num;
}