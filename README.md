 WaitMoonMan/database
===================================  
<p align="center">
<a href="https://packagist.org/packages/davidnineroc/database"><img src="https://travis-ci.org/DavidNineRoc/database.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/davidnineroc/database"><img src="https://styleci.io/repos/96854420/shield?branch=master" alt="Style CI" Version"></a>
<a href="https://packagist.org/packages/davidnineroc/database"><img src="https://poser.pugx.org/davidnineroc/database/downloads" alt="Downloads"></a>
<a href="https://packagist.org/packages/davidnineroc/database"><img src="https://poser.pugx.org/laravel/passport/license.svg" alt="License"></a>
</p> 

### 查询构造器
```php
<?php
     use Waitmoonman\Database\DB;
     
     require 'vendor/autoload.php';
     
     
     $config = [
                   'host' => 'localhost',
                   'database' => 'test',
                   'username' => 'root',
                   'password' => 'root',
                   'charset' => 'utf8',
               ];

     // 初始化配置  之后可以进行 CURD 了
     DB::addConnection($config);
    
    
     // 增
     $id = DB::table('users')->listenSql(
         function($sql, $params, $realSql){
             // do something
             var_dump($realSql);
         }
         , true
     )->insert(['name' => 'hello', 'email' => 'david@gmail.com', 'password' => '123456']);
     
     // 删
     $rowNum = DB::table('users')
         ->listenSql(
             function($sql, $params, $realSql){
                 // do something
                 var_dump($realSql);
             }
             , true
         )
         ->where('id', '>' ,10)
         ->where('login_count', 0)
         ->delete();
      
     // 查 ->find(1);
     $users = DB::table('users')->find([1, 2, 3]);
     // 构造查询条件
     $users = DB::table('users')
         ->listenSql(
                 function($sql, $params, $realSql){
                     // do something
                     var_dump($realSql);
                 }
                 , true
         )
         ->select('id', 'name', 'sex')
         ->where('id', '>' ,1)
         ->where('sex', 0)
         ->offset(1)
         ->limit(3)
         ->orderBy('id')
         ->orderBy('created_at', 'desc')
         ->get();
     
     // 改
     $rowNum = DB::table('users')
         ->where('id', '>' ,1)
         ->update(['name' => 'david']);
     
     
     // 分页
     $pages = DB::table('user')
                 ->where('money', '>', 0)
                 ->paginate(10);

     // 获取可以直接使用的链接
     $pages->links;
     // 获取当前页的数据
     $pages->data;