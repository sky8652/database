 WaitMoonMan/ClassLibrary
===================================  
 ![gps](https://avatars0.githubusercontent.com/u/28035971?v=3&s=460 "gps")  
  

### 查询构造器
```php
<?php
     require 'DB.php';
     
     
     $config = [
                   'host' => 'localhost',
                   'database' => 'test',
                   'username' => 'root',
                   'password' => 'root',
                   'charset' => 'utf8',
               ];

     // 初始化配置  之后可以进行 CURD 了
     DB::initConfig($config);
    
    
     // 增
     DB::table('user')->insert(['user' => 'admin', 'pwd' => 'admin']);
     
     // 删
     DB::table('user')->where('user', '=', 'admin')->delete();
      
     // 查
     DB::find(1);
     DB::table('user')
         ->select(['user', 'pwd'])
         ->where('money', '>', '-1')
         ->AndWhere('login_count', '>', '-1')
         ->orderBy('money', 'desc')
         ->limit(2)
         ->get();
     
     // 改
     DB::table('user')->where('user', '=', 'admin')->update(['pwd' => 'admin999', 'money' => 999]);
     
     
     // 分页
     $pages = DB::table('user')
                 ->where('money', '>', 0)
                 ->paginate(10);

     // 获取可以直接使用的链接
     $pages->links;
     // 获取当前页的数据
     $pages->data;

/********************************************
 *  API 文档
 * 
 *  // 初始化数据库配置，参数必须完整
 *  DB::initConfig($config);
 * 
 *  // 获取 DB 实例
 *  DB DB::table(string $table_name);
 * 
 *  // 增 参数为 字段=>值 数组, 如 ['field' => 'value'], 成功返回插入后的 id,失败返回 false
 *  int DB::table(string $table_name)->insert(array $param);
 * 
 *  // 删 , 可链式操作， 返回受影响的行数
 *  int DB::table(string $table_name)->delete();
 * 
 *  // 查 find() 通常情况下传入 ID 便可，成功返回一维数组，失败返回 false
 *  array DB::table(string $table_name)->find(int $id [, string $primary]);
 *  // 查 可链式操作，成功返二维数组，失败返回 false
 *  array DB::table(string $table_name)->get();
 *  
 *  // 改, 可链式操作，参数为 字段=>值 数组, 如 ['field' => 'value'], 返回受影响的行数
 *  int DB::table(string $table_name)->update(array $param);
 * 
 *  // 分页 可链式操作， 参数为每页的记录条数，返回 StdClass 对象
 *  StdClass DB::table(string $table_name)->paginate(int $pageCount);
 *  // 返回的对象包含
 *  total=> 总记录条数
 *  page_size=> 每页记录数
 *  last_page=> 总共页数
 *  prev_page=> 上一页页码
 *  curr_page=> 当前页页码
 *  next_page=> 下一页页码
 *  next_page_url=> 上一页URL
 *  prev_page_url=> 下一页URL
 *  url=>           当前的URL
 *  links=>         生成兼容 bootstrap 的分页（可直接输出使用） 
 *  data=>          当前页的数据(数组形式，遍历)
 * 
*/
```