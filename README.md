# lottery-2021-54

2021北科大吾肆放歌使用的抽奖程序

---

基于 [simple-lottery](https://github.com/hunshcn/simple-lottery) 改的

内部元素的定位均按照设计图的百分比来做的，所以满屏的vh，其实用rem会好看一些

第几轮原本想用遮罩附颜色，但是技艺不精，有些问题

第三轮是手机号抽奖，所以有`data.php`用来上传手机号，解析csv文件然后直接写入`data.json`省的用数据库

手机号进行了前端的打码，第三轮结束之后点击完毕就能把结果显示出来

同时为了能够拿到`query params`，引了一个`VueRouter`进来，不是很好，不过也也无所谓了。
