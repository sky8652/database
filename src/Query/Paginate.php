<?php

namespace Waitmoonman\Database\Query;


use Waitmoonman\Database\Functions\Count;
use Waitmoonman\Database\Paginates\Page;
use Waitmoonman\Database\Schema\Builder;
use Waitmoonman\Database\Schema\Grammar;

class Paginate extends Grammar
{
    use Query;

    protected $page;

    public function __construct(Builder $builder)
    {
        parent::__construct($builder);

        $this->page = new Page();
    }

    /**
     * $pageSize, $pageNum
     */
    public function build(...$params)
    {
        $this->initPageParam(...$params);
        $this->setPageOption();

        // 开始查询数据
        $sql = $this->toSql();
        // 重组预处理 SQL 的参数（包括的where语句里的）
        $parameters = $this->compileParams();

        // 是否监听 SQL
        if (! empty($this->builder->listenHandle)) {
            $this->listenBuilderSql($sql, $parameters);
        }

        $this->page->data = $this->builder->getExecuteResults($sql, $parameters, 'query');

        // 数据转换一下
        return $this->page;
    }

    protected function initPageParam(...$params)
    {
        $this->page->page_size = $params[0];

        if (isset($params[1])) {
            $this->page->curr_page = $params[1];
        } else {
            $this->page->curr_page = isset($_GET['page']) ? $_GET['page'] : 1;
        }

        // 上一页 下一页
        $this->page->prev_page = $this->page->curr_page - 1;
        $this->page->next_page = $this->page->curr_page + 1;

        // 总页数
        $this->page->total = (new Count(clone $this->builder))->setAsName('count')->build()->count;

        // 最后一页  总数/每页数目
        $this->page->last_page = intval(ceil($this->page->total / $this->page->page_size));
    }

    protected function setPageOption()
    {
        $offset = ($this->page->curr_page - 1) * $this->page->page_size;
        $limit = $this->page->page_size;

        $this->builder->offset($offset);
        $this->builder->limit($limit);
    }
}
