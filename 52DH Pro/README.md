
我爱导航（52DH Pro）是基于Github项目：https://github.com/Crogram/SiteHub 二次开发而来


后台功能：

支持修改网站信息
支持修改管理员信息
支持修改网站素材，如 logo/favicon 图标/微信二维码 等图片
支持添加/修改/删除导航
支持添加/修改/删除分类
支持添加/修改/删除站点
支持审核/删除/拒绝站点申请
支持发布/修改/删除公告
支持添加/修改/删除友情链接
前台特色：

所有分类下的站点
单个分类下的站点
各站点详情页
分类滚动定位
记录各站点浏览数
点赞功能（单个 IP 单个站点只能点赞一次）
站点详情页显示站点缩略图
站点炫酷跳转页
右下角悬浮按扭（去顶部/QQ/邮箱/微信二维码）
搜索功能（支持搜索站点名称/站点链接/站点简介）
访客申请站点收录功能
关于我们页面
站点图片懒加载
分类/站点链接别名
网站 Favicon 图标接口缓存
运行环境
Nginx/Apache、PHP 5.4+、MySQL 5.6+

部署方法
将 src 目录内文件全部上传到网站运行目录
访问网址 http://你的网站地址/install/
按照页面引导，输入数据库帐号及密码信息，提交安装
默认后台地址：http://你的网站地址/admin/ 默认账号：admin，默认密码：123456
然后服务器设置好伪静态规则
访问网站 OK


伪静态配置规则：
Nginx 伪静态规则


rewrite ^/index.html$ /index.php last;
rewrite ^/about.html$ /about.php last;
rewrite ^/search.html$ /search.php last;
rewrite ^/ranking.html$ /ranking.php last;
rewrite ^/apply.html$ /apply.php last;
rewrite ^/404.html$ /404.php last;
rewrite ^/category-([1-9]+[0-9]*).html$ /category.php?id=$1 last;
rewrite ^/category-([a-zA-Z]+).html$ /category.php?alias=$1 last;
rewrite ^/site-([1-9]+[0-9]*).html$ /site.php?id=$1 last;
rewrite ^/article.html$ /article.php last;
rewrite ^/article-list-([1-9]+[0-9]*).html$ /article_list.php?id=$1 last;
rewrite ^/article-([1-9]+[0-9]*).html$ /article_show.php?id=$1 last;
rewrite ^/img/favicon/(.*)$ /favicon.php?url=$1 last;
rewrite ^/img/favicon/(.*).png$ /favicon.php?url=$1 last;
rewrite ^/img/preview/(.*).png$ /preview.php?url=$1 last;

location ~ "^/img/favicon/([^/]+)/?.png$" {
 try_files /$uri /$uri/ /favicon.php?url=$1;
}

location ~ "^/img/preview/([^/]+)/?.png$" {
 try_files /$uri /$uri/ /preview.php?url=$1;
}




Apache 伪静态规则

RewriteEngine On
RewriteBase /
RewriteRule ^index.html index.php [L,NC]
RewriteRule ^about.html about.php [L,NC]
RewriteRule ^search.html search.php [L,NC]
RewriteRule ^ranking.html ranking.php [L,NC]
RewriteRule ^article.html article.php [L,NC]
RewriteRule ^apply.html apply.php [L,NC]
RewriteRule ^404.html 404.php [L,NC]
RewriteRule ^category-([0-9]+).html category.php?id=$1 [L,NC]
RewriteRule ^category-([a-zA-Z]+).html category.php?alias=$1 [L,NC]
RewriteRule ^site-([0-9]+).html site.php?id=$1 [L,NC]
RewriteRule ^article-list-([0-9]+).html article_list.php?id=$1 [L,NC]
RewriteRule ^article-([0-9]+).html article_show.php?id=$1 [L,NC]
RewriteRule ^img/favicon/(.*)\.png$ favicon.php?url=$1 [L,NC]
RewriteRule ^img/preview/(.*)\.png$ preview.php?url=$1 [L,NC]




IIS 伪静态规则

<rewrite>
    <rules>
        <rule name="Imported Rule 1">
            <match url="^index.html$" ignoreCase="false" />
            <action type="Rewrite" url="index.php" />
        </rule>
        <rule name="Imported Rule 2">
            <match url="^about.html$" ignoreCase="false" />
            <action type="Rewrite" url="about.php" />
        </rule>
        <rule name="Imported Rule 3">
            <match url="^ranking.html$" ignoreCase="false" />
            <action type="Rewrite" url="ranking.php" />
        </rule>
        <rule name="Imported Rule 4">
            <match url="^article.html$" ignoreCase="false" />
            <action type="Rewrite" url="article.php" />
        </rule>
        <rule name="Imported Rule 5">
            <match url="^apply.html$" ignoreCase="false" />
            <action type="Rewrite" url="apply.php" />
        </rule>
        <rule name="Imported Rule 6">
            <match url="404.html$" ignoreCase="false" />
            <action type="Rewrite" url="404.php" />
        </rule>
        <rule name="Imported Rule 7">
            <match url="^search.html$" ignoreCase="false" />
            <action type="Rewrite" url="search.php" />
        </rule>
        <rule name="Imported Rule 8">
            <match url="^category-(.*).html$" ignoreCase="false" />
            <action type="Rewrite" url="category.php?id={R:1}" appendQueryString="false" />
        </rule>
        <rule name="Imported Rule 9">
            <match url="^category-(.*).html$" ignoreCase="false" />
            <action type="Rewrite" url="category.php?alias={R:1}" appendQueryString="false" />
        </rule>
        <rule name="Imported Rule 10">
            <match url="^site-(.*).html$" ignoreCase="false" />
            <action type="Rewrite" url="site.php?id={R:1}" appendQueryString="false" />
        </rule>
        <rule name="Imported Rule 11">
            <match url="^article-list-(.*).html$" ignoreCase="false" />
            <action type="Rewrite" url="article_list.php?id={R:1}" appendQueryString="false" />
        </rule>
        <rule name="Imported Rule 12">
            <match url="^article-(.*).html$" ignoreCase="false" />
            <action type="Rewrite" url="article_show.php?id={R:1}" appendQueryString="false" />
        </rule>
    </rules>
</rewrite>