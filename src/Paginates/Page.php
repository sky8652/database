<?php

namespace Waitmoonman\Database\Paginates;


class Page
{
    public $total = 0;
        // 多少条记录一页
    public $page_size = 15;
        // 最后一页
    public $last_page = 0;

        // 上一页
    public $prev_page = 0;
        // 当前页
    public $curr_page = 0;
        // 下一页
    public $next_page = 0;

        // url
    public $url = '';
        // 数据
    public $data =[];
}