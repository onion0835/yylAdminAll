<?php
    namespace app\api\middleware;

   use Closure;
   use think\facade\Db;
   use think\facade\Log;

   class SqlLogMiddleware
   {
       public function handle($request, Closure $next)
       {
           $response = $next($request);
           
           // 获取本次请求的所有SQL语句
           $sqlLog = Db::getLastSql();
           
           // 记录到日志文件
           Log::info('SqlLogMiddleware SQL日志: ' . json_encode($sqlLog));
           
           return $response;
       }
   }