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

    public function links()
    {
        // 判断上一页 下一页是否可用
        $page = [
            'is_prev_page' => '',
            'is_next_page' => '',
            'content_page' => ''
        ];
        // 显示的按钮数目  大于五页就显示5页，否则就显示总共有多少页
        $showCount = $this->last_page >= 5 ? 5 : $this->last_page;
        $left = $this->curr_page - (int)($showCount - 1)/2;
        if ($left < 1)
        {
            $left = 1;
        }
        elseif($left + $showCount >= $this->last_page)
        {
            $left = $this->last_page - $showCount + 1;
        }
        $right = $left + $showCount - 1;
        // 后面的2个
        for ($i = $left; $i <= $right; ++$i)
        {
            $active = '';
            if ($i == $this->curr_page)
            {
                $active = 'active';
            }
            $page['content_page'] .= "<li class='{$active}'><a href='{$this->url}?page={$i}'>{$i}</a></li>";
        }
        // 第一页的时候
        $first_home_label = 'a';
        $last_end_label = 'a';
        if ($this->curr_page <= 1)
        {
            $page['is_prev_page'] = 'disabled';
            $first_home_label = 'span';
        }
        // 如果下一页大于最后一页
        if ($this->curr_page >= $this->last_page)
        {
            $page['is_next_page'] = 'disabled';
            $last_end_label = 'span';
        }
        $dom = <<<page
<ul class="pagination">
    <li class="{$page['is_prev_page']}">
        <{$first_home_label} href="{$this->url}?page=1">首页</{$first_home_label}>
    </li>
    <li class="{$page['is_prev_page']}">
        <{$first_home_label} href="{$this->prev_page_url}">&laquo;</{$first_home_label}>
    </li>
        {$page['content_page']}
    <li class="{$page['is_next_page']}">
        <{$last_end_label} href="{$this->next_page_url}">&raquo;</{$last_end_label}>
    </li>
    <li class="{$page['is_next_page']}">
        <{$last_end_label} href="{$this->url}?page={$this->last_page}">尾页</{$last_end_label}>
    </li>
</ul>
page;

        return $dom;
    }
}