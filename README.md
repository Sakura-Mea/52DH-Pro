# 52DH Pro

#### ✨ 介绍
我爱导航系统(52DH Pro网址导航系统)是基于SiteHub二次开发的开源免费的网址导航系统，拥有独立前台和拟态风格的后台管理中心。
我爱导航系统(52DH Pro网址导航系统)集合网上优质网站网址导航，支持前台自主提交收录、自动获取TDK与网站Icon与后端审核管理，涵盖网站收录和文章发布等。

#### ⚠️ 注意：请下载52DH Pro安装包

#### 📌 部署环境
运行环境
Nginx/Apache、PHP建议7.4、MySQL 5.6+


#### 💡 安装教程

将52DH Pro压缩包上传到网站运行目录
访问域名安装
按照页面引导，输入数据库帐号及密码信息，提交安装
默认后台地址：http://域名/admin/
默认账号：admin，默认密码：123456
配置伪静态规则

#### 📙 伪静态规则

Nginx伪静态规则

```
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

```

Apache伪静态规则

```
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
```

IIS伪静态规则

```
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

```

#### 🚀 系统预览
![系统安装页](52DH%20Pro%2006.png)

![首页](52DH%20Pro%2001.png)

![后台登录页](52DH%20Pro%2002.png)

![后台管理页](52DH%20Pro%2003.png)

![提交收录页](52DH%20Pro%2005.png)


#### 🏄🏻‍♂️ 更新历程

```
V1.1.1
1.优化安装页面UI
2.美化后台界面UI为拟态风格
3.新增收录界面TDK信息获取和网站展示

V1.0.0
1. 所有分类下的站点
2. 单个分类下的站点
3. 各站点详情页
4. 分类滚动定位
5. 记录各站点浏览数
6. 点赞功能（单个 IP 单个站点只能点赞一次）
7. 站点详情页显示站点缩略图
8. 站点炫酷跳转页
9. 右下角悬浮按扭（去顶部/QQ/邮箱/微信二维码）
10. 搜索功能（支持搜索站点名称/站点链接/站点简介）
11. 访客申请站点收录功能
12. 关于我们页面
13. 站点图片懒加载
14. 分类/站点链接别名
15. 网站 Favicon 图标接口缓存
```


#### 原项目地址
https://github.com/Crogram/SiteHub


#### 🥳 联系我们
博客地址：https://www.sukuy.com

QQ交流群：884250547

#### ❌ 声明
1.本程序仅供个人合法用途使用与研究，切勿用于违反法律法规的场景.
2.由此造成的一切后果由使用者承担，系统维护方不为使用者承担任何责任.

#### 参与贡献

1.  Fork 本仓库
2.  新建 Feat_xxx 分支
3.  提交代码
4.  新建 Pull Request


#### 特技

1.  使用 Readme\_XXX.md 来支持不同的语言，例如 Readme\_en.md, Readme\_zh.md
2.  Gitee 官方博客 [blog.gitee.com](https://blog.gitee.com)
3.  你可以 [https://gitee.com/explore](https://gitee.com/explore) 这个地址来了解 Gitee 上的优秀开源项目
4.  [GVP](https://gitee.com/gvp) 全称是 Gitee 最有价值开源项目，是综合评定出的优秀开源项目
5.  Gitee 官方提供的使用手册 [https://gitee.com/help](https://gitee.com/help)
6.  Gitee 封面人物是一档用来展示 Gitee 会员风采的栏目 [https://gitee.com/gitee-stars/](https://gitee.com/gitee-stars/)
