# webhook
```shell script
#!/bin/bash
echo ""
#输出当前时间
date --date='0 days ago' "+%Y-%m-%d %H:%M:%S"
echo "-------开始-------"
#判断宝塔WebHook参数是否存在
#服务器 git 项目路径
gitPath="/www/wwwroot/www.zcnki.com"
#码云项目 git 网址
gitHttp="https://github.com/13808796047/lianwen.git"

echo "路径：$gitPath"

#判断项目路径是否存在
if [ -d "$gitPath" ]; then
        cd $gitPath
        #判断是否存在git目录
        if [ ! -d ".git" ]; then
                echo "在该目录下克隆 git"
                git clone $gitHttp gittemp
                mv gittemp/.git .
                rm -rf gittemp 
        fi
        #拉取最新的项目文件
#git clean -f
        git pull
        echo "拉取完成"
        #执行npm
        #执行编译
        #npm run build
        #设置目录权限
        chown -R www:www $gitPath
        echo "-------结束--------"
        exit
else
        echo "该项目路径不存在"
        echo "End"
        exit
fi
```
###horizon
```shell script
php artisan horizon terminate 重启队列
```
