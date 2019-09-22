<?php

// 指定标准返回格式
function apiResponse($data = [], $code = 200, $message = ''){
    if(is_object($data)){
        $data = $data->toArray();
    }

    if(is_string($data)){
        $message = $data;
        $data = [];
    }
    $msg = $code == 200 ? '成功' : '失败';
    $requestId = request()->header('request_id');

    if(isset($data['current_page'])){
        $result = [
            'current' => $data['current_page'],
            'pageSize' => $data['per_page'],
            'total' => $data['total'],
            'list' => $data['data'],
        ];
    }else if(isset($data['meta']['pagination'])){
        $pagination = $data['meta']['pagination'];
        $result = [
            'current' => $pagination['current_page'],
            'pageSize' => $pagination['per_page'],
            'total' => $pagination['total'],
            'list' => $data['data'],
        ];
    }else{
        $result = $data;
    }

    $ret = [
        'code' => $code,
        'msg'  => $message ?: $msg,
        'result' => $result,
        'request_id' => $requestId,
    ];

    return response()->json($ret);
}


function sqlHumanRead($column){
    $ret = [];
    foreach($column as $field){
        $field = trim($field);
        $field = last(explode('.', $field));
        $field = last(explode(' ', $field));
        $ret[] = $field;
    }

    return $ret;
}

/**
 * 文件全局唯一id
 */
function fileUniqid()
{
    $prefix = "file";
    return session_create_id($prefix);
}

/**
 * 获取上传图片类型
 */
function fileUploadType($ext)
{
    $extArr = [
        'image' => ['gif', 'jpg', 'jpeg', 'png'],
        'zip'   => ['zip', 'rar'],
        'video' => ['mp4']
    ];

    foreach($extArr as $type => $list)
    {
        if(in_array($ext, $list)){
            return $type;
        }
    }

    return '';

}


if (!function_exists('last_sql')) {
    if (strtolower(config('app.env')) != 'production') {
        \DB::enableQueryLog();
    }
    /**
     * @desc 获取最新一条sql语句 例子: dd(last_sql(3));
     * @param  int     $count
     * @return array
     */
    function last_sql($count = 1)
    {
        $arrSql = \DB::getQueryLog();
        $total  = count($arrSql);
        $pos    = $total - $count;
        $pos    = $pos > 0 ? $pos : 0;

        $arrSql = array_slice($arrSql, $pos);

        return $arrSql;
    }
}

// 格式化单位
function byte_format($size, $dec = 2)
{
    $a   = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    $pos = 0;

    while ($size >= 1024) {
        $size /= 1024;
        $pos++;
    }

    return round($size, $dec) . ' ' . $a[$pos];
}


if (!function_exists('exportCsv')) {
    /**
     * 可以全部数据导出csv
     * @param $input
     * @param $callback
     * @param string $prefix
     */
    function exportCsv($input, $callback, $prefix = '')
    {
        $startExecTime = microtime(true);
        $filename      = $prefix . date('YmdHis') . '.csv'; //设置文件名

        header("Content-type: text/x-csv; charset=utf-8");
        header("Content-Disposition:attachment;filename=" . $filename);
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header('Expires:0');
        header('Pragma:public');

        $headArr  = array_values($input);
        $fieldArr = array_keys($input);

        $header = implode(',', $headArr);
        echo chr(0xEF) . chr(0xBB) . chr(0xBF);
        echo $header . PHP_EOL;// 输出第一行头信息

        $list  = true;
        while ($list) {
            $retFunc  = $callback();

            // 更简单地导出写法
            $list = $retFunc;
            if(!$list){
                continue;
            }

            $exeCount = 0;
            foreach ($list as $item) {
                $outputString = "";
                foreach ($fieldArr as $field) {
                    if ($item[$field] === "" || $item[$field] === null) {
                        $cellVal = " ";
                    } elseif (strpos($item[$field], '"') > -1) {
                        $cellVal = str_replace('"', '""', $item[$field]);
                    } else {
                        $cellVal = $item[$field];
                    }

                    if($cellVal == " "){
                        $outputString = $outputString . '"' . $cellVal . '",';
                    }else{
                        $outputString = $outputString . '"=""' . $cellVal . '""",';
                    }
                }
                $content = substr($outputString, 0, -1) . PHP_EOL;
                echo $content;

                $exeCount++;
                //重新刷新缓冲区
                if ($exeCount % 100 == 0) {
                    ob_flush();
                    flush();
                }
            }

        }

        $endExecTime = microtime(true);
        // \Think\Log::write($filename."导出文件" . $filename . "执行耗时：" . ($endExecTime - $startExecTime) . "s", 'INFO');
        exit;
    }
}