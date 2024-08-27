# LP-ADMIN
------
## 一.目录结构
```
lpAdmin
└───application
|        └─── config
|               └─── config.php ----------------------数据库配置
|        └─── controllers ----------------------------控制器 
|               └─── admin ---------------------------后台 
|               └─── home  ---------------------------前台 
|        └─── models ---------------------------------模型  
|        └─── views ----------------------------------视图 
|               └─── admin ---------------------------后台 
|               └─── home  ---------------------------前台 
└───framework
│        └─── core
|               └─── Controller.class.php -----------控制器基类
|               └─── Framework.class.php  -----------框架核心类 
|               └─── Model.class.php ----------------模型基类 
│        └─── database
|               └─── Mysql.class.php ----------------数据库CURD函数库
│        └─── libraries -----------------------------扩展库（目前有PHPExcel、分页、验证码、阿里大鱼短信验证） 
│   
└───public ------------------------------------------公共文件  
│        └─── font  ---------------------------------字体文件  
│        └─── images --------------------------------图片  
│        └─── js    ---------------------------------js
│        └─── style ---------------------------------样式
│        └─── uploads  ------------------------------上传文件
└─── ueditor ----------------------------------------ueditor富文本编辑器上传文件  
│   
└───favicon.ico -------------------------------------网站头图标
└───index.php   -------------------------------------入口文件
```
* 本框架是引用smarty模板引擎的单层MVC框架，开发前需注意以下几点：
> * 需要修改/framework/core/Framework.class.php中的常量'BASE_SITE'（主机名），如："http://www.baidu.com/", <font color=#B00000 >注意：</font>最后的“/”不能省略，为方便编写可按需定义路径常量。![img](./screenshorts/1.png)
> * 根据不同需求，若要添加扩展，需将扩展核心类，在Framework.class.php中引用。

## 二.后台模块
> * 后台模块除登录页外，其余前端基于layui框架开发
### 1.登录页 
> * 纯手撸，未使用任何框架模板，做的不好勿喷

![login](./screenshorts/login.gif)
### 2.菜单设置
![menu](./screenshorts/menu2.gif)
### 3.角色设置、权限设置、后台账号
> * 添加角色，对不同角色设置不同的权限，该权限为是否对该角色显示某些菜单，如：对管理员以外的角色不显示系统设置内的菜单。
> * 添加后台账号时设置对应角色，不同角色具有不同权限

![role](./screenshorts/role.gif)
### 3.全局分类
![type](./screenshorts/type.gif)
### 4.Banner、广告、友情链接
> * 个人觉得layui的富文本编辑器过于简单，因此使用了Uediter，并自定义了工具栏，如有需要，可自行定义

![type](./screenshorts/banner.gif)

<video src="https://github.com/luohuam/LP-ADMIN/blob/master/screenshorts/test.mp4"> 
<video width="320" height="240">
  <source src="https://github.com/luohuam/LP-ADMIN/blob/master/screenshorts/test.mp4" type="video/mp4">  
  Your browser does not support the video tag.  
</video>

## 贡献
#### 有任何意见或建议都欢迎提 issue
