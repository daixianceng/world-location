# LocList

全球地区选择插件（jQuery）

使用方式
-------
1.引入jQuery与LocList.js

2.创建表单：

    <form action="">
      <select id="country" name="country">
        <option value="1">中国</option>
          ...
        <option value="6891">中非共和国</option>
      </select>
      <select id="state" name="state"></select>
      <select id="city" name="city"></select>
    </form>

3.激活选择框：

    <script type="text/javascript">
    $.LocList({
      fields : ['#country', '#state', '#city'],
      topLevel : 'country',
      url : 'getLoc.php',
      preload : true,
      method : 'get'
    })
    </script>

参数说明
-------

* `fields` : 你所创建的选择框列表
* `topLevel` : 最高级地区类型，可以是country, state, city三种之一
* `url` : 通过ajax获取数据的url
* `preload` : 是否预装载数据
* `method` : ajax请求类型，get或post
