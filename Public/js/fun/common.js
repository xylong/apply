/**
 * 检查手机号
 * @param  {string||integer} data 手机号
 * @return {boolean}
 */
function checkPhone(data) {
	return /^((\(\d{2,3}\))|(\d{3}\-))?13\d{9}$/.test(data);
}

/**
 * 格式化时间
 * @param {string} fmt 时间戳或时间对象
 */
Date.prototype.Format = function (fmt) {
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
};

Date.prototype.compareCurrent = function () {
	var now = new Date();
	return this <  now ? false : true;
}

/**
 * 与当前时间比较
 * @param  {string} time 时间戳或日期格式或时间对象
 * @return {boolean}
 */
function lessCurrentTime(time) {
	var now = new Date();
	if (/([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8])))/.test(time)) {
		return time < now.Format("yyyy-MM-dd") ? true : false;
	}
	return time < now ? true : false;
}

/**
 * 计算日程结束时间
 * @param  {string} old   [旧时间(yyyy-MM-dd hh:mm:ss)]
 * @param  {integer} seconds [变动时间（秒）]
 * @return {string}         新时间
 */
function eventEnd(old, seconds) {
	var tmp = new Date(old);
	var m    = seconds % 3600,
		hour = (seconds - m) / 3600,
		minutes = m / 60;

	tmp.setHours(tmp.getHours() + hour);
	tmp.setMinutes(tmp.getMinutes() + minutes);
	return tmp.Format('yyyy-MM-dd hh:mm:ss');
}
