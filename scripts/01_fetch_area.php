<?php
$diseases = [
    '050' => '天花',
    'SARS' => '嚴重急性呼吸道症候群',
    '020' => '鼠疫',
    '071' => '狂犬病',
    '056' => '德國麻疹',
    '001' => '霍亂',
    '022' => '炭疽病',
    '080' => '流行性斑疹傷寒',
    '032' => '白喉',
    '0360' => '流行性腦脊髓膜炎',
    '0663b' => '西尼羅熱',
    '002' => '傷寒',
    '002a' => '副傷寒',
    '045' => '小兒麻痺症',
    '045a' => '急性無力肢體麻痺',
    '004' => '桿菌性痢疾',
    '006' => '阿米巴性痢疾',
    '061' => '登革熱',
    '084' => '瘧疾',
    '055' => '麻疹',
    'ZIKAV' => '茲卡病毒感染症',
    '0701' => '急性病毒性Ａ型肝炎',
    '0080' => '腸道出血性大腸桿菌感染症',
    '0786' => '漢他病毒出血熱',
    '4808' => '漢他病毒肺症候群',
    '010m' => '多重抗藥性結核病',
    'A920' => '屈公病',
    '044' => 'HIV感染(含母子垂直感染疑似個案)',
    '042' => '後天免疫缺乏症候群',
    '010' => '結核病',
    '030' => '漢生病',
    '033' => '百日咳',
    '037' => '破傷風',
    '0703' => '急性病毒性Ｂ型肝炎',
    '0705' => '急性病毒性Ｃ型肝炎',
    '070d' => '急性病毒性Ｄ型肝炎',
    '070e' => '急性病毒性Ｅ型肝炎',
    '072' => '流行性腮腺炎',
    '090' => '梅毒',
    '098' => '淋病',
    '3200' => '侵襲性ｂ型嗜血桿菌感染症',
    '4828' => '退伍軍人病',
    '7710' => '先天性德國麻疹症候群',
    '7713' => '新生兒破傷風',
    '0749' => '腸病毒感染併發重症',
    '0620' => '日本腦炎',
    '070x' => '急性病毒性肝炎未定型',
    '091' => '先天性梅毒',
    '0051' => '肉毒桿菌中毒',
    '0461' => '庫賈氏病',
    '100' => '鉤端螺旋體病',
    '1048' => '萊姆病',
    '025' => '類鼻疽',
    '0820' => '地方性斑疹傷寒',
    '0830' => 'Ｑ熱',
    'SFTS' => '發熱伴血小板減少綜合症',
    '0812' => '恙蟲病',
    '487a' => '流感併發重症',
    '052VC' => '水痘併發症',
    '021' => '兔熱病',
    '0412' => '侵襲性肺炎鏈球菌感染症',
    '0543' => '庖疹B病毒感染症',
    '130' => '弓形蟲感染症',
    '023' => '布氏桿菌病',
    '027' => '李斯特菌症',
    'NoCoV' => '中東呼吸症候群冠狀病毒感染症',
    '19CoV' => '嚴重特殊傳染性肺炎',
    '060' => '黃熱病',
    '0788' => '伊波拉病毒感染',
    '0788b' => '拉薩熱',
    '0788a' => '馬堡病毒出血熱',
    '0663a' => '裂谷熱',
    'NFluA' => '新型A型流感',
];

$cities = ['新北市', '台北市', '桃園市', '彰化縣', '基隆市', '宜蘭縣', '台中市', '高雄市', '屏東縣',
'南投縣', '台南市', '新竹市', '新竹縣', '雲林縣', '苗栗縣', '花蓮縣', '嘉義市', '嘉義縣', '連江縣', '金門縣', '台東縣', '澎湖縣',];

$params = [
    'pty_Q' => 'N',
    'pty_disease' => '',
    'position' => '1',
    'pty_period' => 'y',
    'pty_y_s' => date('Y'),
    'pty_y_e' => date('Y'),
    'pty_m_s' => '1',
    'pty_m_e' => date('n'),
    'pty_d_s' => '1',
    'pty_d_e' => date('j'),
    'pty_w_s' => '1',
    'pty_w_e' => date('W'),
    'pty_sickclass_value' => 'determined_cnt',
    'pty_immigration' => '0',
    'pty_date_type' => '3',
    'pty_level' => 'area',
    'region_name' => '',
];
function utf16urlencode($str)
{
    $str = mb_convert_encoding($str, 'UTF-16', 'UTF-8');
    $out = '';
    for ($i = 0; $i < mb_strlen($str, 'UTF-16'); $i++)
    {
        $out .= '%u' . strtoupper(bin2hex(mb_substr($str, $i, 1, 'UTF-16')));
    }
    return $out;
}
$dataPath = dirname(__DIR__) . '/data/' . date('Y');
if(!file_exists($dataPath)) {
    mkdir($dataPath, 0777, true);
}

foreach ($diseases as $code => $disease) {
    $params['pty_disease'] = $code;
    $result = [];
    foreach($cities AS $city) {
        $result[$city] = [];
        $strParams = http_build_query($params) . utf16urlencode($city);
        $areas = exec("curl 'https://nidss.cdc.gov.tw/nndss/DiseaseMap_Pro' -H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:88.0) Gecko/20100101 Firefox/88.0' -H 'Accept: */*' -H 'Accept-Language: en-US,en;q=0.5' --compressed -H 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' -H 'X-Requested-With: XMLHttpRequest' -H 'Origin: https://nidss.cdc.gov.tw' -H 'Connection: keep-alive' -H 'Referer: https://nidss.cdc.gov.tw/nndss/DiseaseMap?id=19CoV' -H 'Save-Data: on' -H 'Pragma: no-cache' -H 'Cache-Control: no-cache' -H 'TE: Trailers' --data-raw '{$strParams}'");
        $areas = json_decode($areas, true);
        foreach($areas AS $area) {
            $result[$city][$area['code']] = $area['value'];
        }
    }
    file_put_contents($dataPath . '/' . $code . '.json', json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
